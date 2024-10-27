<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    public function index()
    {
        $users =  DB::table('usuario')->paginate(10);
        return view('admin.usuarios', compact('users'));
    }
}
