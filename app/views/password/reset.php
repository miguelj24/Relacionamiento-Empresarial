<style>
    .back-to-login {
        text-align: center;
    }

    .back-to-login a {
        text-decoration: none;
        color: black;
    }

    /* Estilos responsivos para el logo */
    .login-elements img {
        max-width: 100%;
        height: auto;
    }

    @media screen and (max-width: 768px) {
        .login-elements img {
            max-width: 200px; /* Ajusta este valor según necesites */
        }
    }

    @media screen and (max-width: 480px) {
        .login-elements img {
            max-width: 150px; /* Tamaño más pequeño para móviles */
        }
    }

    /* Contenedor del logo con flexbox para centrado */
    .login-elements {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }
</style>

<div class="reset-password-container">

    <?php 
    if (isset($errors)) {
        echo "<div class='errors'>{$errors}</div>";
    }
    ?>

    <h2>Restablecer Contraseña</h2>
    <p>Ingresa el token que recibiste por correo y tu nueva contraseña.</p>
    <p class="info-text">
        <i class="fas fa-info-circle"></i> 
        Revisa tu bandeja de spam si no encuentras el correo.
    </p>
    
    <form id="resetForm" action="/password/reset" method="post">
        <div class="input-group">
            <label for="token">
                <i class="fas fa-key"></i> Token de Recuperación
            </label>
            <input type="text" name="token" id="token" required
                   placeholder="Ingresa el token recibido">
        </div>

        <div class="input-group">
            <label for="password">
                <i class="fas fa-lock"></i> Nueva Contraseña
            </label>
            <div class="password-input">
                <input type="password" name="password" id="password" required
                       placeholder="Ingresa tu nueva contraseña">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
            </div>
        </div>

        <div class="input-group">
            <label for="password_confirmation">
                <i class="fas fa-lock"></i> Confirmar Contraseña
            </label>
            <div class="password-input">
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       required placeholder="Confirma tu nueva contraseña">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation')"></i>
            </div>
        </div>

        <div class="input-group">
            <button type="submit">
                <i class="fas fa-save"></i> Restablecer Contraseña
            </button>
        </div>
    </form>

    <div class="back-to-login">
        <a href="/login/init">
            <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
        </a>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const params = new URLSearchParams(formData);
    
    fetch('/password/reset', {
        method: 'POST',
        body: params
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        
        // Verificar si fue exitoso (usar el campo success)
        if (data.success === true) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Contraseña actualizada correctamente',
                icon: 'success',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/login/init';
                }
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Ocurrió un error al procesar la solicitud',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});
</script>