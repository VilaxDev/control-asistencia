@props(['name', 'label', 'diasSeleccionados' => []]) <!-- Añade diasSeleccionados como prop -->

@php
    $diasLaborales = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
@endphp

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="d-flex flex-wrap gap-2">
        @foreach ($diasLaborales as $dia)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="{{ $dia }}" name="{{ $name }}[]"
                    value="{{ $dia }}" @if (in_array($dia, $diasSeleccionados)) checked @endif />
                <label class="form-check-label" for="{{ $dia }}">{{ ucfirst($dia) }}</label>
            </div>
        @endforeach
    </div>
</div>
