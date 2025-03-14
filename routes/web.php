<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TipoColaboradorController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\PeriodosController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;




Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login/auth', [LoginController::class, 'auth'])->name('login.auth');
route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register/store', [RegisterController::class, 'store'])->name('register.store');


Route::get('/auth/reset_password', [PasswordResetController::class, 'index'])->name('auth.reset_password');
Route::post('/password/verify', [PasswordResetController::class, 'verifyEmail']);
Route::put('/password/update', [PasswordResetController::class, 'updatePassword'])->name('password.update');

Route::middleware('auth:admin,supervisor')->group(function () {

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Perfil
    Route::get('admin/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('admin/perfil/update/{id}', [PerfilController::class, 'update'])->name('perfil.update');

    //Periodos
    Route::get('admin/periodos', [PeriodosController::class, 'index'])->name('periodos.index');
    Route::post('admin/periodos/create', [PeriodosController::class, 'create'])->name('periodos.create');
    Route::put('admin/periodos/update/{id}', [PeriodosController::class, 'update'])->name('periodos.update');
    Route::delete('admin/periodos/delete/{id}', [PeriodosController::class, 'delete'])->name('periodos.delete');

    //Eventos
    Route::get('admin/eventos', [EventosController::class, 'index'])->name('eventos.index');
    Route::post('admin/eventos/create', [EventosController::class, 'create'])->name('eventos.create');
    Route::put('admin/eventos/update/{id}', [EventosController::class, 'update'])->name('eventos.update');
    Route::delete('admin/eventos/delete/{id}', [EventosController::class, 'delete'])->name('eventos.delete');

    //Usuarios
    Route::get('admin/users', [UsuariosController::class, 'index'])->name('users.index');
    //Calendario
    Route::get('admin/calendario', [CalendarioController::class, 'index'])->name('calendario.index');


    //Tipo Colaborador
    Route::get('admin/tipos-colaborador', [TipoColaboradorController::class, 'index'])->name('tipoColaborador.index');
    Route::post('admin/tipos-colaborador/create', [TipoColaboradorController::class, 'create'])->name('tipoColaborador.create');
    Route::put('admin/tipos-colaborador/update/{id}', [TipoColaboradorController::class, 'update'])->name('tipoColaborador.update');
    Route::delete('admin/tipos-colaborador/delete/{id}', [TipoColaboradorController::class, 'delete'])->name('tipoColaborador.delete');

    //Horario
    Route::get('admin/horarios', [HorarioController::class, 'index'])->name('horarios.index');
    Route::post('admin/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::put('admin/horarios/update/{id}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('admin/horarios/delete/{id}', [HorarioController::class, 'delete'])->name('horarios.delete');
    //Colaboradores
    Route::get('admin/colaboradores', [ColaboradoresController::class, 'index'])->name('colaboradores.index');
    Route::post('admin/colaboradores/create', [ColaboradoresController::class, 'create'])->name('colaboradores.create');
    Route::put('admin/colaboradores/update/{id}', [ColaboradoresController::class, 'update'])->name('colaborador.update');
    Route::get('admin/colaboradores/show/{id}', [ColaboradoresController::class, 'show'])->name('colaboradores.show');

    //Asistencias
    Route::get('admin/asistencias', [AsistenciasController::class, 'index'])->name('asistencias.index');
    Route::get('admin/asistencia/show/{id}', [AsistenciasController::class, 'show'])->name('asistencia.show');

    //Reportes
    Route::get('admin/reportes', [ReportesController::class, 'index'])->name('reportes.index');

    //Acerca de de
    Route::get('/admin/acerca-de', function () {
        return view('admin.acerca_de');
    })->name('acerca_de');
});

require __DIR__ . '/../routes/api.php';
