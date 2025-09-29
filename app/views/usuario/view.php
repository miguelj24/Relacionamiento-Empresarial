<div class="data-container">
    <h2>Gestión de Usuarios</h2>
    <div class="buttons">
            <a class="btn-add" href="/usuario/new"><i class="fa fa-plus"></i></a>
            <a href="/usuario/indexAdministrador" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php
    if (empty($usuarios)) {
        echo "<br>No se encuentran usuarios en la base de datos";
    } else {
        foreach ($usuarios as $usuario) {
            echo "<div class='record'>
                <span>ID: {$usuario->idUsuario} - {$usuario->DocumentoUsuario} - {$usuario->NombreUsuario} - {$usuario->CorreoUsuario} - {$usuario->TelefonoUsuario} - {$usuario->FKidRol}</span>
                <div class='buttons'>
                    <a href='/usuario/view/{$usuario->idUsuario}'><i class='fas fa-eye'></i></a>
                    <a href='/usuario/edit/{$usuario->idUsuario}'><i class='fas fa-pen'></i></a>
                    <a href='/usuario/delete/{$usuario->idUsuario}'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
        }
    }
    ?>
</div>