@extends('layouts.app')
@section('content')
    <!-- Modal para crear un nuevo Periodo -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Título del modal -->
                <div class="modal-header bg-light-primary">
                    <h5 class="modal-title" id="createModalLabel"> <i class="ti ti-calendar-plus me-2"></i>Crear Nuevo
                        Periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- Formulario para crear el periodo -->
                <form action="{{ route('periodos.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Campo para ingresar el año -->
                        <x-year-selector name="anio" label="Seleccione el Año" />
                    </div>

                    <!-- Botones de acción -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-close"></i>
                            Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar
                            Periodo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center mb-4">Gestion de Periodos ⚡</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @error('anio')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Crear
            periodo <i class="ti ti-circle-plus"></i></button>
        <div class="row">
            @foreach ($periodos as $periodo)
                <div class="col-md-4 mb-3">
                    <div class="card mb-4" style="border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="card-title m-0" style="font-size: 1.5rem; font-weight: 700; color: #2c3e50;">
                                    <i class="ti ti-calendar text-primary me-2"></i>
                                    {{ $periodo->anio }}
                                </h5>
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    Activo
                                </span>
                            </div>

                            <div class="d-flex gap-2 justify-content-center">
                                <!-- Botón Editar -->
                                <button class="btn btn-light-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal-{{ $periodo->id }}">
                                    <i class="ti ti-edit me-1"></i>
                                    Editar
                                </button>
                                <!-- Modal para editar -->
                                <div class="modal fade" id="editModal-{{ $periodo->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Editar Periodo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('periodos.update', $periodo->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="anio" class="form-label">Año del Periodo</label>
                                                        <input type="number" class="form-control" id="anio"
                                                            name="anio" value="{{ $periodo->anio }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                                            class="fa fa-close"></i>
                                                        Cancelar</button>
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="fa fa-save"></i> Guardar
                                                        Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón para abrir el modal -->
                                <button type="button" class="btn btn-light-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $periodo->id }}">
                                    <i class="ti ti-trash me-1"></i>
                                    Eliminar
                                </button>

                                <!-- Modal de confirmación -->
                                <div class="modal fade" id="deleteModal-{{ $periodo->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel-{{ $periodo->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-{{ $periodo->id }}">
                                                    Confirmar
                                                    Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar el periodo
                                                <strong>{{ $periodo->anio }}</strong>? Esta acción no se puede deshacer.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('periodos.delete', $periodo->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{ $periodos->links('pagination::bootstrap-5') }}
    </div>
@endsection
