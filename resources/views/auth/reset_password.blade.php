@extends('layouts.auth')
@section('content')
    <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
        <div class="auth-max-width mx-auto d-flex align-items-center w-100 h-100">
            <div class="card-body">
                <div class="mb-5">
                    <h2 class="fw-bolder fs-7 mb-3">¿Olvidaste tu contraseña?</h2>
                    <p class="mb-0 ">
                        Ingrese la dirección de correo electrónico asociada con su cuenta
                        y le enviaremos un enlace para
                        restablecerla
                        tu contraseña.
                    </p>
                </div>
                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <a href="javascript:void(0)" class="btn btn-primary w-100 py-8 mb-3">Has olvidado tu contraseña</a>
                    <a href="{{ url('/') }}" class="btn bg-primary-subtle text-primary w-100 py-8">Volver a Inicio de
                        Sesión</a>
                </form>
            </div>
        </div>
    </div>
@endsection
