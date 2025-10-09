<div class="data-container">
    <a class="btn-add" href="/cliente/new">+</a>
    <?php
    if (empty($clientes)) {
        echo "<br>No se encuentran clientes en la base de datos";
    } else {
        foreach ($clientes as $key => $value) {
            echo "<div class='record'>
                <span>ID: $value->id - $value->DocumentClient - $value->NameClient - $value->EmailClient - $value->TelephoneClient</span>
                <div class='buttons'>
                    <a href='/cliente/view/".$value->id."'>Consultar</a>
                    <a href='/cliente/edit/".$value->id."'>Editar</a>
                    <a href='/cliente/delete/".$value->id."'>Eliminar</a>
                </div>
            </div>";
        }
    }
    ?>
</div>