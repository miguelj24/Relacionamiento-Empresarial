<div class="data-container">
    <?php if ($servicio): ?>
        <div class="record record-column">
            <span>ID: <?php echo $servicio->id?></span>
            <span>Servicio: <?php echo $servicio->service ?></span>
        </div>
        <div class="buttons">
            <a href="/servicio/edit/<?php echo $servicio->id ?>" class="btn btn-primary"><i class="fas fa-pen"></i></a>
            <a href="/servicio/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
        </div>
    <?php else: ?>
        <p>Servicio no encontrado</p>
        <a href="/servicio/view" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a>
    <?php endif; ?>
</div>