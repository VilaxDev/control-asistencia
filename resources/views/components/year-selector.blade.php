@props(['name' => 'anio', 'label' => 'Año del Periodo', 'value' => date('Y')])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select class="form-control" id="{{ $name }}" name="{{ $name }}" required>
        <option value="{{ $value }}" selected>{{ $value }}</option>
    </select>
    <div class="form-text">Especifique el año correspondiente al periodo</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectYear = document.querySelector('#{{ $name }}');
        const currentYear = new Date().getFullYear();

        // Asegurar que el select tenga solo el año actual o el valor recibido
        const selectedValue = "{{ $value }}";
        selectYear.innerHTML = `<option value="${selectedValue}" selected>${selectedValue}</option>`;

        // Evento de cambio (opcional)
        selectYear.addEventListener('change', function(e) {
            console.log('Año seleccionado:', e.target.value);
        });
    });
</script>
