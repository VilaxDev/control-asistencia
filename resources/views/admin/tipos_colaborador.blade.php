@extends('layouts.app')
@section('content')
    <!-- Modal para crear tipo de colaborador -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header bg-primary bg-opacity-10 border-bottom">
                    <h5 class="modal-title text-primary fw-semibold" id="modalTitleId">
                        <i class="ti ti-user-plus me-2"></i>
                        Nuevo Tipo de Colaborador
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('tipoColaborador.create') }}" method="POST">
                    @csrf
                    <!-- Cuerpo del modal con scroll -->
                    <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                        <!-- Alerta informativa -->
                        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4"
                            role="alert">
                            <div class="d-flex align-items-center flex-grow-1">
                                <i class="ti ti-info-circle me-2 fs-5"></i>
                                <div>
                                    Complete la información para crear un nuevo tipo de colaborador. Todos los campos son
                                    importantes para la correcta clasificación del personal.
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <!-- Campos del formulario -->
                        <div class="row g-4">
                            <!-- Nombre del tipo de colaborador -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="nombre" id="nombreColaborador"
                                        placeholder="Ej: Desarrollador Senior" required />
                                    <label for="nombreColaborador">
                                        <i class="ti ti-user-check me-1"></i>
                                        Tipo de Colaborador
                                    </label>
                                    <div class="form-text">
                                        Especifique el nombre representativo del colaborador
                                    </div>
                                </div>
                            </div>

                            <!-- URL de la imagen -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="url" class="form-control" name="imagen" id="imagenColaborador"
                                        placeholder="https://ejemplo.com/imagen.jpg" required />
                                    <label for="imagenColaborador">
                                        <i class="ti ti-photo me-1"></i>
                                        URL de la Imagen
                                    </label>
                                    <div class="form-text">
                                        Ingrese la URL de una imagen representativa para este tipo de colaborador
                                    </div>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" name="descripcion" id="descripcionColaborador" style="height: 100px"
                                        placeholder="Describa las responsabilidades y características" required></textarea>
                                    <label for="descripcionColaborador">
                                        <i class="ti ti-notes me-1"></i>
                                        Descripción del Rol
                                    </label>
                                    <div class="form-text">
                                        Detalle las responsabilidades, habilidades y características principales de este
                                        tipo de colaborador
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer del modal -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>
                            Guardar Colaborador
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <h1 class="text-center">Tipos de colaborador ⚡</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
        Crear Tipo <i class="ti ti-plus"></i>
    </button>
    <div class="row">
        @foreach ($tipo_colaborador as $tipo)
            <div class="col-md-4 mb-4">
                <div class="card h-100 mb-0" style="box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);">
                    <div class="card-header text-white text-center">
                        <div class="text-center">
                            <img src="{{ $tipo->imagen }}" alt="{{ $tipo->nombre }}" class="img-fluid rounded-circle"
                                style="height: 150px; object-fit: cover;">
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center"><strong>{{ $tipo->nombre }}</strong> </h5>
                        <p class="text-center"
                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5em; max-height: 3em;">
                            {{ $tipo->descripcion }}
                        </p>


                        <div class="d-flex gap-2 justify-content-center ">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#modalEditUser{{ $tipo->id }}">
                                <i class="ti ti-edit"></i> Editar
                            </button>
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                data-bs-target="#modalDelete{{ $tipo->id }}">
                                <i class="ti ti-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!--Modal edit -->
            <div class="modal fade" id="modalEditUser{{ $tipo->id }}" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">

                <div class="modal-dialog modal-dialog-scrollable modal-dm" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light-primary">
                            <h5 class="modal-title" id="modalTitleId">
                                <i class="ti ti-user-plus me-2"></i>
                                Editar Tipo de Colaborador
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('tipoColaborador.update', $tipo->id) }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Tipo de colaborador</label>
                                    <input type="text" class="form-control" name="nombre" id=""
                                        placeholder="Ingrese el tipo de colaborador" value="{{ $tipo->nombre }}" />
                                </div>

                                <div class="mb-3">
                                    <label for="imagen" class="form-label">Imagen</label>
                                    <input type="text" class="form-control" name="imagen" id=""
                                        placeholder="Ingrese la url de la imagen" value="{{ $tipo->imagen }}" />
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea class="form-control" name="descripcion" id="" placeholder="Ingrese la descripcion">{{ $tipo->descripcion }}</textarea>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-save me-2"></i>Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- Modal delete -->
            <div class="modal fade" id="modalDelete{{ $tipo->id }}" tabindex="-1" role="dialog"
                aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Eliminar
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">¿Esta seguro de eliminar el tipo de colaborador?
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('tipoColaborador.delete', $tipo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $tipo_colaborador->links('pagination::bootstrap-5') }}
    </div>
@endsection
