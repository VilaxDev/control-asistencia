<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        // Obtén el ID del usuario autenticado
        if (Auth::guard('admin')->check()) {
            $usuarioId = Auth::guard('admin')->id();
        } elseif (Auth::guard('supervisor')->check()) {
            $usuarioId = Auth::guard('supervisor')->id();
        } elseif (Auth::guard('colaborador')->check()) {
            $usuarioId = Auth::guard('colaborador')->id();
        }

        // Obtén el usuario autenticado de la base de datos
        $usuario = DB::table('usuario')->where('id', $usuarioId)->first();

        // Retorna la vista de perfil con el usuario
        return view('auth.perfil', compact('usuario'));
    }


    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuario,email,' . $id,
        ]);

        // Actualiza la información del usuario en la base de datos
        DB::table('usuario')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
        ]);

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente.');
    }
}
