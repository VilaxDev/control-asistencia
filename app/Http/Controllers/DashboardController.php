<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller

{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            // Obtener la fecha actual
            $fechaActual = Carbon::today();

            // Filtrar asistencias por la fecha actual
            $asistencias = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->get();

            $totalAsistencias = $asistencias->count();

            // Obtener el máximo ID de asistencias de la fecha actual
            $maxId = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->max('id');

            // Calcular el porcentaje de asistencias
            $porcentajeAsistencia = $totalAsistencias > 0 && $maxId > 0
                ? ($totalAsistencias / $maxId) * 100
                : 0;

            // Filtrar tardanzas e inasistencias por la fecha actual
            $totalTardanzas = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->where('tardanza', true)
                ->count();

            $totalInasistencia = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->where('inasistencia', true)
                ->count();

            // Filtrar justificaciones por la fecha actual
            $totalJustificaciones = DB::table('justificacion')
                ->whereDate('fecha', $fechaActual)
                ->count();

            // Total de colaboradores (independiente de la fecha)
            $totalColaboradores = DB::table('colaborador')->count();

            // Enviar datos a la vista
            return view('admin.dashboard', compact(
                'porcentajeAsistencia',
                'totalTardanzas',
                'totalJustificaciones',
                'totalInasistencia',
                'totalColaboradores'
            ));
        } elseif (Auth::guard('supervisor')->check()) {
            // Obtener la fecha actual
            $fechaActual = Carbon::today();

            // Filtrar asistencias por la fecha actual
            $asistencias = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->get();

            $totalAsistencias = $asistencias->count();

            // Obtener el máximo ID de asistencias de la fecha actual
            $maxId = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->max('id');

            // Calcular el porcentaje de asistencias
            $porcentajeAsistencia = $totalAsistencias > 0 && $maxId > 0
                ? ($totalAsistencias / $maxId) * 100
                : 0;

            // Filtrar tardanzas e inasistencias por la fecha actual
            $totalTardanzas = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->where('tardanza', true)
                ->count();

            $totalInasistencia = DB::table('asistencia')
                ->whereDate('fecha', $fechaActual)
                ->where('inasistencia', true)
                ->count();

            // Filtrar justificaciones por la fecha actual
            $totalJustificaciones = DB::table('justificacion')
                ->whereDate('fecha', $fechaActual)
                ->count();

            // Total de colaboradores (independiente de la fecha)
            $totalColaboradores = DB::table('colaborador')->count();

            // Enviar datos a la vista
            return view('admin.dashboard', compact(
                'porcentajeAsistencia',
                'totalTardanzas',
                'totalJustificaciones',
                'totalInasistencia',
                'totalColaboradores'
            ));
        }

        return redirect('/login');
    }
}
