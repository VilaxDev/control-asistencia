@extends('layouts.app')
@section('content')
    <!--Modal edit user -->
    <div class="modal fade" id="modalId_{{ $usuario->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Editar Perfil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('perfil.update', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="fecha" name="nombre"
                                value="{{ $usuario->nombre }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="fecha" name="apellidos"
                                value="{{ $usuario->apellidos }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Correo Electronico</label>
                            <input type="email" class="form-control" id="fecha" name="email"
                                value="{{ $usuario->email }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-square-x"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary"> <i class="ti ti-device-floppy"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h1 class="text-center mb-4">Perfil</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ url('/assets/images/profile/user-1.jpg') }}" alt="Foto de perfil"
                        class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                    <h4>{{ $usuario->nombre }} {{ $usuario->apellidos }}</h4>
                    <p class="text-muted">{{ $usuario->email }}</p>
                </div>
                <div class="col-md-8">
                    <h5 class="mb-3">Información Personal</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID:</strong> {{ $usuario->id }}</li>
                        <li class="list-group-item"><strong>Rol:</strong> {{ $usuario->rol }}</li>
                        <li class="list-group-item"><strong>Fecha de creación:</strong>
                            {{ \Carbon\Carbon::parse($usuario->fecha_creacion)->format('d/m/Y') }}</li>
                    </ul>
                    <h5 class="mt-4 mb-3">Estado de la Cuenta</h5>
                    <div class="alert alert-info">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalId_{{ $usuario->id }}">
                            Editar Perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
