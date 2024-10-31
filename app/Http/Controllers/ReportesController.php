<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class ReportesController extends Controller
{

    public function index()
    {
        $datos_asistencia = DB::table('asistencia')
            ->select(
                DB::raw('DATE(fecha) as fecha'),
                DB::raw('SUM(CASE WHEN inasistencia = 0 THEN 1 ELSE 0 END) as total_asistencias'),
                DB::raw('SUM(CASE WHEN inasistencia = 1 THEN 1 ELSE 0 END) as total_inasistencias')
            )
            ->groupBy('fecha')
            ->get();

        return view('admin.reportes', compact('datos_asistencia'));
    }
}
