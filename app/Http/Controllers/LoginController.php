<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $usuario = DB::table('usuario')->where('email', $credentials['email'])->first();

        if ($usuario && Hash::check($credentials['password'], $usuario->password)) {
            // Determinamos el guard según el rol del usuario
            $guard = null;
            switch ($usuario->rol) {
                case 'Administrador':
                    $guard = 'admin';
                    break;
                case 'Supervisor':
                    $guard = 'supervisor';
                    break;
            }

            // Autenticamos el usuario usando el guard correspondiente
            if ($guard) {
                Auth::guard($guard)->loginUsingId($usuario->id);
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }
        }

        return Redirect::back()->withErrors([
            'email' => 'Las credenciales ingresadas son incorrectas. Por favor, intenta nuevamente.',
        ])->withInput($request->only('email'));
    }

    public function destroy(Request $request)
    {
        // Verificamos en cada guard si el usuario está autenticado y cerramos la sesión
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('supervisor')->check()) {
            Auth::guard('supervisor')->logout();
        } elseif (Auth::guard('colaborador')->check()) {
            Auth::guard('colaborador')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
