<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller

{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard');
        } elseif (Auth::guard('supervisor')->check()) {
            return view('admin.dashboard');
        } elseif (Auth::guard('colaborador')->check()) {
            return view('admin.dashboard');
        }

        return redirect('/login');
    }
}
