<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller

{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            // Obtener todas las asistencias
            $asistencias = DB::table('asistencia')->get();

            $totalAsistencias = $asistencias->count();

            $maxId = DB::table('asistencia')->max('id');

            // Calcular el porcentaje de asistencias
            $porcentajeAsistencia = $totalAsistencias > 0 && $maxId > 0
                ? ($totalAsistencias / $maxId) * 100
                : 0;

            $totalTardanzas = DB::table('asistencia')->where('tardanza')->count();
            $totalInasistencia = DB::table('asistencia')->where('inasistencia')->count();
            $totalJustificaciones = DB::table('justificacion')->count();
            $totalColaboradores = DB::table('colaborador')->count();

            return view('admin.dashboard', compact('porcentajeAsistencia', 'totalTardanzas', 'totalJustificaciones', 'totalInasistencia', 'totalColaboradores'));
        } elseif (Auth::guard('supervisor')->check()) {
            // Obtener todas las asistencias
            $asistencias = DB::table('asistencia')->get();

            $totalAsistencias = $asistencias->count();

            $maxId = DB::table('asistencia')->max('id');

            // Calcular el porcentaje de asistencias
            $porcentajeAsistencia = $totalAsistencias > 0 && $maxId > 0
                ? ($totalAsistencias / $maxId) * 100
                : 0;

            $totalTardanzas = DB::table('asistencia')->where('tardanza')->count();
            $totalInasistencia = DB::table('asistencia')->where('inasistencia')->count();
            $totalJustificaciones = DB::table('justificacion')->count();
            $totalColaboradores = DB::table('colaborador')->count();

            return view('admin.dashboard', compact('porcentajeAsistencia', 'totalTardanzas', 'totalJustificaciones', 'totalInasistencia', 'totalColaboradores'));
        }

        return redirect('/login');
    }
}
