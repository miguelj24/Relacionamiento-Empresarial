<div class="data-container">
    <h2>Gestión de Servicios</h2>
    <div class="buttons">
            <a class="btn-add" href="/servicio/new"><i class="fa fa-plus"></i></a>
            <a href="/usuario/indexAdministrador" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php
    if (empty($servicios)) {
        echo "<br>No se encuentran servicios en la base de datos";
    } else {
        foreach ($servicios as $servicio) {
            echo "<div class='record'>
                <span>ID: {$servicio->idServicio} - {$servicio->Servicio}</span>
                <div class='buttons'>
                    <a href='/servicio/view/{$servicio->idServicio}'><i class='fas fa-eye'></i></a>
                    <a href='/servicio/edit/{$servicio->idServicio}'><i class='fas fa-pen'></i></a>
                    <a href='/servicio/delete/{$servicio->idServicio}'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
        }
    }
    ?>
</div>