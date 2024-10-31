@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Dashboard</h1>

        <div class="row">
            <!-- Card de Resumen de Asistencia -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Asistencia de Hoy</h5>
                        <h2 class="card-text text-primary">85%</h2>
                        <p class="card-text">Total de asistencia de los colaboradores hoy.</p>
                        <a href="#" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Tardanzas -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Tardanzas</h5>
                        <h2 class="card-text text-warning">15</h2>
                        <p class="card-text">Número de tardanzas registradas hoy.</p>
                        <a href="#" class="btn btn-warning">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Inasistencias -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Inasistencias</h5>
                        <h2 class="card-text text-danger">5</h2>
                        <p class="card-text">Colaboradores ausentes hoy.</p>
                        <a href="#" class="btn btn-danger">Ver Detalles</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Card de Justificaciones -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Justificaciones</h5>
                        <h2 class="card-text text-info">3</h2>
                        <p class="card-text">Solicitudes de justificación recibidas hoy.</p>
                        <a href="#" class="btn btn-info">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Total de Colaboradores -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Total de Colaboradores</h5>
                        <h2 class="card-text text-success">120</h2>
                        <p class="card-text">Colaboradores registrados en el sistema.</p>
                        <a href="#" class="btn btn-success">Ver Todos</a>
                    </div>
                </div>
            </div>

            <!-- Card de Último Evento Registrado -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Último Evento Registrado</h5>
                        <p class="card-text">Capacitación sobre seguridad laboral.</p>
                        <small class="text-muted">Fecha: 2024-10-25</small>
                        <a href="#" class="btn btn-secondary mt-2">Ver Detalles</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
