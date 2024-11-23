<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\HorarioController;

Route::post('/admin/api/colaborador/login', [AsistenciasController::class, 'login']);
Route::post('/admin/api/datos/update/colaborador/{id}', [AsistenciasController::class, 'actualizarDatos']);
Route::put('/admin/api/update/imei/usuario/{id}', [AsistenciasController::class, 'logout']);

Route::get('/admin/api/horarios', [HorarioController::class, 'api']);


Route::put('/admin/api/asistencias/manana', [AsistenciasController::class, 'updateLateAttendanceManana']);
Route::put('/admin/api/asistencias/tarde', [AsistenciasController::class, 'updateLateAttendanceTarde']);


//Registro de asistencia
Route::get('/admin/api/asistencias/estado/{colaboradorId}', [AsistenciasController::class, 'verificarEstadoActual']);
Route::post('/admin/api/asistencias/register', [AsistenciasController::class, 'register']);
Route::put('/admin/api/asistencias/update/{id}', [AsistenciasController::class, 'update']);

Route::post('/admin/api/justificacion/asistencia/colaborador/{id}', [AsistenciasController::class, 'JustificacionAsistencia']);
Route::post('/admin/api/verificar/email', [AsistenciasController::class, 'verificarEmail']);
Route::put('/admin/api/password/update', [AsistenciasController::class, 'updatePassword']);
