@extends('layouts.auth')
@section('content')
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
            <h2 class="mb-1 fs-7 fw-bolder">Bienvenido a Power Code</h2>
            <p class="mb-7">Su panel de administración</p>
            <div class="row">
                <div class="col-6 mb-2 mb-sm-0">
                    <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                        href="javascript:void(0)" role="button">
                        <img src="https://cdn-icons-png.flaticon.com/128/3479/3479876.png" alt="modernize-img"
                            class="img-fluid me-2" width="19" height="18">
                        <span class="flex-shrink-0">Security</span>
                    </a>
                </div>
                <div class="col-6">
                    <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                        href="javascript:void(0)" role="button">
                        <img src="https://cdn-icons-png.flaticon.com/128/3876/3876146.png" alt="modernize-img"
                            class="img-fluid me-2" width="19" height="18">
                        <span class="flex-shrink-0">Password</span>
                    </a>
                </div>
            </div>
            <div class="position-relative text-center my-4">
                <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">inicia sesión con
                </p>
                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
            </div>

            <form action="{{ route('login.auth') }}" method="post">
                @csrf
                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        name="email">
                </div>
                <x-input-password name="password" label="Contraseña" />

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked"
                            checked>
                        <label class="form-check-label text-dark fs-3" for="flexCheckChecked">
                            Recuerda este dispositivo
                        </label>
                    </div>
                    <a class="text-primary fw-medium fs-3" href="{{ url('auth/reset_password') }}">Olvidó Contraseña ?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Iniciar sesión</button>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">¿Nuevo en Power Code?</p>
                    <a class="text-primary fw-medium ms-2" href="{{ url('register') }}">Crear
                        una cuenta</a>
                </div>
            </form>
        </div>
    </div>
@endsection
