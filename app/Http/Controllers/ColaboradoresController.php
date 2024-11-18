<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ColaboradoresController extends Controller
{
    public function index()
    {
        // Obtener toda la información de colaboradores de varias tablas
        $colaboradores = DB::table('usuario')
            ->join('colaborador', 'usuario.id', '=', 'colaborador.id_usuario')
            ->join('horario', 'colaborador.id_horario', '=', 'horario.id')
            ->where('usuario.rol', 'Colaborador')
            ->select(
                'usuario.id',
                'usuario.nombre',
                'usuario.apellidos',
                'usuario.email',
                'usuario.password',
                'usuario.rol',
                'usuario.fecha_creacion',
                'colaborador.estado',
                'colaborador.id',
                'colaborador.fecha_inicio',
                'colaborador.fecha_fin',
                'colaborador.tipo_contrato',
                'colaborador.tipo_colaborador',
                'colaborador.id_horario',
                'colaborador.id_usuario',
                'horario.nom_horario',
            )->paginate(8);

        $tipo_colaborador = DB::table('tipo_colaborador')->get();
        $horarios = DB::table('horario')->get();
        return view('admin.colaboradores', compact('colaboradores', 'tipo_colaborador', 'horarios',));
    }




    public function create(Request $request)
    {
        // Validar los datos del formulario
        // Preparar los datos para insertar el usuario
        $usuarioData = [
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
            'fecha_creacion' => Carbon::now(),
        ];

        // Insertar el usuario y obtener su ID
        $id_usuario = DB::table('usuario')->insertGetId($usuarioData);

        // Verificar que el usuario creador tiene el rol de Administrador
        $admin = DB::table('usuario')->first('id');
        $id_admin = $admin->id;


        // Verificar que el horario es válido
        $horario = DB::table('horario')->first('id');
        $id_horario = $horario->id;

        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();
        // Obtén el ID del primer administrador
        $id_admin = $administrador->id;


        // Preparar los datos para insertar el colaborador
        $colaboradorData = [
            'fecha_fin' => $request->fecha_fin,
            'fecha_inicio' => $request->fecha_inicio,
            'estado' => $request->estado,
            'tipo_contrato' => $request->tipo_contrato,
            'tipo_colaborador' => $request->tipo_colaborador,
            'id_usuario' => $id_usuario,
            'id_horario' => $id_horario,
            'creado_por' => $id_admin,
        ];

        // Insertar los datos del colaborador
        DB::table('colaborador')->insert($colaboradorData);

        // Redirigir a la lista de colaboradores
        return redirect('admin/colaboradores')->with('success', 'Colaborador creado con éxito');
    }


    public function update(Request $request, $id)
    {
        // Obtener el usuario asociado al colaborador usando el ID de colaborador
        $colaborador = DB::table('colaborador')->where('id', $id)->first();

        // Si no existe el colaborador, redirigir con error
        if (!$colaborador) {
            return redirect('admin/colaboradores')->with('error', 'Colaborador no encontrado');
        }

        // Preparar los datos para actualizar el usuario
        $usuarioData = [
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => $request->filled('password') ? bcrypt($request->password) : $colaborador->password, // Si no se cambia, mantener la contraseña actual
            'fecha_creacion' => $request->fecha_creacion,
        ];

        // Actualizar los datos del usuario
        DB::table('usuario')->where('id', $colaborador->usuario_id)->update($usuarioData);

        // Verificar que el usuario creador tiene el rol de Administrador
        $administrador = DB::table('usuario')->where('rol', 'Administrador')->first();
        $id_admin = $administrador->id;

        // Preparar los datos para actualizar el colaborador
        $colaboradorData = [
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado,
            'tipo_contrato' => $request->tipo_contrato,
            'tipo_colaborador' => $request->tipo_colaborador,
            'id_usuario' => $colaborador->usuario_id, // Mantener el usuario_id original
            'id_horario' => $request->horario_id,
            'creado_por' => $id_admin,
        ];

        // Actualizar los datos del colaborador
        DB::table('colaborador')->where('id', $id)->update($colaboradorData);

        // Redirigir a la lista de colaboradores con un mensaje de éxito
        return redirect('admin/colaboradores')->with('success', 'Colaborador actualizado con éxito');
    }
}
