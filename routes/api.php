<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\UbicacionEmpresarialController;

Route::post('/admin/api/colaborador/login', [AsistenciasController::class, 'login']);
Route::post('/admin/api/datos/update/colaborador/{id}', [AsistenciasController::class, 'actualizarDatos']);

Route::get('/admin/api/horarios', [HorarioController::class, 'api']);

Route::get('/admin/api/ubicacion', [UbicacionEmpresarialController::class, 'apiGetUbicacion']);

Route::put('/admin/api/asistencias/manana', [AsistenciasController::class, 'updateLateAttendanceManana']);
Route::put('/admin/api/asistencias/tarde', [AsistenciasController::class, 'updateLateAttendanceTarde']);


//Registro de asistencia
Route::get('/admin/api/asistencias/estado/{colaboradorId}', [AsistenciasController::class, 'verificarEstadoActual']);
Route::post('/admin/api/asistencias/register', [AsistenciasController::class, 'register']);
Route::put('/admin/api/asistencias/update/{id}', [AsistenciasController::class, 'update']);
