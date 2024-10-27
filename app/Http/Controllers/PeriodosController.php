<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodosController extends Controller
{
    public function index()
    {
        $periodos = DB::table('periodo')->paginate(6);
        return view('admin.periodos', compact('periodos'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'anio' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'creado_por' => '',
        ]);

        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        DB::table('periodo')->insert([
            'anio' => $request->anio,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'creado_por' => $id_admin,
        ]);

        return redirect()->back()->with('success', 'Periodo creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anio' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'creado_por' => '',
        ]);

        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        DB::table('periodo')->where('id', $id)->update([
            'anio' => $request->anio,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'creado_por' => $id_admin,
        ]);

        return redirect()->back()->with('success', 'Periodo actualizado correctamente');
    }

    public function delete($id)
    {
        DB::table('periodo')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Periodo eliminado correctamente');
    }
}
