<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('/assets/css/styles.min.css') }} " />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Recuperar Contraseña</title>
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        canvas {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 bg-light-success">
                <a href="https://bootstrapdemos.adminmart.com/modernize/dist/main/index.html"
                    class="text-nowrap logo-img d-block px-4 py-9 w-100">
                </a>
                <div class="d-none d-xl-flex align-items-center justify-content-center h-n80">
                    <img src="{{ url('assets/images/backgrounds/login-security.svg') }}" alt="modernize-img"
                        class="img-fluid" width="500">
                </div>
            </div>
            <div class="col-md-5">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
                            <div class="auth-max-width mx-auto d-flex align-items-center w-100 h-100">
                                <div class="card-body">
                                    <div class="mb-5">
                                        <h2 class="fw-bolder mb-3" style="font-size: 24px;">¿Olvidaste tu contraseña?
                                        </h2>
                                        <p>Ingrese la dirección de correo electrónico asociada con su cuenta e
                                            iniciremos el proceso de recuperacion para poder restabler su contraseña.
                                        </p>
                                    </div>
                                    <form id="emailForm">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo Electrónico</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                required>
                                        </div>
                                        <button type="button" class="btn btn-primary w-100 py-8 mb-3"
                                            id="startRecovery">
                                            Iniciar Recuperación
                                        </button>
                                        <a href="{{ url('/') }}"
                                            class="btn bg-primary-subtle text-primary w-100 py-8">
                                            Volver a Inicio de Sesión
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Captcha -->
                <div class="modal fade" id="captchaModal" tabindex="-1" aria-labelledby="captchaModalLabel"
                    aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="captchaModalLabel">Verificación de Seguridad</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Por favor, resuelva el captcha para continuar.</p>
                                <canvas id="captchaCanvas" width="200" height="50"></canvas>
                                <div class="mb-3">
                                    <input type="text" id="captchaInput" class="form-control"
                                        placeholder="Introduce el código del captcha">
                                </div>
                                <button type="button" class="btn btn-primary w-100"
                                    id="verifyCaptchaBtn">Verificar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Cambio de Contraseña -->
                <div class="modal fade" id="changePasswordModal" tabindex="-1"
                    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                    <input type="password" id="newPassword" class="form-control"
                                        placeholder="Ingresa nueva contraseña" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" id="confirmPassword" class="form-control"
                                        placeholder="Confirma nueva contraseña" required>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="changePasswordBtn">Cambiar
                                    Contraseña</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const captchaModal = new bootstrap.Modal(document.getElementById('captchaModal'));
                        const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                        const captchaInput = document.getElementById('captchaInput');
                        const startRecoveryBtn = document.getElementById('startRecovery');
                        const emailInput = document.getElementById('email');
                        const captchaCanvas = document.getElementById('captchaCanvas');
                        const ctx = captchaCanvas.getContext('2d');
                        const changePasswordBtn = document.getElementById('changePasswordBtn');
                        const newPasswordInput = document.getElementById('newPassword');
                        const confirmPasswordInput = document.getElementById('confirmPassword');

                        // Función para generar el CAPTCHA
                        function generateCaptcha() {
                            const captchaCode = Math.random().toString(36).substring(2, 8).toUpperCase();
                            console.log(`Captcha generado: ${captchaCode}`);
                            ctx.clearRect(0, 0, captchaCanvas.width, captchaCanvas.height);
                            ctx.font = "30px Arial";
                            ctx.fillText(captchaCode, 50, 35);
                            return captchaCode;
                        }

                        // Generar CAPTCHA inicial
                        let captchaCode = generateCaptcha();

                        // Validación de email y apertura de modal
                        startRecoveryBtn.addEventListener('click', async () => {
                            const email = emailInput.value.trim();
                            if (!email) {
                                showTooltip(emailInput, "Por favor, ingrese su correo electrónico.");
                                return;
                            }

                            try {
                                const response = await fetch('/password/verify', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        email: email
                                    })
                                });

                                const result = await response.json();

                                if (response.ok) {
                                    showTooltip(emailInput, "Correo verificado correctamente.");
                                    captchaModal.show();
                                } else {
                                    showTooltip(emailInput, result.error || "Error al verificar el correo.");
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                showTooltip(emailInput, "Ocurrió un error al verificar el correo.");
                            }
                        });

                        // Validación del captcha
                        document.getElementById('verifyCaptchaBtn').addEventListener('click', () => {
                            const captcha = captchaInput.value.trim();
                            if (captcha !== captchaCode) {
                                showTooltip(captchaInput, "Captcha incorrecto. Intente nuevamente.");
                                captchaCode = generateCaptcha();
                                return;
                            }

                            showTooltip(captchaInput, "Captcha verificado correctamente.");
                            captchaModal.hide();
                            changePasswordModal.show();
                        });

                        // Validación y cambio de contraseña
                        changePasswordBtn.addEventListener('click', async () => {
                            const newPassword = newPasswordInput.value.trim();
                            const confirmPassword = confirmPasswordInput.value.trim();

                            if (!newPassword || !confirmPassword) {
                                showTooltip(newPasswordInput, "Por favor, ingrese ambas contraseñas.");
                                return;
                            }

                            if (newPassword !== confirmPassword) {
                                showTooltip(confirmPasswordInput, "Las contraseñas no coinciden.");
                                return;
                            }

                            try {
                                const response = await fetch('/password/update', {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        email: emailInput.value.trim(),
                                        password: newPassword,
                                        password_confirmation: confirmPassword
                                    })
                                });

                                const result = await response.json();

                                if (response.ok) {
                                    showTooltip(changePasswordBtn, "Contraseña cambiada correctamente.");
                                    setTimeout(() => {
                                        changePasswordModal.hide();
                                        window.location.href = '/';
                                    }, 3000);
                                } else {
                                    showTooltip(changePasswordBtn, result.message ||
                                        "Error al cambiar la contraseña.");
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                showTooltip(changePasswordBtn, "Ocurrió un error al cambiar la contraseña.");
                            }
                        });

                        // Función de utilidad para mostrar tooltips
                        function showTooltip(element, message) {
                            const tooltip = new bootstrap.Tooltip(element, {
                                title: message,
                                trigger: 'manual',
                                placement: 'top'
                            });

                            tooltip.show();

                            setTimeout(() => {
                                tooltip.hide();
                            }, 3000);
                        }
                    });
                </script>
            </div>

        </div>
    </div>


</body>

</html>
