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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="ti ti-square-x"></i>
                            Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy"></i> Guardar</button>
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
        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @error('anio')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror


        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            Crear periodo <i class="ti ti-plus"></i></button>
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
                            <p class="mb-2">
                                <strong>Fecha de Inicio:</strong> {{ $periodo->anio }}-01-01
                            </p>
                            <p class="mb-4">
                                <strong>Fecha de Fin:</strong> {{ $periodo->anio }}-12-31
                            </p>

                            <div class="d-flex gap-2 justify-content-center">
                                <!-- Botón para abrir el modal -->
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
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
                                                <strong>{{ $periodo->anio }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                                                        class="ti ti-square-x"></i>
                                                    Cancelar</button>
                                                <form action="{{ route('periodos.delete', $periodo->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="ti ti-trash"></i>
                                                        Eliminar</button>
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
