@props(['name' => 'anio', 'label' => 'Año del Periodo'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select class="form-control" id="{{ $name }}" name="{{ $name }}" required>
    </select>
    <div class="form-text">Especifique el año correspondiente al periodo</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectYear = document.querySelector('#{{ $name }}');
        const currentYear = new Date().getFullYear();

        // Genera las opciones de años
        for (let i = 0; i < 5; i++) {
            const year = currentYear + i;
            const option = new Option(year, year);

            if (year === currentYear) {
                option.selected = true;
            }

            selectYear.appendChild(option);
        }

        // Opcional: Evento de cambio
        selectYear.addEventListener('change', function(e) {
            console.log('Año seleccionado:', e.target.value);
        });
    });
</script>
