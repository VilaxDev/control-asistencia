<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventosController extends Controller
{
    public function index()
    {
        $periodos = DB::table('periodo')->get();
        $eventos = DB::table('evento')->paginate(6);
        return view('admin.eventos', compact('eventos', 'periodos'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'fecha'       => 'required',
            'descripcion' => 'required',
            'id_periodo'  => '',
            'id_usuario'  => '',
        ]);

        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $periodo = DB::table('periodo')->first('id');
        $id_periodo = $periodo->id;

        $id_admin = $administrador->id;

        DB::table('evento')->insert([
            'fecha'       => $request->fecha,
            'descripcion' => $request->descripcion,
            'id_periodo'  => $id_periodo,
            'id_usuario'  => $id_admin,
        ]);

        return redirect()->back()->with('success', 'Evento creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha'       => 'required',
            'descripcion' => 'required',
            'id_periodo'  => '',
            'id_usuario'  => '',
        ]);

        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;


        $periodo = DB::table('periodo')->first('id');
        $id_periodo = $periodo->id;

        DB::table('evento')->where('id', $id)->update([
            'fecha'       => $request->fecha,
            'descripcion' => $request->descripcion,
            'id_periodo'  => $id_periodo,
            'id_usuario'  => $id_admin,
        ]);

        return redirect()->back()->with('success', 'Evento actualizado correctamente');
    }

    public function delete($id)
    {
        DB::table('evento')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Evento eliminado correctamente');
    }
}
