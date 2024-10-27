@props(['name', 'label'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <div class="input-group">
        <input type="password" class="form-control" id="{{ $name }}" name="{{ $name }}">
        <button class="btn btn-outline-primary" type="button" id="togglePassword{{ $name }}">
            <i class="fas fa-eye"></i>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword{{ $name }}');
        const passwordField = document.querySelector('#{{ $name }}');

        togglePassword.addEventListener('click', function(e) {
            // Alternar el tipo de la contraseña entre texto y password
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Alternar el icono del ojo
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
</script>
