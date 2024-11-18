<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoColaboradorController extends Controller
{
    public function index()
    {
        $tipo_colaborador = DB::table('tipo_colaborador')->paginate(4);
        return view('admin.tipos_colaborador', compact('tipo_colaborador'));
    }

    public function create(Request $request)
    {

        $usuario = DB::table('usuario')->first('id');
        $id_usuario = $usuario->id;

        $request->validate([
            'nombre'      => 'required',
            'imagen'      => 'required',
            'descripcion' => 'required',
            'id_usuario	' => '',
        ]);

        DB::table('tipo_colaborador')->insert([
            'nombre'      => $request->nombre,
            'imagen'      => $request->imagen,
            'descripcion' => $request->descripcion,
            'id_usuario'  => $id_usuario
        ]);

        return redirect('admin/tipos-colaborador')->with('success', 'Tipo colaborador creado exitosamente');
    }

    public function update(Request $request, $id)
    {

        $usuario = DB::table('usuario')->first('id');
        $id_usuario = $usuario->id;
        $request->validate([
            'nombre'      => 'required',
            'imagen'      => 'required',
            'descripcion' => 'required',
            'creado_por	' => '',
        ]);

        DB::table('tipo_colaborador')->where('id', $id)->update([
            'nombre'      => $request->nombre,
            'imagen'      => $request->imagen,
            'descripcion' => $request->descripcion,
            'creado_por'  => $id_usuario
        ]);

        return redirect('admin/tipos-colaborador')->with('success', 'Tipo colaborador actualizado exitosamente');
    }


    public function delete($id)
    {
        DB::table('tipo_colaborador')->where('id', $id)->delete();
        return redirect('admin/tipos-colaborador')->with('success', 'Tipo colaborador eliminado exitosamente');
    }
}
