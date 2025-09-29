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
    <?php if ($tipoEvento): ?>
        <div class="record">
            <div class="field">
                <strong>ID:</strong>
                <span><?php echo $tipoEvento->idTipoEvento ?></span>
            </div>
            <div class="field">
                <strong>Tipo de Evento:</strong>
                <span><?php echo $tipoEvento->TipoEvento ?></span>
            </div>
        </div>
        <div class="buttons">
            <a href="/tipoEvento/edit/<?php echo $tipoEvento->idTipoEvento ?>" title="Editar"><i class="fas fa-pen"></i></a>
            <a href="/tipoEvento/view" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Tipo de evento no encontrado</p>
        <a href="/tipoEvento/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
    <?php endif; ?>
</div>
