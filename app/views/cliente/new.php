<div class="data-container">
    <form action="/cliente/create" method="post">
        <div class="form-group">
            <label for="">Documento del cliente</label>
            <input type="text" name="DocumentoCliente" class="form-control" maxlength="20" required>
        </div>
        <div class="form-group">
            <label for="">Nombre del cliente</label>
            <input type="text" name="NombreCliente" class="form-control" maxlength="100" required>
        </div>
        <div class="form-group">
            <label for="">Correo del cliente</label>
            <input type="email" name="CorreoCliente" class="form-control" maxlength="100" required>
        </div>
        <div class="form-group">
            <label for="">Teléfono del cliente</label>
            <input type="tel" name="TelefonoCliente" class="form-control" maxlength="10" required>
        </div>
        <div class="form-group">
            <button type="submit">Guardar</button>
        </div>
    </form>
</div>