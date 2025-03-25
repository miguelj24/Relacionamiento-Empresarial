<div class="data-container">
    <form action="/cliente/update" method="post">
        <div class="form-group">
            <label for="">Id del cliente</label>
            <input readonly value="<?php echo $cliente->idCliente ?>" type="number" name="idCliente" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Documento del cliente</label>
            <input type="text" value="<?php echo $cliente->DocumentoCliente ?>" name="DocumentoCliente" class="form-control" maxlength="20">
        </div>
        <div class="form-group">
            <label for="">Nombre del cliente</label>
            <input value="<?php echo $cliente->NombreCliente ?>" type="text" name="NombreCliente" class="form-control" maxlength="100">
        </div>
        <div class="form-group">
            <label for="">Correo del cliente</label>
            <input value="<?php echo $cliente->CorreoCliente ?>" type="email" name="CorreoCliente" class="form-control" maxlength="100">
        </div>
        <div class="form-group">
            <label for="">Teléfono del cliente</label>
            <input value="<?php echo $cliente->TelefonoCliente ?>" type="tel" name="TelefonoCliente" class="form-control" maxlength="10">
        </div>
        <div class="form-group">
            <button type="submit">Guardar</button>
        </div>
    </form>
</div>