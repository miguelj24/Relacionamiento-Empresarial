<style>
    .data-container {
        max-width: 500px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Modo oscuro para la vista de usuario */
    body.dark-mode .data-container {
        background-color: #23272a !important;
        color: #e0e0e0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    body.dark-mode .data-container .field strong {
        color: #b0b0b0;
    }

    body.dark-mode .data-container .field span {
        color: #e0e0e0;
    }

    body.dark-mode .btn-primary {
        background: #09669C;
        color: #fff;
        border: none;
    }

    body.dark-mode .btn-secondary {
        background: #393e42;
        color: #e0e0e0;
        border: none;
    }

    body.dark-mode .btn-primary:hover,
    body.dark-mode .btn-secondary:hover {
        opacity: 0.85;
    }
</style>
<div class="data-container">
    <?php if ($usuario): ?>
        <div class="record record-column">
            <div class="field">
                <strong>ID:</strong>
                <span><?php echo $usuario->id ?></span>
            </div>
            <div class="field">
                <strong>Documento:</strong>
                <span><?php echo $usuario->documentUser ?></span>
            </div>
            <div class="field">
                <strong>Nombre:</strong>
                <span><?php echo $usuario->nameUser ?></span>
            </div>
            <div class="field">
                <strong>Correo:</strong>
                <span><?php echo $usuario->emailUser ?></span>
            </div>
            <div class="field">
                <strong>Teléfono:</strong>
                <span><?php echo $usuario->telephoneUser ?></span>
            </div>
            <div class="field">
                <strong>Rol:</strong>
                <span><?php echo $usuario->NombreRol?></span>
            </div>
            <div class="field">
                <strong>Coordinador:</strong>
                <span><?php echo $usuario->coordinator ? 'Sí' : 'No' ?></span>
            </div>
        </div>
        <div class="buttons">
            <a href="/usuario/edit/<?php echo $usuario->id ?>" class="btn btn-primary" title="Editar"><i class="fas fa-pen"></i></a>
            <a href="/usuario/view" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Usuario no encontrado</p>
        <a href="/usuario/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    <?php endif; ?>
</div>