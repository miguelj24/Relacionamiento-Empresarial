<style>
    .data-container {
  max-width: 500px;
  margin: 2rem auto;
  padding: 2rem;
  background-color: #f9f9f9;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
</style>
<div class="data-container">
    <?php if ($cliente && is_object($cliente)): ?>
        <div class="record">
            <div class="field">
                <strong>ID:</strong>
                <span><?php echo $cliente->idCliente; ?></span>
            </div>
            <div class="field">
                <strong>Documento:</strong>
                <span><?php echo $cliente->DocumentoCliente; ?></span>
            </div>
            <div class="field">
                <strong>Nombre:</strong>
                <span><?php echo $cliente->NombreCliente; ?></span>
            </div>
            <div class="field">
                <strong>Correo:</strong>
                <span><?php echo $cliente->CorreoCliente; ?></span>
            </div>
            <div class="field">
                <strong>Teléfono:</strong>
                <span><?php echo $cliente->TelefonoCliente; ?></span>
            </div>
        </div>
        <div class="buttons">
            <a href="/cliente/edit/<?php echo $cliente->idCliente; ?>" title="Editar"><i class="fas fa-pen"></i></a>
            <a href="/cliente/view" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Cliente no encontrado</p>
        <a href="/cliente/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    <?php endif; ?>
</div>
