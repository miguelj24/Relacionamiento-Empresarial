<div class="data-container">
    <h2>Gestión de Tipos de Servicio</h2>
    <div class="buttons">
            <a class="btn-add" href="/tipoServicio/new"><i class="fa fa-plus"></i></a>
            <a href="/usuario/indexAdministrador" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php
    if (empty($tiposServicio)) {
        echo "<br>No se encuentran tipos de servicio en la base de datos";
    } else {
        foreach ($tiposServicio as $tipo) {
            echo "<div class='record'>
                <span>ID: {$tipo->id} - {$tipo->serviceType} - Servicio: {$tipo->NombreServicio}</span>
                <div class='buttons'>
                    <a href='/tipoServicio/view/{$tipo->id}'><i class='fas fa-eye'></i></a>
                    <a href='/tipoServicio/edit/{$tipo->id}'><i class='fas fa-pen'></i></a>
                    <a href='/tipoServicio/delete/{$tipo->id}'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
        }
    }
    ?>
</div>