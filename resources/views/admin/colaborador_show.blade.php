@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detalles del Colaborador</h2>

        <table class="table table-bordered">
            <tr>
                <th>Nombre</th>
                <td>{{ $colaborador->nombre }} {{ $colaborador->apellidos }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $colaborador->email }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>{{ $colaborador->estado }}</td>
            </tr>
            <tr>
                <th>Fecha de inicio</th>
                <td>{{ $colaborador->fecha_inicio }}</td>
            </tr>
            <tr>
                <th>Fecha de fin</th>
                <td>{{ $colaborador->fecha_fin }}</td>
            </tr>
            <tr>
                <th>Tipo de contrato</th>
                <td>{{ $colaborador->tipo_contrato }}</td>
            </tr>
            <tr>
                <th>Tipo de colaborador</th>
                <td>{{ $colaborador->tipo_colaborador }}</td>
            </tr>
            <tr>
                <th>Horario</th>
                <td>{{ $colaborador->nom_horario }}</td>
            </tr>
        </table>

        <!-- Agregar un botón para volver a la lista de colaboradores -->
        <a href="{{ route('colaboradores.index') }}" class="btn btn-primary"><i class="ti ti-arrow-back"></i> Volver</a>
    </div>
@endsection
