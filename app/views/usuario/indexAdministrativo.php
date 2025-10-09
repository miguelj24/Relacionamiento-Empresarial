<?php
// --- Obtener los datos desde el controlador o el modelo ---
$solicitudModel = new \App\Models\SolicitudModel();
$solicitudesPorMes = $solicitudModel->getSolicitudesPorMes(); 
// Esta función debe devolver filas con los campos: mes, cantidad (o como los hayas llamado)

// --- Preparar arrays para el gráfico ---
$labels = [];
$valores = [];

foreach ($solicitudesPorMes as $fila) {
    $labels[] = $fila['mes']; // ajusta si el campo se llama diferente
    $valores[] = (int)$fila['cantidad']; // ajusta si el campo se llama diferente
}

// --- Convertir a JSON para pasar al JS ---
$labelsJSON = json_encode($labels, JSON_UNESCAPED_UNICODE);
$valoresJSON = json_encode($valores);
?>


<style>
    h1 {
      font-size: 28px;
      color: #39A900;
      margin-bottom: 20px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card .title {
      font-size: 14px;
      color: #09669C;
    }

    .card .value {
      font-size: 24px;
      font-weight: bold;
      margin-top: 5px;
    }

    .chart-container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      h2 {
        color: #09669C;
      }
    }

    .chart-placeholder {
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #888;
      font-style: italic;
      border-radius: 10px;
    }

    .movimientos {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .movimientos h2 {
      margin-bottom: 15px;
      color: #39A900;
    }

    .movimiento-header,
    .movimiento {
      display: grid;
      grid-template-columns: 1fr 2fr 3fr 2fr;
      gap: 10px;
      padding: 10px 0;
    }

    .movimiento-header {
      border-bottom: 2px solid #eee;
      color: #666;
      font-weight: bold;
    }

    .movimiento {
      border-bottom: 1px solid #f0f0f0;
      color: #444;
    }

    .movimiento:last-child {
      border-bottom: none;
    }

    .movimiento:hover {
      background-color: #f9f9f9;
    }

    @media(max-width: 768px) {
      .movimiento-header,
      .movimiento {
        grid-template-columns: 1fr;
      }
    }

    /* Modo oscuro para las cards y contenedores administrativos */
    body.dark-mode .card,
    body.dark-mode .chart-container,
    body.dark-mode .movimientos {
        background: #23272a !important;
        color: #e0e0e0;
        box-shadow: 0 2px 12px rgba(0,0,0,0.25);
    }

    body.dark-mode .card .title,
    body.dark-mode .chart-container h2,
    body.dark-mode .movimientos h2 {
        color: #39A900;
    }

    body.dark-mode .card .value {
        color: #e0e0e0;
    }

    body.dark-mode .movimiento-header {
        border-bottom: 2px solid #393e42;
        color: #b0b0b0;
        background: #23272a;
    }

    body.dark-mode .movimiento {
        border-bottom: 1px solid #393e42;
        color: #e0e0e0;
        background: #23272a;
    }

    body.dark-mode .movimiento:hover {
        background-color: #2d3238;
    }

    body.dark-mode .chart-placeholder {
        background-color: #393e42;
        color: #b0b0b0;
    }
</style>

<div class="container">
<h1>Estadísticas</h1>

  <div class="cards">
    <div class="card">
      <div class="title">Usuarios Registrados</div>
      <div class="value"><?php echo number_format($totalUsuarios); ?></div>
    </div>
    <div class="card">
      <div class="title">Solicitudes Pendientes</div>
      <div class="value"><?php echo number_format($totalSolicitudesPendientes); ?></div>
    </div>
    <div class="card">
      <div class="title">Solicitudes Resueltas</div>
      <div class="value"><?php echo number_format($totalSolicitudesResueltas); ?></div>
    </div>
    <div class="card">
      <div class="title">Solicitudes en proceso</div>
      <div class="value"><?php echo number_format($totalSolicitudesEnProceso); ?></div>
    </div>
  </div>

  <div class="chart-container">
    <h2>Actividad Mensual</h2>
    <div class="chart-placeholder">
          <canvas id="myChart"  width="400px" height="90px"></canvas>
    </div>
  </div>

  <div class="movimientos">
    <h2>Últimos Movimientos</h2>
    <div class="movimiento-header">
      <div>ID</div>
      <div>Usuario</div>
      <div>Acción</div>
      <div>Fecha</div>
    </div>

    <?php if (!empty($ultimosMovimientos)): ?>
        <?php foreach ($ultimosMovimientos as $movimiento): ?>
            <div class="movimiento">
                <div><?php echo htmlspecialchars($movimiento['id']); ?></div>
                <div><?php echo htmlspecialchars($movimiento['nameUser']); ?></div>
                <div><?php echo htmlspecialchars($movimiento['accion']); ?></div>
                <div><?php echo date('Y-m-d', strtotime($movimiento['fecha'])); ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="movimiento">
            <div colspan="4">No hay movimientos recientes</div>
        </div>
    <?php endif; ?>
</div>

</div>