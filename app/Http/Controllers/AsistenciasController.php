<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class AsistenciasController extends Controller
{
    public function index()
    {
        $asistencias = DB::table('asistencia')
            ->join('colaborador', 'asistencia.colaborador_id', '=', 'colaborador.id')
            ->join('usuario', 'colaborador.usuario_id', '=', 'usuario.id')
            ->select('asistencia.*', 'colaborador.id as colaborador_id', 'usuario.nombre as usuario_nombre')
            ->paginate(10);

        return view('admin.asistencias', compact('asistencias'));
    }

    public function api()
    {
        $users = DB::table('usuario')->get();
        return response()->json($users, 200);
    }
    public function register(Request $request)
    {
        // Buscar el colaborador por ID
        $colaborador = DB::table('colaborador')->where('id', $request->colaborador_id)->first();

        if (!$colaborador) {
            return response()->json([
                'success' => false,
                'message' => 'Colaborador no encontrado.',
            ], 404);
        }

        $fechaActual = now()->format('Y-m-d');
        // Verificar si ya existe un registro para el colaborador en la fecha actual
        $asistenciaExistente = DB::table('asistencia')
            ->where('colaborador_id', $request->colaborador_id)
            ->where('fecha', $fechaActual)
            ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Ya existe un registro para hoy',
            ], 400);
        }

        $horaActual = now()->format('H:i:s');

        try {
            // Insertar la nueva asistencia y obtener su ID
            $asistenciaId = DB::table('asistencia')->insertGetId([
                'colaborador_id' => $request->colaborador_id,
                'fecha'          => $fechaActual,
                'hora_entrada'   => $horaActual,
                'hora_salida'    => '00:00:00',
                'tardanza'       => false,
                'justificada'    => false,
                'inasistencia'   => false,
            ]);

            // Retornar la respuesta con el ID de asistencia
            return response()->json([
                'type' => 'success',
                'message' => 'Asistencia registrada exitosamente',
                'id_asistencia' => $asistenciaId, // Usar el ID de asistencia generado
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la asistencia: ' . $e->getMessage()], 500);
        }
    }






    public function update(Request $request, $id)
    {
        // Verificar si el registro de asistencia existe
        $asistencia = DB::table('asistencia')->where('id', $id)->first();

        if (!$asistencia) {
            return response()->json(['success' => false, 'message' => 'Registro de asistencia no encontrado.'], 404);
        }

        // Verificar si la hora de salida ya fue registrada (si no es "00:00:00")
        if ($asistencia->hora_salida !== '00:00:00') {
            return response()->json(['success' => false, 'message' => 'Ya se ha registrado la salida para el día de hoy.'], 400);
        }

        // Obtener el colaborador_id de la asistencia
        $colaboradorId = $asistencia->colaborador_id;

        // Obtener el horario_id de la tabla colaborador
        $colaborador = DB::table('colaborador')->where('id', $colaboradorId)->first();

        if (!$colaborador) {
            return response()->json(['success' => false, 'message' => 'Colaborador no encontrado.'], 404);
        }

        // Obtener el horario de la tabla horario
        $horario = DB::table('horario')->where('id', $colaborador->horario_id)->first();

        if (!$horario) {
            return response()->json(['success' => false, 'message' => 'Horario no encontrado.'], 404);
        }

        // Obtener la hora de salida establecida en el horario
        $horaSalidaEstablecida = $horario->hora_salida; // Hora de salida según la tabla horario (formato H:i:s)

        // Hora de salida enviada desde el frontend
        $horaSalidaEnviada = $request->input('hora_salida');

        // Comparar si la hora de salida enviada es mayor a la hora de salida del horario
        if ($horaSalidaEnviada <= $horaSalidaEstablecida) {
            return response()->json([
                'type' => 'danger',
                'message' => 'La hora de salida registrada debe ser mayor a la hora de salida establecida en el horario.',
            ], 400);
        }

        // Actualizar la hora de salida si la validación es exitosa
        try {
            DB::table('asistencia')->where('id', $id)->update([
                'hora_salida' => $horaSalidaEnviada,
                // Otros campos que quieras mantener, como `tardanza`, `justificada`, etc.
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'data' => [
                    'id_asistencia' => $id,
                    'estado' => 'SALIDA_REGISTRADA',
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $horaSalidaEnviada,
                    'puede_registrar' => false,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la asistencia: ' . $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        // Obtener la asistencia con el id correspondiente
        $asistencia = DB::table('asistencia')
            ->where('id', $id)
            ->first();

        // Asegúrate de que la asistencia fue encontrada
        if (!$asistencia) {
            abort(404, 'Asistencia no encontrada');
        }

        // Obtener el colaborador relacionado a la asistencia
        $colaborador = DB::table('colaborador')
            ->where('id', $asistencia->colaborador_id)
            ->first();

        // Obtener el usuario relacionado al colaborador
        $usuario = DB::table('usuario')
            ->where('id', $colaborador->usuario_id)
            ->first();

        // Obtener el horario relacionado al colaborador
        $horario = DB::table('horario')
            ->where('id', $colaborador->horario_id)
            ->first();

        // Pasar los datos a la vista
        return view('admin.show_asistencia', [
            'asistencia' => $asistencia,
            'colaborador' => $colaborador,
            'usuario' => $usuario,
            'horario' => $horario,
        ]);
    }



    public function login(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar el usuario por correo electrónico
        $usuario = DB::table('usuario')->where('email', $request->email)->first();

        // Verificar si el usuario existe
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Verificar la contraseña
        if (!Hash::check($request->password, $usuario->password)) {
            return response()->json(['error' => 'Contraseña incorrecta'], 401);
        }

        // Verificar si ya hay un token activo
        if (!empty($usuario->token)) {
            return response()->json(['error' => 'Ya se ha iniciado sesión en otro dispositivo'], 409);
        }

        // Generar un nuevo token único para el usuario
        $token = Str::random(60);

        // Guardar el token en la base de datos
        DB::table('usuario')->where('id', $usuario->id)->update(['token' => $token]);

        // Buscar el colaborador asociado al usuario
        $colaborador = DB::table('colaborador')->where('usuario_id', $usuario->id)->first();

        // Si el colaborador no se encuentra
        if (!$colaborador) {
            return response()->json(['error' => 'Colaborador no encontrado'], 404);
        }

        // Buscar el horario asociado al colaborador
        $horario = DB::table('horario')->where('id', $colaborador->horario_id)->first();

        // Si el horario no se encuentra
        if (!$horario) {
            return response()->json(['error' => 'Horario no encontrado'], 404);
        }

        // Convertir dias_laborales a un array
        $diasLaborales = json_decode($horario->dias_laborales, true);
        if (!is_array($diasLaborales)) {
            $diasLaborales = [];
        }

        // Obtener el año actual
        $currentYear = date('Y');

        // Buscar el periodo actual basado en el año actual
        $periodo = DB::table('periodo')
            ->where('anio', $currentYear)
            ->first();

        // Si no existe periodo para el año actual
        if (!$periodo) {
            return response()->json(['error' => 'No se encontró un periodo activo para el año actual'], 404);
        }

        // Buscar los eventos asociados al periodo actual
        $eventos = DB::table('evento')
            ->where('periodo_id', $periodo->id)
            ->get();

        // Preparar los datos de respuesta
        $usuarioData = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'email' => $usuario->email,
            'rol' => $usuario->rol,
            'token' => $token, // Añadir el token generado a la respuesta
        ];

        $colaboradorData = [
            'id' => $colaborador->id,
            'tipo_contrato' => $colaborador->tipo_contrato,
            'fecha_inicio' => $colaborador->fecha_inicio,
            'fecha_fin' => $colaborador->fecha_fin,
            'tipo_colaborador' => $colaborador->tipo_colaborador,
        ];

        $horarioData = [
            'id' => $horario->id,
            'hora_entrada' => $horario->hora_entrada,
            'hora_salida' => $horario->hora_salida,
            'dias_laborales' => $diasLaborales,
        ];

        $periodoData = [
            'id' => $periodo->id,
            'anio' => $periodo->anio,
            'fecha_inicio' => $periodo->fecha_inicio,
            'fecha_fin' => $periodo->fecha_fin,
        ];

        $eventosData = $eventos->map(function ($evento) {
            return [
                'id' => $evento->id,
                'fecha' => $evento->fecha,
                'descripcion' => $evento->descripcion,
            ];
        });

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $usuarioData,
            'colaborador' => $colaboradorData,
            'horario' => $horarioData,
            'periodo' => $periodoData,
            'eventos' => $eventosData,
        ], 200);
    }



    public function updateToken($id)
    {
        try {
            // Buscar el usuario por el ID
            $usuario = DB::table('usuario')->where('id', $id)->first();

            // Verificar si el usuario existe
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Actualizar el campo 'token' a vacío y mantener los demás campos igual
            DB::table('usuario')->where('id', $id)->update([
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'token' => '',
                'password' => $usuario->password,
                'rol' => $usuario->rol,
                'fecha_creacion' => $usuario->fecha_creacion,  // Mantener el resto de campos sin cambios
            ]);

            return response()->json(['message' => 'Token actualizado correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el token: ' . $e->getMessage());

            return response()->json(['error' => 'Error al actualizar el token: ' . $e->getMessage()], 500);
        }
    }


    public function actualizarDatos($id)
    {
        // Buscar el colaborador por su ID
        $colaborador = DB::table('colaborador')->where('id', $id)->first();

        // Si el colaborador no se encuentra
        if (!$colaborador) {
            return response()->json(['error' => 'Colaborador no encontrado'], 404);
        }

        // Buscar el usuario asociado al colaborador
        $usuario = DB::table('usuario')->where('id', $colaborador->usuario_id)->first();

        // Si el usuario no se encuentra
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Buscar el horario asociado al colaborador
        $horario = DB::table('horario')->where('id', $colaborador->horario_id)->first();

        // Si el horario no se encuentra
        if (!$horario) {
            return response()->json(['error' => 'Horario no encontrado'], 404);
        }

        // Convertir dias_laborales a un array
        $diasLaborales = json_decode($horario->dias_laborales, true); // Asegúrate que está almacenado como JSON en la base de datos

        // Verificar que la conversión fue exitosa
        if (!is_array($diasLaborales)) {
            $diasLaborales = []; // Valor por defecto si no es un array
        }
        // Obtener el año actual
        $currentYear = date('Y');

        // Buscar el periodo actual basado en el año actual
        $periodo = DB::table('periodo')
            ->where('anio', $currentYear)
            ->first();

        // Si no existe periodo para el año actual
        if (!$periodo) {
            return response()->json(['error' => 'No se encontró un periodo activo para el año actual'], 404);
        }

        // Buscar los eventos asociados al periodo actual
        $eventos = DB::table('evento')
            ->where('periodo_id', $periodo->id)
            ->get();

        $empresa = DB::table('empresa')->first();

        // Preparar los datos del usuario para la respuesta
        $usuarioData = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'email' => $usuario->email,
            'rol' => $usuario->rol,
        ];

        // Preparar los datos del colaborador para la respuesta
        $colaboradorData = [
            'id' => $colaborador->id,
            'tipo_contrato' => $colaborador->tipo_contrato,
            'fecha_inicio' => $colaborador->fecha_inicio,
            'fecha_fin' => $colaborador->fecha_fin,
            'tipo_colaborador' => $colaborador->tipo_colaborador,
        ];

        // Preparar los datos del horario para la respuesta
        $horarioData = [
            'id' => $horario->id,
            'hora_entrada' => $horario->hora_entrada,
            'hora_salida' => $horario->hora_salida,
            'dias_laborales' => $diasLaborales,
        ];
        $periodoData = [
            'id' => $periodo->id,
            'anio' => $periodo->anio,
            'fecha_inicio' => $periodo->fecha_inicio,
            'fecha_fin' => $periodo->fecha_fin,
        ];

        $eventosData = $eventos->map(function ($evento) {
            return [
                'id' => $evento->id,
                'fecha' => $evento->fecha,
                'descripcion' => $evento->descripcion,
                // Agrega aquí más campos de eventos si los necesitas
            ];
        });


        // Devolver la respuesta con los datos del usuario, colaborador y horario
        return response()->json([
            'message' => 'Datos actualizados correctamente',
            'user' => $usuarioData,
            'colaborador' => $colaboradorData,
            'horario' => $horarioData,
            'periodo' => $periodoData,
            'eventos' => $eventosData,
        ], 200);
    }
}
