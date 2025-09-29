<div class="data-container">
    <?php if ($estado && is_object($estado)): ?>
        <div class="record">
            <div class="field">
                <strong>ID:</strong>
                <span><?php echo $estado->idEstado ?></span>
            </div>
            <div class="field">
                <strong>Estado:</strong>
                <span><?php echo $estado->Estado ?></span>
            </div>
            <div class="field">
                <strong>Descripción:</strong>
                <span><?php echo $estado->Descripcion ?></span>
            </div>
        </div>
        <div class="buttons">
            <a href="/estado/edit/<?php echo $estado->idEstado ?>" title="Editar"><i class="fas fa-pen"></i></a>
            <a href="/estado/view" title="Volver"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Estado no encontrado</p>
        <a href="/estado/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    <?php endif; ?>
</div>
