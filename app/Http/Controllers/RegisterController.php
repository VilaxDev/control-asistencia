<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => '',
            'apellidos' => '',
            'email' => '',
            'password' => '',
            'rol' => '',
            'fecha_creacion' => '',
        ]);
        
        DB::table('usuario')->insert([
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'rol' => $request->input('rol'),
            'fecha_creacion' => Carbon::now(),
        ]);

        return redirect('login');
    }
}
