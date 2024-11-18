@props(['name' => 'fecha', 'value' => null])
<div class="mb-3">
    <input type="date" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
        name="{{ $name }}" value="{{ old($name, $value) }}" required>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputFecha = document.querySelector('#{{ $name }}');
        const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format

        // Set minimum date to today
        inputFecha.setAttribute('min', today);

        // Optional: Set maximum date to end of current year if needed
        const currentYear = new Date().getFullYear();
        const maxDate = `${currentYear}-12-31`;
        inputFecha.setAttribute('max', maxDate);

        // If no value is set or the value is before today, set to today
        if (!inputFecha.value || new Date(inputFecha.value) < new Date(today)) {
            inputFecha.value = today;
        }
    });
</script>
