@extends('layouts.app')
@section('content')
    <!-- Modal create -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="modalTitleId">
                        <i class="fas fa-clock me-2"></i>Crear Nuevo Horario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('horarios.create') }}" method="POST">
                        @csrf
                        <!-- Sección de Información Básica -->
                        <div class="section-group mb-4">
                            <h6 class="text-primary mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Información Básica
                            </h6>
                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-semibold">Nombre del Horario</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-signature"></i>
                                    </span>
                                    <input type="text" class="form-control" name="nom_horario"
                                        placeholder="Ej: Horario Backend" required />
                                </div>
                                <small class="text-muted">Ingrese un nombre descriptivo para identificar este
                                    horario</small>
                            </div>
                        </div>

                        <!-- Sección de Horarios -->
                        <div class="section-group mb-4">
                            <h6 class="text-primary mb-3 border-bottom pb-2">
                                <i class="fas fa-hourglass-half me-2"></i>Configuración de Horario
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <x-input-time name="hora_entrada" label="Hora de Entrada" />
                                    <small class="text-muted">Hora de inicio de la jornada</small>
                                </div>
                                <div class="col-md-6">
                                    <x-input-time name="hora_salida" label="Hora de Salida" />
                                    <small class="text-muted">Hora de fin de la jornada</small>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Días Laborales -->
                        <div class="section-group">
                            <h6 class="text-primary mb-3 border-bottom pb-2">
                                <i class="fas fa-calendar-alt me-2"></i>Días Laborales
                            </h6>
                            <div class="dias-laborales p-3 bg-light rounded">
                                <x-checkbox-group name="dias_laborales" label="" />
                                <small class="text-muted d-block mt-2">Seleccione los días que aplican para este
                                    horario</small>
                            </div>
                        </div>

                        <div class="modal-footer border-top mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Guardar Horario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .section-group {
            position: relative;
        }

        .modal-header {
            border-bottom: 3px solid #0d6efd;
        }

        .dias-laborales {
            border: 1px solid #dee2e6;
        }

        .form-label {
            color: #444;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .text-primary {
            font-weight: 600;
        }

        small.text-muted {
            font-size: 0.75rem;
        }

        .modal-footer {
            background-color: #f8f9fa;
        }
    </style>
    <h1 class="text-center">Gestión de horarios ⚡</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
        Crear horario <i class="ti ti-circle-plus"></i>
    </button>

    <div class="row">
        @foreach ($horarios as $horario)
            <div class="col-md-4 mb-4">
                <div class="card p-4"
                    style="border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1" style="font-weight: 600; color: #333;">{{ $horario->nom_horario }}</h5>
                        </div>
                        <i class="ti ti-calendar-event text-dark" style="font-size: 50px"></i>
                    </div>

                    <hr style="border: 1px solid #e5e5e5;">

                    <div>
                        <p class="mb-1">Entrada:
                            <span class="badge bg-success-subtle text-success">
                                {{ date('g:i A', strtotime($horario->hora_entrada)) }}</span>
                        </p>
                        <p class="mb-1">Salida:
                            <span class="badge bg-danger-subtle text-danger">
                                {{ date('g:i A', strtotime($horario->hora_salida)) }}</span>
                        </p>
                    </div>

                    <hr style="border: 1px solid #e5e5e5;">

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @php
                            $diasLaborales = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
                            $diasSeleccionados = json_decode($horario->dias_laborales, true);
                            if (!is_array($diasSeleccionados)) {
                                $diasSeleccionados = [];
                            }
                        @endphp

                        @foreach ($diasLaborales as $dia)
                            @if (in_array($dia, $diasSeleccionados))
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px; font-size: 14px;">
                                    {{ strtoupper(substr($dia, 0, 1)) }}
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <hr style="border: 1px solid #e5e5e5;">

                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#modalEditUser{{ $horario->id }}">
                            <i class="ti ti-pencil"></i>
                        </button>

                        <!-- Modal para Editar Horario Laboral -->
                        <div class="modal fade" id="modalEditUser{{ $horario->id }}" tabindex="-1"
                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                            aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dm"
                                role="document">
                                <div class="modal-content">
                                    <!-- Encabezado del Modal -->
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white" id="modalTitleId">
                                            <i class="fas fa-clock me-2"></i>Modificar Horario Laboral
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Cerrar">
                                        </button>
                                    </div>

                                    <!-- Cuerpo del Modal -->
                                    <div class="modal-body">
                                        <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <!-- Sección de Información Básica -->
                                            <div class="section-group mb-4">
                                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                                    <i class="fas fa-info-circle me-2"></i>Información Básica
                                                </h6>
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label fw-semibold">Nombre del
                                                        Horario</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fa-solid fa-signature"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="nom_horario"
                                                            placeholder="Ej: Horario Backend"
                                                            value="{{ $horario->nom_horario }}" required />
                                                    </div>
                                                    <small class="text-muted">Ingrese un nombre descriptivo para
                                                        identificar este
                                                        horario</small>
                                                </div>
                                            </div>

                                            <!-- Sección de Horarios -->
                                            <div class="section-group mb-4">
                                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                                    <i class="fas fa-hourglass-half me-2"></i>Configuración de Horario
                                                </h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <x-input-time name="hora_entrada" label="Hora de Entrada"
                                                            value="{{ $horario->hora_entrada }}" />
                                                        <small class="text-muted">Hora de inicio de la jornada</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-input-time name="hora_salida" label="Hora de Salida"
                                                            value="{{ $horario->hora_salida }}" />
                                                        <small class="text-muted">Hora de fin de la jornada</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sección de Días Laborales -->
                                            <div class="section-group">
                                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                                    <i class="fas fa-calendar-alt me-2"></i>Días Laborales
                                                </h6>
                                                <div class="dias-laborales p-3 bg-light rounded">
                                                    <x-checkbox-group name="dias_laborales" label=""
                                                        :diasSeleccionados="json_decode($horario->dias_laborales, true)" />
                                                    <small class="text-muted d-block mt-2">Seleccione los días que aplican
                                                        para este
                                                        horario</small>
                                                </div>
                                            </div>


                                            <!-- Botones de Acción -->
                                            <div class="modal-footer border-top">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="button" class="btn btn-outline-danger">
                            <i class="ti ti-trash"></i> <!-- Icono de eliminar -->
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{ $horarios->links('pagination::bootstrap-5') }}
@endsection
