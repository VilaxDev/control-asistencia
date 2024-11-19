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
            ->join('colaborador', 'asistencia.id_colaborador', '=', 'colaborador.id')
            ->join('usuario', 'colaborador.id_usuario', '=', 'usuario.id')
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

        $fechaActual = $request->fecha; // Fecha enviada en el request
        $horaEntradaRequest = $request->hora_entrada; // Hora enviada en el request

        // Convertir la hora enviada a un objeto Carbon
        $horaActual = \Carbon\Carbon::createFromFormat('H:i:s', $horaEntradaRequest);

        // Verificar si ya existe un registro para el colaborador en la fecha actual
        $asistenciaExistente = DB::table('asistencia')
            ->where('id_colaborador', $request->colaborador_id)
            ->where('fecha', $fechaActual)
            ->first();

        if ($asistenciaExistente) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Ya existe un registro para hoy',
            ], 400);
        }

        // Buscar el horario del colaborador    
        $horario = DB::table('horario')->where('id', $colaborador->id_horario)->first();

        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'Horario no encontrado para el colaborador.',
            ], 404);
        }

        // Convertir hora_entrada del horario a un objeto Carbon
        $horaEntradaHorario = \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_entrada);

        // Calcular los límites de tiempo para las validaciones
        $horaInicioPermitida = $horaEntradaHorario->copy()->subMinutes(20); // 10 minutos antes de la hora establecida
        $horaLimiteTardanza = $horaEntradaHorario->copy()->addMinutes(10);  // 10 minutos después de la hora establecida

        // Validar la hora enviada
        if ($horaActual->lt($horaInicioPermitida)) {
            return response()->json([
                'type' => 'danger',
                'message' => 'No puedes registrar asistencia antes del tiempo permitido.',
            ], 400);
        }

        $tardanza = false;
        $inasistencia = false;

        if ($horaActual->gt($horaLimiteTardanza)) {
            // Si es mayor a 10 minutos, marcar como tardanza o inasistencia según lo deseado
            $tardanza = true;
            if ($horaActual->gt($horaEntradaHorario->copy()->addMinutes(30))) {
                $inasistencia = true;
            }
        }

        try {
            // Insertar la nueva asistencia
            $asistenciaId = DB::table('asistencia')->insertGetId([
                'id_justificacion' => null,
                'id_colaborador' => $request->colaborador_id,
                'fecha'          => $fechaActual,
                'hora_entrada'   => $horaActual->format('H:i:s'),
                'hora_salida'    => '00:00:00',
                'tardanza'       => $tardanza,
                'justificada'    => false,
                'inasistencia'   => $inasistencia,
            ]);

            // Retornar la respuesta con el ID de asistencia
            return response()->json([
                'type' => 'success',
                'message' => 'Asistencia registrada exitosamente',
                'id_asistencia' => $asistenciaId,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al registrar la asistencia: ' . $e->getMessage()], 500);
        }
    }


    //Funcion para registar las salida de asistencia
    public function update(Request $request, $id)
    {

        $asistencia = DB::table('asistencia')
            ->where('id', $id)
            ->first();

        if (!$asistencia) {
            return response()->json(['success' => false, 'message' => 'Registro de asistencia no encontrado.'], 404);
        }

        if ($asistencia->hora_salida !== '00:00:00') {
            return response()->json(['success' => false, 'message' => 'Ya se ha registrado la salida para el día de hoy.'], 400);
        }

        $colaborador = DB::table('colaborador')
            ->where('id', $asistencia->id_colaborador)
            ->first();

        if (!$colaborador) {
            return response()->json(['success' => false, 'message' => 'Colaborador no encontrado.'], 404);
        }

        $horario = DB::table('horario')
            ->where('id', $colaborador->id_horario)
            ->first();

        if (!$horario) {
            return response()->json(['success' => false, 'message' => 'Horario no encontrado.'], 404);
        }

        $horaSalidaEnviada = $request->input('hora_salida');
        $horaSalidaEstablecida = $horario->hora_salida;

        if ($horaSalidaEnviada <= $horaSalidaEstablecida) {
            return response()->json([
                'type' => 'danger',
                'message' => 'La hora de salida registrada debe ser mayor a la hora de salida establecida en el horario.',
            ], 400);
        }

        try {
            // Prepare full update with all original fields
            $updateData = [
                'fecha' => $asistencia->fecha,
                'hora_entrada' => $asistencia->hora_entrada,
                'hora_salida' => $horaSalidaEnviada,
                'inasistencia' => $asistencia->inasistencia,
                'tardanza' => $asistencia->tardanza,
                'justificada' => $asistencia->justificada,
                'id_justificacion' => null,
                'id_colaborador' => $asistencia->id_colaborador,
            ];

            // Update attendance record
            DB::table('asistencia')->where('id', $id)->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Salida registrada exitosamente',
                'data' => [
                    'id_asistencia' => $id,
                    'id_colaborador' => $asistencia->id_colaborador,
                    'fecha' => $asistencia->fecha,
                    'hora_entrada' => $asistencia->hora_entrada,
                    'hora_salida' => $horaSalidaEnviada,
                    'estado' => 'SALIDA_REGISTRADA',
                    'puede_registrar' => false,
                    'id_justificacion' => null,
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
            'imei' => 'required'
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

        // Verificación y manejo del IMEI
        if (empty($usuario->imei)) {
            // Primera vez - guardar el IMEI manteniendo todos los campos
            DB::table('usuario')->where('id', $usuario->id)->update([
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'password' => $usuario->password,
                'rol' => $usuario->rol,
                'imei' => $request->imei,  // Actualizamos solo el IMEI
                'fecha_creacion' => $usuario->fecha_creacion,
            ]);
        } else if ($usuario->imei !== $request->imei) {
            // Si ya tiene un IMEI y es diferente al enviado
            return response()->json(['error' => 'Ya se ha iniciado sesión en otro dispositivo'], 409);
        } else {
            // Si el IMEI es igual al registrado, actualizar para mantener el registro
            DB::table('usuario')->where('id', $usuario->id)->update([
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'password' => $usuario->password,
                'rol' => $usuario->rol,
                'imei' => $usuario->imei,  // Mantenemos el mismo IMEI
                'fecha_creacion' => $usuario->fecha_creacion,
            ]);
        }



        // Buscar el colaborador asociado al usuario
        $colaborador = DB::table('colaborador')->where('id_usuario', $usuario->id)->first();

        // Si el colaborador no se encuentra
        if (!$colaborador) {
            return response()->json(['error' => 'Colaborador no encontrado'], 404);
        }

        // Buscar el horario asociado al colaborador
        $horario = DB::table('horario')->where('id', $colaborador->id_horario)->first();

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
            ->where('id_periodo', $periodo->id)
            ->get();

        // Preparar los datos de respuesta
        $usuarioData = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'email' => $usuario->email,
            'rol' => $usuario->rol,
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
                'imei' => null,
                'password' => $usuario->password,
                'rol' => $usuario->rol,
                'fecha_creacion' => $usuario->fecha_creacion,  // Mantener el resto de campos sin cambios
            ]);

            return response()->json(['message' => 'Imei actualizado correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el imei: ' . $e->getMessage());

            return response()->json(['error' => 'Error al actualizar el imei: ' . $e->getMessage()], 500);
        }
    }


    public function JustificacionAsistencia($id, Request $request)
    {
        // Verificar si el colaborador existe
        $colaborador = DB::table('colaborador')->where('id', $id)->first();

        if (!$colaborador) {
            // Retornar una respuesta en caso de que no se encuentre el colaborador
            return response()->json([
                'message' => 'El colaborador no existe.',
                'type' => 'danger'  // Tipo de mensaje para error
            ], 404);
        }

        // Verificar si ya existe una justificación para la fecha actual
        $fechaActual = now()->toDateString();
        $existingJustificacion = DB::table('asistencia')
            ->where('id_colaborador', $id)
            ->where('fecha', $fechaActual)
            ->where('justificada', true)  // Aseguramos que sea una justificación válida
            ->first();

        if ($existingJustificacion) {
            // Si ya existe una justificación para la fecha actual
            return response()->json([
                'message' => 'Ya existe una justificación para la fecha de hoy.',
                'type' => 'danger'  // Tipo de mensaje para error
            ], 404);
        }

        // Insertar datos en la tabla 'justificacion'
        $idJustificacion = DB::table('justificacion')->insertGetId([
            'motivo'      => $request->input('motivo'),
            'descripcion' => $request->input('descripcion'),
        ]);

        // Registrar los datos en la tabla 'asistencia'
        DB::table('asistencia')->insert([
            'id_colaborador' => $id,
            'id_justificacion' => $idJustificacion,
            'fecha'          => $fechaActual,
            'hora_entrada'   => '00:00:00',
            'hora_salida'    => '00:00:00',
            'tardanza'       => false,
            'justificada'    => true,
            'inasistencia'   => false,
        ]);

        // Respuesta exitosa
        return response()->json([
            'message' => 'Justificación de asistencia registrada con éxito.',
            'type' => 'success'  // Tipo de mensaje para éxito
        ], 200);
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
        $usuario = DB::table('usuario')->where('id', $colaborador->id_usuario)->first();

        // Si el usuario no se encuentra
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Buscar el horario asociado al colaborador
        $horario = DB::table('horario')->where('id', $colaborador->id_horario)->first();

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
            ->where('id_periodo', $periodo->id)
            ->get();



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
