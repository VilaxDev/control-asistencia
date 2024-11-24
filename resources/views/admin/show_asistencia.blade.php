@extends('layouts.app')

@section('content')
    <h3 class="display-5 mb-4 fw-bold">Detalles de Asistencia</h3>

    <div class="row g-4">
        <!-- Tarjeta de Información del Colaborador -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-user-circle fs-5 me-2 text-primary"></i>
                        <h5 class="card-title mb-0">Información del Colaborador</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Nombre Completo</small>
                        <div class="fs-5">{{ $usuario->nombre }} {{ $usuario->apellidos }}</div>
                    </div>
                    <div>
                        <small class="text-muted d-block">Email</small>
                        <div class="fs-5">{{ $usuario->email }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Horario -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-clock fs-5 me-2 text-primary"></i>
                        <h5 class="card-title mb-0">Horario Laboral</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Hora Entrada</small>
                            <div class="fs-5">{{ $horario->hora_entrada }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Hora Salida</small>
                            <div class="fs-5">{{ $horario->hora_salida }}</div>
                        </div>
                    </div>
                    <div>
                        <small class="text-muted d-block">Días Laborales</small>
                        <div class="fs-5">{{ $horario->dias_laborales }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Asistencia -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fa-regular fa-calendar-check fs-4 me-2 text-primary"></i>
                        <h5 class="card-title mb-0">Registro de Asistencia</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <small class="text-muted d-block">Fecha</small>
                                <div class="fs-5">{{ $asistencia->fecha }}</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Justificada</span>
                                <span
                                    class="badge {{ $asistencia->justificada ? 'bg-success' : 'bg-secondary' }}  rounded-pill">
                                    {{ $asistencia->justificada ? 'Sí' : 'No' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Tardanza</span>
                                <span
                                    class="badge {{ $asistencia->tardanza ? 'bg-warning' : 'bg-secondary' }}  rounded-pill">
                                    {{ $asistencia->tardanza ? 'Sí' : 'No' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span>Inasistencia</span>
                                <span
                                    class="badge {{ $asistencia->inasistencia ? 'bg-danger' : 'bg-secondary' }}  rounded-pill">
                                    {{ $asistencia->inasistencia ? 'Sí' : 'No' }}
                                </span>
                            </div>
                        </div>

                        @if ($justificacion)
                            <div class="col-md-6">
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1"> {{ $justificacion->motivo }}</h6>
                                        <p class="mb-0">
                                            {{ $justificacion->descripcion }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($asistencia->tardanza || $asistencia->inasistencia)
                            <div class="col-md-6">
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Atención Requerida</h6>
                                        <p class="mb-0">
                                            Este registro requiere revisión por parte del supervisor debido a
                                            {{ $asistencia->tardanza ? 'tardanza' : 'inasistencia' }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ url('admin/asistencias') }}" class="btn btn-primary"><i class="ti ti-arrow-back"></i> Volver</a>
        </div>
    </div>
@endsection
