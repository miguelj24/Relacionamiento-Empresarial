<div class="data-container">
<h2>Gestión de Estados</h2>
    <div class="buttons">
            <a class="btn-add" href="/estado/new"><i class="fa fa-plus"></i></a>
            <a href="/usuario/indexAdministrador" class="btn btn-secondary" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php
    if (empty($estados)) {
        echo "<br>No se encuentran estados en la base de datos";
    } else {
        foreach ($estados as $key => $value) {
            echo "<div class='record'>
                <span>ID: $value->idEstado - $value->Estado - $value->Descripcion</span>
                <div class='buttons'>
                    <a href='/estado/view/".$value->idEstado."'><i class='fas fa-eye'></i></a>
                    <a href='/estado/edit/".$value->idEstado."'><i class='fas fa-pen'></i></a>
                    <a href='/estado/delete/".$value->idEstado."'><i class='fas fa-trash'></i></a>
                </div>
            </div>";
        }
    }
    ?>
</div>
