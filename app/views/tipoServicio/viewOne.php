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
    <?php if ($tipoServicio): ?>
        <div class="record">
            <div class="field">
                <strong>ID:</strong>
                <span><?php echo $tipoServicio->id ?></span>
            </div>
            <div class="field">
                <strong>Tipo de Servicio:</strong>
                <span><?php echo $tipoServicio->serviceType ?></span>
            </div>
            <div class="field">
                <strong>Servicio:</strong>
                <span><?php echo $tipoServicio->NombreServicio ?></span>
            </div>
        </div>
        <div class="buttons">
            <a href="/tipoServicio/edit/<?php echo $tipoServicio->id ?>" title="Editar"><i class="fas fa-pen"></i></a>
            <a href="/tipoServicio/view" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Tipo de servicio no encontrado</p>
        <a href="/tipoServicio/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    <?php endif; ?>
</div>
