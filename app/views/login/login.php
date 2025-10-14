<style>
    .forgot-password {
        text-align: center;
    }

    .forgot-password a{
        text-decoration: none;
        color: black;
    }
</style>
<div class="login-container">
    <?php 
    if (isset($_GET['timeout'])) {
        echo "<div class='errors'>La sesión ha expirado por inactividad. Por favor, inicia sesión de nuevo.</div>";
    }
    if (isset($errors)) {
        echo "<div class='errors'>";
        echo $errors;
        echo "</div>";
    }
    ?>
    
    <h2>Iniciar sesión</h2>
    
    <form action="/login/init" method="post">
        <div class="input-group">
            <label for="">Usuario</label>
            <input type="text" name="txtUser" id="txtUser" required>
        </div>
        <div class="input-group">
            <label for="">Contraseña</label>
            <input type="password" name="txtPassword" id="txtPassword" required>
        </div>
        <div class="input-group">
            <button type="submit">Ingresar</button>
        </div>
    </form>

    <div class="forgot-password">
        <a href="/password/forgot">¿Olvidaste tu contraseña?</a>
    </div>
</div>
