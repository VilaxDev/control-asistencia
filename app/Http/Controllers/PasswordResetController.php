<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{

    public function index()
    {
        return view('auth.reset_password');
    }

    // Verificar correo electrónico
    public function verifyEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = DB::table('usuario')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'El correo electrónico no está registrado.'], 404);
        }

        return response()->json(['message' => 'Correo electrónico verificado.']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the user by email
        $user = DB::table('usuario')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Update the password while preserving other existing user data
        DB::table('usuario')->where('email', $request->email)->update([
            'password' => Hash::make($request->password),
            'email' => $user->email,
            'apellidos' => $user->apellidos,
            'nombre' => $user->nombre,
            'rol' => $user->rol,
            'imei' => $user->imei,
            'fecha_creacion' => $user->fecha_creacion
        ]);

        return response()->json(['message' => 'Contraseña actualizada correctamente.']);
    }
}
