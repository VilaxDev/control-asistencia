@extends('layouts.app')
@section('content')
    <h1 class="text-center">Asistencias</h1>
    <div class="card shadow">
        <div class="card-body">
            <x-input-search />
            <div class="table-responsive border rounded-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Colaborador</th>
                            <th scope="col">Hora Entrada</th>
                            <th scope="col">Hora Salida</th>
                            <th scope="col">Justificada</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Operaciones</th>
                        </tr>
                    </thead>

                    @foreach ($asistencias as $asistencia)
                        <tbody>
                            <tr>
                                <td>{{ $asistencia->id }}</td>
                                <td> {{ $asistencia->usuario_nombre }}</td>
                                <td>{{ $asistencia->hora_entrada }}</td>
                                <td>{{ $asistencia->hora_salida }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $asistencia->justificada == 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} 
                                        rounded-pill">
                                        {{ $asistencia->justificada == 0 ? 'No' : 'Si' }}
                                    </span>
                                </td>

                                </td>
                                <td>{{ $asistencia->fecha }}</td>
                                <td>
                                    <form action="{{ route('asistencia.show', $asistencia->id) }}" method="GET">
                                        <button type="submit" class="btn btn-dark"> <i class="ti ti-eye"></i> Visualizar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>

        </div>
    </div>
    {{ $asistencias->links('pagination::bootstrap-5') }}
@endsection
