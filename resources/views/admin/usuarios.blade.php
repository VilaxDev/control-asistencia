@extends('layouts.app')
@section('content')
    <h1 class="text-center">Usuários</h1>
    <!--Modal create -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Registrar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="email" class="form-control" name="nombre" id=""
                                placeholder="Ingrese su nombre" />
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="email" class="form-control" name="apellidos" id=""
                                placeholder="Ingrese sus apellidos" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="" id=""
                                placeholder="Ingrese su correo electronico" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" id=""
                                placeholder="Ingrese su contraseña" />
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                Crear +
            </button>
            <div class="table-striped">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Operaciones</th>
                        </tr>
                    </thead>

                    @foreach ($users as $user)
                        <tbody>
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->nombre }}</td>
                                <td>{{ $user->apellidos }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->rol }}</td>
                                <td><button type="button" class="btn btn-warning"> <i class="ti ti-pencil"></i>Editar
                                    </button>
                                    <button type="button" class="btn btn-danger"> <i class="ti ti-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>  

        </div>
    </div>
    {{ $users->links('pagination::bootstrap-5') }}
@endsection
