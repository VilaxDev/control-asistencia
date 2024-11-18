@extends('layouts.app')
@section('content')
    <!--Modal create -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light-primary">
                    <h5 class="modal-title" id="modalTitleId">
                        <i class="ti ti-user-plus me-2"></i>
                        Registrar Colaborador
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('colaboradores.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                placeholder="Ingrese su nombre" required />
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos"
                                placeholder="Ingrese su apellido" required />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Ingrese su email" required />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" name="password" id=""
                                placeholder="Ingrese su contraseña" required />
                        </div>

                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select name="rol" id="rol" class="form-control" required>
                                <option value="Colaborador" selected readonly>Colaborador</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Seleccione el tipo colaborador</label>
                            <select name="tipo_colaborador" id="tipo_colaborador" class="form-control">
                                @foreach ($tipo_colaborador as $tipo)
                                    <option value="{{ $tipo->nombre }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Selecione el horario</label>
                            <select name="horario" id="tipo_colaborador" class="form-control">
                                @foreach ($horarios as $horario)
                                    <option value="{{ $horario->id }}">{{ $horario->nom_horario }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Tipo de contrato</label>
                            <select name="tipo_contrato" id="tipo_contrato" class="form-control">
                                <option value="fijo">Fijo</option>
                                <option value="temporal">Temporal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" id=""
                                placeholder="Ingrese la fecha de inicio" />
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" name="fecha_fin" id=""
                                placeholder="Ingrese la fecha de fin" />
                        </div>
                        <div class="form-check form-switch">
                            <!-- Campo oculto para enviar "off" si no se marca el switch -->
                            <input type="hidden" name="estado" value="off">

                            <!-- El switch que envía "on" si está activado -->
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                                name="estado" value="on" checked>
                            <label class="form-check-label" for="flexSwitchCheckChecked">Estado</label>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <h1 class="text-center">Gestion de colaboradores ⚡</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#modalCreateUser">
                Crear Colaborador<i class="ti ti-circle-plus ms-2"></i>
            </button>


            <div class="table-responsive border rounded-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Correo Electronico</th>
                            <th scope="col">Status</th>
                            <th scope="col">Fecha de Creacion</th>
                            <th scope="col">Operaciones</th>
                        </tr>
                    </thead>
                    @foreach ($colaboradores as $colaborador)
                        <tbody>
                            <tr>
                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    {{ $colaborador->id }}</td>
                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    {{ $colaborador->nombre }}</td>
                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    {{ $colaborador->apellidos }}</td>
                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    {{ $colaborador->email }}</td>
                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    <span
                                        class="badge {{ $colaborador->estado === 'off' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} rounded-pill">
                                        {{ $colaborador->estado === 'off' ? 'Inactivo' : 'Activo' }}
                                    </span>
                                </td>

                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    {{ $colaborador->fecha_creacion }}</td>
                                <td class="{{ $colaborador->estado === 'off' ? 'bg-light-danger' : '' }}">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEditUser_{{ $colaborador->id }}"> <i
                                                class="ti ti-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-dark"> <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>


                        <!--Modal edit -->
                        <div class="modal fade" id="modalEditUser_{{ $colaborador->id }}" tabindex="-1"
                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                            aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dm"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-light-primary">
                                        <h5 class="modal-title" id="modalTitleId">
                                            <i class="ti ti-pincel me-2"></i>
                                            Editar Colaborador
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('colaborador.update', $colaborador->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre"
                                                    placeholder="Ingrese su nombre" value="{{ $colaborador->nombre }}"
                                                    required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="apellidos" class="form-label">Apellidos</label>
                                                <input type="text" class="form-control" name="apellidos"
                                                    value="{{ $colaborador->apellidos }}" id="apellidos"
                                                    placeholder="Ingrese su apellido" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Ingrese su email" value="{{ $colaborador->email }}"
                                                    required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Contraseña</label>
                                                <input type="text" class="form-control" name="password"
                                                    value="{{ $colaborador->password }}" id=""
                                                    placeholder="Ingrese su contraseña" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="rol" class="form-label">Rol</label>
                                                <select name="rol" id="rol" class="form-control" required>
                                                    <option value="{{ $colaborador->rol }}" selected readonly>
                                                        {{ $colaborador->rol }}</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Seleccione el tipo
                                                    colaborador</label>
                                                <select name="tipo_colaborador" id="tipo_colaborador"
                                                    class="form-control">
                                                    <option value="{{ $colaborador->tipo_colaborador }}" selected>
                                                        {{ $colaborador->tipo_colaborador }}</option>
                                                    @foreach ($tipo_colaborador as $tipo)
                                                        <option value="{{ $tipo->nombre }}">{{ $tipo->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Selecione el horario</label>
                                                <select name="horario_id" id="tipo_colaborador" class="form-control">
                                                    <option value="{{ $colaborador->id_horario }}" selected>
                                                        {{ $colaborador->nom_horario }}</option>
                                                    @foreach ($horarios as $horario)
                                                        <option value="{{ $horario->id }}">{{ $horario->nom_horario }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Tipo de contrato</label>
                                                <select name="tipo_contrato" id="tipo_contrato" class="form-control">
                                                    <option value="{{ $colaborador->tipo_contrato }}" selected>
                                                        {{ $colaborador->tipo_contrato }}</option>
                                                    <option value="fijo">Fijo</option>
                                                    <option value="temporal">Temporal</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Fecha de Inicio</label>
                                                <input type="date" class="form-control" name="fecha_inicio"
                                                    id="" placeholder="Ingrese la fecha de inicio"
                                                    value="{{ $colaborador->fecha_inicio }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Fecha de Fin</label>
                                                <input type="date" class="form-control" name="fecha_fin"
                                                    id="" placeholder="Ingrese la fecha de fin"
                                                    value="{{ $colaborador->fecha_fin }}" required />
                                            </div>
                                            <input type="hidden" name="fecha_creacion"
                                                value="{{ $colaborador->fecha_creacion }}" />
                                            <input type="hidden" name="usuario_id"
                                                value="{{ $colaborador->id_usuario }}" />
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="estado" value="off">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked" name="estado" value="on"
                                                    {{ $colaborador->estado == 'on' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckChecked">Estado</label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{ $colaboradores->links('pagination::bootstrap-5') }}
@endsection
