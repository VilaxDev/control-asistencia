@extends('layouts.app')
@section('content')
    <!-- Modal para crear evento -->
    <div class="modal fade" id="createModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <!-- Header del modal -->
                <div class="modal-header bg-light-primary">
                    <h5 class="modal-title" id="createModalLabel">
                        <i class="ti ti-calendar-plus me-2"></i>Crear Evento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('eventos.create') }}" method="POST" id="createEventForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Campo Fecha -->
                        <div class="mb-4">
                            <label for="fecha" class="form-label fw-bold text-primary">
                                <i class="fas fa-calendar-day me-1"></i>Fecha
                            </label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha"
                                name="fecha" required min="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Campo Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold text-primary">
                                <i class="fas fa-align-left me-1"></i>Descripción
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                rows="4" placeholder="Ingrese una descripción detallada del evento..." required maxlength="500"></textarea>
                            <div class="form-text" id="descripcionHelp">
                                Máximo 500 caracteres
                            </div>
                        </div>

                        <!-- Campo Periodo -->
                        <div class="mb-3">
                            <label for="periodo_id" class="form-label fw-bold text-primary">
                                <i class="fas fa-clock me-1"></i>Periodo
                            </label>
                            <select class="form-select @error('periodo_id') is-invalid @enderror" id="periodo_id"
                                name="periodo_id" required>
                                <option value="">Seleccione un periodo</option>
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}">
                                        {{ $periodo->anio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Footer del modal -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="text-center mb-4">Gestión de Eventos ⚡</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Crear
            evento <i class="ti ti-circle-plus"></i></button>
        <div class="row">
            @foreach ($eventos as $evento)
                <div class="col-md-4 mb-3">
                    <div class="card h-100" style="border-radius: 15px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div class="text-center">
                                <h4 class="card-title" style="font-weight: bold; color: #5a5a5a;">Evento </h4>
                                <p class="card-text" style="font-size: 1.1rem; color: #9b9b9b;">
                                    {{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}
                                </p>
                            </div>
                            <div class="mb-0">
                                <p class="card-text text-center mb-2">
                                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}
                                </p>
                                <p class="card-text text-center">
                                    <strong>Descripción:</strong> {{ $evento->descripcion }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <!-- Botón Editar -->
                                <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#editModal-{{ $evento->id }}">
                                    <i class="ti ti-edit"></i>
                                </button>

                                <!-- Botón Eliminar -->
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $evento->id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmación -->
                    <div class="modal fade" id="deleteModal-{{ $evento->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel-{{ $evento->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel-{{ $evento->id }}">Confirmar
                                        Eliminación
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar el evento del
                                    <strong>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</strong>? Esta
                                    acción no se puede
                                    deshacer.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('eventos.delete', $evento->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal para editar -->
                <div class="modal fade" id="editModal-{{ $evento->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Editar Evento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('eventos.update', $evento->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nombre-{{ $periodo->id }}" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre-{{ $evento->id }}"
                                            name="nombre" value="{{ $evento->fecha }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha-{{ $evento->id }}" class="form-label">Fecha</label>
                                        <input type="date" class="form-control" id="fecha-{{ $evento->id }}"
                                            name="fecha" value="{{ $evento->fecha }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion-{{ $evento->id }}"
                                            class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion-{{ $evento->id }}"
                                            name="descripcion" value="{{ $evento->descripcion }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $eventos->links('pagination::bootstrap-5') }}
    </div>
@endsection
