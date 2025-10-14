<style>
    .back-to-login{
        text-align: center;
    }

    .back-to-login a {
        text-decoration: none;
        color: black;
    }
</style>

<div class="reset-password-container">

    <?php 
    if (isset($errors)) {
        echo "<div class='errors'>{$errors}</div>";
    }
    ?>

    <h2>Restablecer Contraseña</h2>
    <p>Revisa tu bandeja de spam en caso de no llegar al principal.</p>
    <p>Ingresa el token que recibiste por correo y tu nueva contraseña.</p>
    
    <form id="resetForm" action="/password/reset" method="post">
        <div class="input-group">
            <label for="token">Token de Recuperación</label>
            <input type="text" name="token" id="token" required>
        </div>

        <div class="input-group">
            <label for="password">Nueva Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="input-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="input-group">
            <button type="submit">Restablecer Contraseña</button>
        </div>
    </form>

    <div class="back-to-login">
        <a href="/login/init">Volver al inicio de sesión</a>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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