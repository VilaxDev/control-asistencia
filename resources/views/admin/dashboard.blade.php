@extends('layouts.app')
@section('content')
    <style>
        .border-card {
            border-radius: 10px;
            border: 1px solid #d8d9da;
        }
    </style>
    <div class="container">
        <h1 class="text-center">Dashboard</h1>
        <div class="row">
            <!-- Card de Resumen de Asistencia -->
            <div class="col-md-4 mb-4">
                <div class="card border-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Asistencia de Hoy</h5>
                            <i class="ti ti-users text-primary fs-6"></i>
                        </div>
                        <h2 class="card-text text-primary">{{ number_format($porcentajeAsistencia, 2) }}%</h2>
                        <p class="card-text">Total de asistencia de los colaboradores hoy.</p>
                        <a href="{{ url('admin/asistencias') }}" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Tardanzas -->
            <div class="col-md-4 mb-4">
                <div class="card border-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Tardanzas</h5>
                            <i class="ti ti-clock text-warning fs-6"></i>
                        </div>
                        <h2 class="card-text text-warning"> {{ $totalTardanzas }}</h2>
                        <p class="card-text">Número de tardanzas registradas hoy.</p>
                        <a href="#" class="btn btn-warning">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Inasistencias -->
            <div class="col-md-4 mb-4">
                <div class="card border-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Inasistencias</h5>
                            <i class="ti ti-user-x text-danger fs-6"></i>
                        </div>
                        <h2 class="card-text text-danger">{{ $totalInasistencia }}</h2>
                        <p class="card-text">Colaboradores ausentes hoy.</p>
                        <a href="#" class="btn btn-danger">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Justificaciones -->
            <div class="col-md-4 mb-4">
                <div class="card border-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Justificaciones</h5>
                            <i class="ti ti-notes text-info fs-6"></i>
                        </div>
                        <h2 class="card-text text-info">{{ $totalJustificaciones }}</h2>
                        <p class="card-text">Solicitudes de justificación recibidas hoy.</p>
                        <a href="#" class="btn btn-info">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Total de Colaboradores -->
            <div class="col-md-4 mb-4">
                <div class="card border-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Total de Colaboradores</h5>
                            <i class="ti ti-users text-success fs-6"></i>
                        </div>
                        <h2 class="card-text text-success">{{ $totalColaboradores }}</h2>
                        <p class="card-text">Colaboradores registrados en el sistema.</p>
                        <a href="{{ url('admin/colaboradores') }}" class="btn btn-success">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Card de Último Evento Registrado -->
            <div class="col-md-4 mb-4">
                <div class="card border-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Último Evento Registrado</h5>
                            <i class="ti ti-calendar-event text-success fs-6"></i>
                        </div>
                        <p class="card-text">Capacitación sobre seguridad laboral.</p>
                        <small class="text-muted">Fecha: 2024-10-25</small>
                        <div class="mt-2">
                            <a href="{{ url('admin/eventos') }}" class="btn btn-success">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
