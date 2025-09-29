<div class="data-container">
    <h2>Gestión de Tipos de Evento</h2>
    <div class="buttons">
            <a class="btn-add" href="/tipoEvento/new"><i class="fa fa-plus"></i></a>
            <a href="/usuario/indexAdministrador" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php
    if (empty($tiposEvento)) {
        echo "<br>No se encuentran tipos de evento en la base de datos";
    } else {
        foreach ($tiposEvento as $tipo) {
            echo "<div class='record'>
                <span>ID: {$tipo->idTipoEvento} - {$tipo->TipoEvento}</span>
                <div class='buttons'>
                    <a href='/tipoEvento/view/{$tipo->idTipoEvento}'><i class='fas fa-eye'></i></a>
                    <a href='/tipoEvento/edit/{$tipo->idTipoEvento}'><i class='fas fa-pen'></i></a>
                    <a href='/tipoEvento/delete/{$tipo->idTipoEvento}'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
        }
    }
    ?>
</div>