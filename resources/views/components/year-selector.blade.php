@props(['name' => 'anio', 'label' => 'Año del Periodo'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select class="form-control" id="{{ $name }}" name="{{ $name }}" required>
        <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
    </select>
    <div class="form-text">Especifique el año correspondiente al periodo</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectYear = document.querySelector('#{{ $name }}');
        const currentYear = new Date().getFullYear();

        // Asegurar que el select tenga solo el año actual
        selectYear.innerHTML = `<option value="${currentYear}" selected>${currentYear}</option>`;

        // Evento de cambio (opcional)
        selectYear.addEventListener('change', function(e) {
            console.log('Año seleccionado:', e.target.value);
        });
    });
</script>
