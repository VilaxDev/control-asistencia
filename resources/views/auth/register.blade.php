@extends('layouts.auth')
@section('content')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
            <h2 class="mb-1 fs-7 fw-bolder">Bienvenido a Power Code</h2>
            <p class="mb-7">Su panel de administración</p>


            <form action="{{ route('register.store') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input type="text" id="nombre" class="form-control" name="nombre" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" class="form-control" name="apellidos" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Correo Electroníco</label>
                    <input type="email" id="email" class="form-control" name="email" required />
                </div>

                <x-input-password name="password" label="Contraseña" required />
                <div class="mb-3">
                    <label class="form-label" for="rol">Rol</label>
                    <select class="form-select form-control" name="rol" id="rol" required>
                        <option value="Administrador" selected>Administrador</option>
                    </select>
                </div>
                <button class="btn btn-primary w-100 py-8 mb-4 rounded-2" type="submit">Registrarse
                </button>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">¿Ya tienes una cuenta?</p>
                    <a class="text-primary fw-medium ms-2" href="{{ url('/') }}">Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
@endsection
