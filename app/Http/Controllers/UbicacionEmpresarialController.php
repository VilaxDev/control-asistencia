<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UbicacionEmpresarialController extends Controller
{
    public function index()
    {
        $ubicaciones = DB::table('empresa')->get();
        return view('admin.ubicacion', compact('ubicaciones'));
    }

    public function apiGetUbicacion()
    {
        $ubicacion = DB::table('empresa')->get();
        return response()->json($ubicacion);
    }

    public function create(Request $request)
    {

        // Obtener el usuario por su ID del primer administrador
        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        $request->validate([
            'direccion' => '',
            'latitud' => '',
            'longitud' => '',
            'rango' => '',
            'creador_por' => '',
        ]);

        DB::table('empresa')->insert([
            'direccion' => $request->direccion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'rango' => $request->rango,
            'creador_por' => $id_admin,
        ]);

        return redirect()->back()->with('success', 'Ubicación guardada correctamente');
    }

    public function update(Request $request, $id)
    {
        // Obtener el usuario por su ID del primer administrador
        $administrador = DB::table('usuario')
            ->where('rol', 'Administrador')
            ->first();

        $id_admin = $administrador->id;

        $request->validate([
            'direccion' => '',
            'latitud' => '',
            'longitud' => '',
            'rango' => '',
            'creador_por' => '',
        ]);

        DB::table('empresa')->where('id', $id)->update([
            'direccion' => $request->direccion,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'rango' => $request->rango,

        ]);

        return redirect()->back()->with('success', 'Ubicación actualizada correctamente');
    }
}
