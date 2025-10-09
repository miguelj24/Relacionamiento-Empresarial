<div class="data-container">
    <?php if ($rol): ?>
        <div class="record">
            <div class="field">
                <strong>ID:</strong>
                <span><?php echo $rol->id ?></span>
            </div>
            <div class="field">
                <strong>Rol:</strong>
                <span><?php echo $rol->Role ?></span>
            </div>
        </div>
        <div class="buttons">
            <a href="/rol/edit/<?php echo $rol->id ?>" title="Editar"><i class="fas fa-pen"></i></a>
            <a href="/rol/view" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Rol no encontrado</p>
        <a href="/rol/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    <?php endif; ?>
</div>
