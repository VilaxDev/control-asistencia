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
        $usuario = DB::table('usuario')->first('id');
        $id_usuario = $usuario->id;

        $diasLaborales = $request->input('dias_laborales');
        $diasLaboralesJson = json_encode($diasLaborales);

        DB::table('horario')->insert([
            'nom_horario' => $request->nom_horario,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'dias_laborales' => $diasLaboralesJson,
            'fecha_creacion' => Carbon::now(),
            'id_usuario' => $id_usuario,
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
        // Obtener el usuario por su ID
        $usuario = DB::table('usuario')->first('id');
        $id_usuario = $usuario->id;

        $diasLaborales = $request->input('dias_laborales');
        $diasLaboralesJson = json_encode($diasLaborales);

        DB::table('horario')->where('id', $id)->update([
            'nom_horario' => $request->nom_horario,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'dias_laborales' => $diasLaboralesJson,
            'id_usuario' => $id_usuario,
        ]);

        return redirect('admin/horarios')->with('success', 'El horario actualizado exitosamente.');
    }
}
