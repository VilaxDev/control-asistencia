<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = DB::table('horario')->paginate(3);
        return view('admin.horarios', compact('horarios'));
    }

    public function api()
    {
        $horarios = DB::table('horario')->get();
        return response()->json($horarios);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nom_horario' => 'required',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
            'dias_laborales' => 'required',
            'fecha_creacion' => '',
            'id_usuario' => '',
        ]);

        // Obtener el usuario por su ID
        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        $diasLaborales = $request->input('dias_laborales');
        $diasLaboralesJson = json_encode($diasLaborales);

        DB::table('horario')->insert([
            'nom_horario' => $request->nom_horario,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'dias_laborales' => $diasLaboralesJson,
            'fecha_creacion' => Carbon::now(),
            'id_usuario' => $id_admin,
        ]);

        return redirect('admin/horarios')->with('success', 'El horario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_horario' => 'required',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
            'dias_laborales' => 'required',
            'id_usuario' => '',
        ]);


        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        $diasLaborales = $request->input('dias_laborales');
        $diasLaboralesJson = json_encode($diasLaborales);

        DB::table('horario')->where('id', $id)->update([
            'nom_horario' => $request->nom_horario,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'dias_laborales' => $diasLaboralesJson,
            'id_usuario' => $id_admin,
        ]);

        return redirect('admin/horarios')->with('success', 'El horario actualizado exitosamente.');
    }

    public function delete($id)
    {
        // Verificar si el horario está asociado a algún colaborador
        $horarioAsociado = DB::table('colaborador')
            ->where('id_horario', $id)
            ->exists();

        if ($horarioAsociado) {
            return redirect('admin/horarios')->with('danger', 'No se puede eliminar el horario porque está asociado a un colaborador.');
        }

        // Si no está asociado, proceder a eliminar
        DB::table('horario')->where('id', $id)->delete();

        return redirect('admin/horarios')->with('success', 'El horario se eliminó exitosamente.');
    }
}
