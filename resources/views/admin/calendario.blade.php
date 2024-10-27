@extends('layouts.app')
@section('content')
    <h1 class="text-center">Calendario</h1>
    <!--Modal create -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Registrar Evento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Evento</label>
                            <input type="text" class="form-control" name="nombre" id=""
                                placeholder="Ingrese el nombre del evento" />
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Descripcion</label>
                            <textarea type="email" class="form-control" name="apellidos" id=""
                                placeholder="Ingrese una descripcion detallada"> </textarea>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="password" id="" />
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

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
        Crear Evento +
    </button>

    <div class="row">
        <div class="col-sm-3 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-6 align-self-center">
                            <h5 class="card-title">Horario</h5>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <i class="ti ti-calendar" style="font-size: 50px;"></i>
                        </div>
                    </div>
                    <p class="card-text">Feriado</p>
                    <p class="card-text">Feriado por el dia del padre</p>
                    <input class="form-control" type="date" name="" id="">
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <button class="btn btn-dark"> <i class="ti ti-eye"></i> Ver</button>
                        <button class="btn btn-dark"> <i class="ti ti-edit"></i>Editar</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
