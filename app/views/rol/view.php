<div class="data-container">
    <h2>Gestión de Roles</h2>
    <div class="buttons">
            <a class="btn-add" href="/rol/new"><i class="fa fa-plus"></i></a>
            <a href="/usuario/indexAdministrador" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php
    if (empty($roles)) {
        echo "<br>No se encuentran roles en la base de datos";
    } else {
        foreach ($roles as $rol) {
            echo "<div class='record'>
                <span>ID: {$rol->idRol} - {$rol->Rol}</span>
                <div class='buttons'>
                    <a href='/rol/view/{$rol->idRol}'><i class='fas fa-eye'></i></a>
                    <a href='/rol/edit/{$rol->idRol}'><i class='fas fa-pen'></i></a>
                    <a href='/rol/delete/{$rol->idRol}'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
        }
    }
    ?>
</div>