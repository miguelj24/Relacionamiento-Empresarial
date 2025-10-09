<style>
    .data-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 0;
    }

    .profile-container {
        background-color: #ffffff;
        color: #333;
        padding: 30px 25px;
        border-radius: 16px;
        text-align: center;
        width: 360px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', sans-serif;
    }

    .profile-container img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin-bottom: 20px;
        border: 4px solid #39A900;
    }

    .profile-container h2 {
        font-size: 18px;
        margin-bottom: 20px;
        font-weight: 600;
        color: #39A900;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin: 12px 0;
        font-size: 15px;
        color: #222;
    }

    .info-item i {
        color: #09669C;
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .info-item strong {
        font-weight: 600;
        margin-right: 6px;
    }

    .btn-modificar {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #04324D;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .btn-modificar:hover {
        background-color: #09669C;
    }

    /* Modo oscuro para perfil de usuario */
    body.dark-mode .profile-container {
        background-color: #23272a !important;
        color: #e0e0e0;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    body.dark-mode .profile-container h2 {
        color: #39A900;
    }

    body.dark-mode .info-item {
        color: #e0e0e0;
    }

    body.dark-mode .info-item i {
        color: #39A900;
    }

    body.dark-mode .info-item strong {
        color: #b0b0b0;
    }

    body.dark-mode .btn-modificar {
        background-color: #09669C;
        color: #fff;
    }

    body.dark-mode .btn-modificar:hover {
        background-color: #04324D;
    }
</style>

<!-- Contenido del perfil -->
<div class="data-container">
    <div class="profile-container">
        <img src="../img/perfil.png" alt="Perfil">

        <h2>Bienvenido a tu espacio personal, donde cada dato cuenta.</h2>

        <div class="info-item">
            <i class="fas fa-user"></i>
            <strong>Nombre:</strong> <span><?php echo $usuario->nameUser; ?></span>
        </div>

        <div class="info-item">
            <i class="fas fa-id-card"></i>
            <strong>Documento:</strong> <span><?php echo $usuario->documentUser; ?></span>
        </div>

        <div class="info-item">
            <i class="fas fa-envelope"></i>
            <strong>Correo:</strong> <span><?php echo $usuario->emailUser; ?></span>
        </div>

        <div class="info-item">
            <i class="fas fa-phone"></i>
            <strong>Teléfono:</strong> <span><?php echo $usuario->telephoneUser; ?></span>
        </div>

        <div class="info-item">
            <i class="fas fa-user-tag"></i>
            <strong>Rol:</strong> <span><?php echo $usuario->NombreRol; ?></span>
        </div>

        <!-- Botón Modificar -->
        <a href="/usuario/edit/<?php echo $usuario->id; ?>" class="btn-modificar">
            <i class="fas fa-edit"></i> Modificar
        </a>
    </div>
</div>
