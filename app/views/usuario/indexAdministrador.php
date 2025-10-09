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
    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 200px;
      height: 120px;
      text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    a {
      text-decoration: none;
    }


    .title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #39A900;
    }

    .info {
      font-size: 14px;
      color: #777;
    }

    /* Estilos para el dashboard de métricas */
    .dashboard-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(2, auto);
      gap: 20px;
      margin-top: 10px;
      padding: 20px;
    }

    .metric-card {
      background: #fff;
      padding: 20px;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 200px;
    }

    .metric-card * {
      margin: 0;
      padding: 0;
      border: none;
      box-shadow: none;
    }

    .metric-card:nth-child(1) {
      grid-column: span 2;
    }

    .metric-card img {
      width: 100%;
      max-width: 250px;
      height: auto;
      object-fit: contain;
    }

    .metric-label {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
    }

    .metric-value {
      font-size: 20px;
      font-weight: bold;
      color: green;
    }

    .chart-container {
      background: white;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Ajustes en la presentación de los íconos y demás */
    .img {
      width: 100%;
      max-width: 300px;
      height: auto;
      max-height: 150px;
      object-fit: contain;
    }

    @media screen and (max-width: 1024px) {
      .container {
        justify-content: center;
        gap: 16px;
      }

      .card {
        width: 180px;
        height: 150px;
        padding: 16px;
      }

      .dashboard-container {
        grid-template-columns: repeat(2, 1fr);
      }

      .metric-card {
        min-height: 160px;
        padding: 16px;
      }

      .img {
        max-width: 200px;
        max-height: 120px;
      }
    }

    @media screen and (max-width: 600px) {
      .container {
        flex-direction: column;
        align-items: center;
      }

      .card {
        width: 300px;
        height: 120px;
      }

      .dashboard-container {
        grid-template-columns: 1fr;
      }

      .metric-card {
        min-height: 140px;
        padding: 12px;
      }

      .img {
        max-width: 100%;
        max-height: 100px;
      }
    }

    /* Modo oscuro para las cards del administrador */
body.dark-mode .card,
body.dark-mode .metric-card,
body.dark-mode .chart-container {
    background-color: #23272a !important;
    color: #e0e0e0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

body.dark-mode .title {
    color: #39A900;
}

body.dark-mode .info,
body.dark-mode .metric-label {
    color: #b0b0b0;
}

body.dark-mode .metric-value {
    color: #39A900;
}

body.dark-mode .img {
    filter: brightness(0.92) contrast(1.05);
}

/* Desktop grande (1400px y superior) */
@media screen and (min-width: 1400px) {
    .container {
        max-width: 1360px;
        margin: 0 auto;
        gap: 30px;
    }

    .dashboard-container {
        max-width: 1360px;
        margin: 20px auto;
        gap: 25px;
    }
}

/* Desktop normal y laptop (1024px - 1399px) */
@media screen and (max-width: 1399px) {
    .container {
        gap: 20px;
        padding: 15px;
    }

    .dashboard-container {
        padding: 15px;
        gap: 20px;
    }
}

/* Tablet (768px - 1023px) */
@media screen and (max-width: 1023px) {
    .container {
        gap: 15px;
    }

    .card {
        width: calc(33.33% - 20px);
        min-width: 220px;
    }

    .dashboard-container {
        grid-template-columns: 1fr; /* Cambiado a 1 columna */
        gap: 20px;
    }

    .metric-card {
        min-height: 300px; /* Altura ajustada */
    }

    .metric-card:nth-child(1) {
        grid-column: auto; /* Eliminamos el span */
    }

    canvas {
        width: 100% !important;
        max-height: 280px !important; /* Altura máxima ajustada */
    }
}

/* Tablet pequeña y móvil grande (481px - 767px) */
@media screen and (max-width: 767px) {
    .container {
        padding: 10px;
    }

    .card {
        width: calc(50% - 15px);
        min-width: 200px;
    }

    .dashboard-container {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .metric-card {
        min-height: 250px;
    }

    canvas {
        width: 100% !important;
        max-height: 230px !important;
    }
}

/* Móvil (480px y menor) */
@media screen and (max-width: 480px) {
    .container {
        padding: 10px 5px;
    }

    .card {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }

    .metric-card {
        padding: 15px;
    }

    canvas {
        max-height: 200px !important;
    }
}
  </style>
 

  <div class="container">
    <!-- Card Usuarios -->
    <a href='<?php echo '/usuario/view' ?>'>
      <div class="card">
        <div class="icon">
          <img src="../img/IconosCardsAdmin/Usuarios.svg" alt="">
        </div>
        <div class="title">Usuarios</div>
        <div class="info">Gestión de usuarios del sistema</div>
      </div>
    </a>


    <!-- Card Roles -->
    <a href='<?php echo '/rol/view' ?>'>
      <div class="card">
        <div class="icon">
          <!-- Icono de roles -->
          <img src="../img/IconosCardsAdmin/Roles.svg" alt="">
        </div>
        <div class="title">Roles</div>
        <div class="info">Control de Crud de Roles</div>
      </div>
    </a>
    <!-- Card Tipo Evento -->
    <a href='<?php echo '/tipoEvento/view' ?>'>
      <div class="card">
        <div class="icon">
          <img src="../img/IconosCardsAdmin/TipoEvento.svg" alt="">
        </div>
        <div class="title">Tipo Evento</div>
        <div class="info">Análisis Crud Tipo de Evento</div>
      </div>
    </a>

    <!-- Card Servicios -->
    <a href='<?php echo '/servicio/view' ?>'>
      <div class="card">
        <div class="icon">
          <img src="../img/IconosCardsAdmin/Servicio.svg" alt="">
        </div>
        <div class="title">Servicios</div>
        <div class="info">Gestión De Tipo de Servicio y Servicios</div>
      </div>
    </a>
    <!-- Card Tipo Servicios -->
    <a href='<?php echo '/tipoServicio/view' ?>'>
      <div class="card">
        <div class="icon">
          <img src="../img/IconosCardsAdmin/tipoServicios.svg" alt="">
        </div>
        <div class="title"> Tipo Servicios</div>
        <div class="info">Gestión De Tipo de Servicio </div>
      </div>
    </a>

    <!-- Card Estados -->
    <a href='<?php echo '/estado/view' ?>'>
      <div class="card">
        <div class="icon">
          <!-- Icono de estados -->
          <img src="../img/IconosCardsAdmin/Estados.svg" alt="">
        </div>
        <div class="title">Estados</div>
        <div class="info">Gestión de estados</div>
      </div>
    </a>

  </div>
  <section>
    <main class="dashboard-container">
      <div class="metric-card">
        <div class="chart-placeholder">
          <canvas id="myChart"  width="400px" height="90px"></canvas>
    </div>
      </div>
      <div class="metric-card">
        <canvas id="requestinprocess" width="200px" height="90px"></canvas>
      </div>
      <div class="metric-card">
        <canvas id="serviciospedidos" width="400px" height="200px"></canvas>
      </div>
      <div class="metric-card">
        <canvas id="topMunicipios" width="300px" height="200px"></canvas>
      </div>
      <div class="metric-card">
        <canvas id="solicitudesPorEstado" width="300px" height="200px"></canvas>
      </div>
    </main>
  </section>