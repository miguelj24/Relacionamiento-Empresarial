<div class="data-container">
    <a class="btn-add" href="/cliente/new">+</a>
    <?php
    if (empty($clientes)) {
        echo "<br>No se encuentran clientes en la base de datos";
    } else {
        foreach ($clientes as $key => $value) {
            echo "<div class='record'>
                <span>ID: $value->idCliente - $value->DocumentoCliente - $value->NombreCliente - $value->CorreoCliente - $value->TelefonoCliente</span>
                <div class='buttons'>
                    <a href='/cliente/view/".$value->idCliente."'>Consultar</a>
                    <a href='/cliente/edit/".$value->idCliente."'>Editar</a>
                    <a href='/cliente/delete/".$value->idCliente."'>Eliminar</a>
                </div>
            </div>";
        }
    }
    ?>
</div>