<style>
    .back-to-login {
        text-align: center;
    }

    .back-to-login a {
        text-decoration: none;
        color: black;
    }

</style>

<div class="forgot-password-container">

    <?php 
    if (isset($message)) {
        echo "<div class='message'>{$message}</div>";
    }

    if (isset($errors)) {
        echo "<div class='errors'>{$errors}</div>";
    }
    ?>

    <h2>Recuperar Contraseña</h2>
    <p>Ingresa tu correo electrónico para recibir las instrucciones de recuperación.</p>
    
    <form id="forgotPasswordForm" action="/password/request-reset" method="post">
        <div class="input-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" required 
                   placeholder="Ingresa tu correo electrónico">
        </div>
        <div class="input-group">
            <button type="submit">
                <i class="fas fa-paper-plane"></i> Enviar Instrucciones
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
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const params = new URLSearchParams(formData);
    
    fetch('/password/request-reset', {
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
        
        if (data.success === true) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Se han enviado las instrucciones a tu correo electrónico',
                icon: 'success',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir a la página de reset
                    window.location.href = '/password/reset';
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