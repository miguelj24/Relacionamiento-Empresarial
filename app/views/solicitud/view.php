<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<style>
    .table {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        margin-top: 20px;
        overflow-y: auto;
        /* Habilita scroll vertical */
        max-height: 420px;
        /* Ajusta la altura máxima según tu preferencia */
        overflow-x: hidden;
        /* Opcional: oculta scroll horizontal */
    }

    .titulos,
    .solicitud-row {
        border-bottom: 3px solid #f0f0f0;
        display: grid;
        grid-template-columns: 40px 1fr 1fr 0.7fr 1fr 1.2fr;
        /* Estado más angosto */
        align-items: center;
        text-align: center;
        gap: 6px;
    }

    .titulos div {
        font-weight: bold;
        padding: 8px 0;
        font-size: 0.92rem;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .solicitud-row div {
        margin: 2px 0;
        padding: 6px 4px;
        font-size: 0.88rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .solicitud-row {
        transition: background 0.3s;
        border-bottom: 1px solid #f0f0f0;
    }

    .solicitud-row:hover {
        background: #f1f7fa;
    }

    span {
        color: #555;
        font-size: 0.95rem;
    }

    /* ------------------------------ AQUI SE ENCUENTRA  LOS COLORES PARA EL SEMAFORO INDICADOR  ---------------------*/
    .status-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        margin: 0 auto;
        border: 2px solid #e0e0e0;
    }

        /* --- Verdes --- */
    .status-green-soft { background-color: #8BC34A; }      /* verde suave (pendiente reciente) */
    .status-green { background-color: #4CAF50; }           /* verde normal (en proceso) */
    .status-green-strong { background-color: #2E7D32; }    /* verde intenso (ejecutado o cerrado) */

    /* --- Amarillos/Naranjas --- */
    .status-yellow-light { background-color: #FFF176; }    /* amarillo claro (ejecutado a tiempo) */
    .status-yellow { background-color: #FDD835; }          /* amarillo estándar */
    .status-yellow-dark { background-color: #FBC02D; }     /* amarillo más oscuro */
    .status-orange-dark { background-color: #E65100; }     /* naranja muy oscuro (pendiente con retraso) */

    /* --- Rojos --- */
    .status-red { background-color: #E53935; }             /* rojo normal */
    .status-red-dark { background-color: #B71C1C; }        /* rojo intenso/crítico */

    /* === Mensaje flotante semaforización === */
#semaforizacion-alert-container {
  position: absolute;
  z-index: 1000;
}

.alert-semaforizacion {
  position: fixed;
  background: #fff;
  border-radius: 8px;
  padding: 8px 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.25);
  font-size: 14px;
  min-width: 180px;
  max-width: 240px;
  border-left: 6px solid;
  animation: fadeInSemaforizacion 0.25s ease;
}
.alert-content {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
/* === Título y descripción === */
.alert-content h4 {
  margin: 0;
  font-size: 15px;
  font-weight: bold;
  color: #333;
}

.alert-content p {
  margin: 0;
  color: #666;
  font-size: 13px;
  line-height: 1.3em;
}


/* === VERDES === */
.alert-semaforizacion.success-green-soft { border-color: #8BC34A; }
.alert-semaforizacion.success-green { border-color: #4CAF50; }
.alert-semaforizacion.success-green-strong { border-color: #2E7D32; }

/* === AMARILLOS === */
.alert-semaforizacion.warning-yellow-light { border-color: #FFF176; }
.alert-semaforizacion.warning-yellow { border-color: #FDD835; }
.alert-semaforizacion.warning-yellow-dark { border-color: #FBC02D; }

/* === NARANJA === */
.alert-semaforizacion.warning-orange-dark { border-color: #E65100; }

/* === ROJOS === */
.alert-semaforizacion.danger-red { border-color: #E53935; }
.alert-semaforizacion.danger-red-dark { border-color: #B71C1C; }

/* === INFO / DEFAULT === */
.alert-semaforizacion.info { border-color: #9E9E9E; }


/* Animación */
@keyframes fadeInSemaforizacion {
  from { opacity: 0; transform: translateY(-5px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Íconos según tipo */
.alert-semaforizacion.success::before { content: "✅ "; }
.alert-semaforizacion.warning::before { content: "⚠️ "; }
.alert-semaforizacion.danger::before  { content: "❌ "; }
.alert-semaforizacion.info::before  { content: "📌 "; }

    .service-badge {
        padding: 3px 8px;
        border-radius: 14px;
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .service-badge.light {
        color: #333;
    }

    .service-badge.dark {
        color: #fff;
    }

    
    /* Estilo para la barra de búsqueda */
    .search-bar {
        position: relative;
        flex-grow: 1;
        max-width: 300px;
        margin-left: 50px;
        border-bottom: 1px solid #e0e0e0;
    }

    .search-bar input[type="text"] {
        width: 90%;
        padding: 10px 15px 10px 35px;
        font-size: 16px;
        border: none;
        border-radius: 30px;
        outline: none;
        background-color: white;
    }

    .search-bar .search-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: gray;
    }

    .filters {
        display: flex;
        padding: 20px;
        gap: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        /* Esto centra el elemento */
    }

    .search-container {
        flex: 1;
        min-width: 200px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }

    .form-group label {
        font-size: 14px;
        color: #444;
        font-weight: 700;
    }

    .form-control {
        padding: 10px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 30px;
        font-size: 14px;
        width: 100%;
        background-color: white;
        color: #333;
        outline: none;
        transition: all 0.3s ease;
    }

    .no-results {
        font-size: 20px;
        color: red;
        text-align: center;
        display: none;
    }

    /* .form-control:focus {
        border-color: #09669C;
        box-shadow: 0 0 0 2px rgba(9, 102, 156, 0.1);
    } */

    /* ESTILOS ESPECÍFICOS PARA EL MODAL DEL ADMIN LAYOUT */
    /* Renombramos las clases para evitar conflictos */
    .logout-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        /* Mayor z-index que el modal original */
        backdrop-filter: blur(4px);
    }

    .logout-modal-overlay.show {
        display: flex;
    }

    .logout-modal-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        text-align: center;
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }

    .logout-modal-overlay.show .logout-modal-content {
        transform: scale(1);
    }

    body.dark-mode .logout-modal-content {
        background: #2d2d2d;
        color: #e0e0e0;
    }

    .logout-modal-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #fef3cd;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    body.dark-mode .logout-modal-icon {
        background: #654321;
    }

    .logout-modal-icon i {
        font-size: 24px;
        color: #f59e0b;
    }

    .logout-modal-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #374151;
    }

    body.dark-mode .logout-modal-title {
        color: #e0e0e0;
    }

    .logout-modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    body.dark-mode .logout-modal-message {
        color: #9ca3af;
    }

    .logout-modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .logout-modal-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 80px;
    }

    .logout-modal-btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .logout-modal-btn-cancel:hover {
        background: #e5e7eb;
    }

    body.dark-mode .logout-modal-btn-cancel {
        background: #4b5563;
        color: #e0e0e0;
    }

    body.dark-mode .logout-modal-btn-cancel:hover {
        background: #6b7280;
    }

    .logout-modal-btn-confirm {
        background: #dc2626;
        color: white;
    }

    .logout-modal-btn-confirm:hover {
        background: #b91c1c;
    }

    /* Modal original para otras funcionalidades */
    .modal {
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        width: 90%;
        height: 700px;
        max-width: 700px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        color: #888;
        cursor: pointer;
    }

   

   

    

    .archivados-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        /* Fondo blanco */
        color: #09669C;
        /* Texto azul */
        padding: 7px 18px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        border: 2px solid #09669C;
        /* Borde azul */
        transition: background 0.2s, color 0.2s;
    }

    .archivados-btn:hover {
        background: #09669C;
        /* Fondo azul al pasar */
        color: #fff;
        /* Texto blanco al pasar */
    }

    .archivados-btn i {
        font-size: 1.1rem;
    }

    /* MODO OSCURO PARA TABLA Y FILTROS */
    /* filepath: e:\RelacionamientoEmpresarial\app\views\solicitud\view.php */

    body.dark-mode .table {
        background: #23272a;
        color: #e0e0e0;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.4);
    }

    body.dark-mode .titulos,
    body.dark-mode .solicitud-row {
        background: #23272a;
        border-bottom: 3px solid #393e42;
        color: #e0e0e0;
    }

    body.dark-mode .titulos div {
        color: #e0e0e0;
    }

    body.dark-mode .solicitud-row div {
        color: #e0e0e0;
    }

    body.dark-mode .solicitud-row:hover {
        background: #2d3238;
    }

    body.dark-mode .service-badge.light {
        color: #e0e0e0;
        background: #393e42;
    }

    body.dark-mode .service-badge.dark {
        color: #fff;
        background: #393e42;
    }

    body.dark-mode .status-indicator {
        border: 2px solid #393e42;
    }

    body.dark-mode .filters {
        background: #23272a;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.4);
    }

    body.dark-mode .form-group label {
        color: #e0e0e0;
    }

    body.dark-mode .form-control,
    body.dark-mode input,
    body.dark-mode select {
        background: #393e42;
        color: #e0e0e0 !important;
        border-color: #393e42;
    }

    body.dark-mode .form-control:focus {
        border-color: #09669C;
        box-shadow: 0 0 0 2px rgba(9, 102, 156, 0.2);
    }

    body.dark-mode .search-bar {
        background: #393e42;
        border-bottom: 1px solid #393e42;
    }

    body.dark-mode .search-bar input[type="text"] {
        background: #393e42;
        color: #e0e0e0;
    }

    body.dark-mode .search-bar .search-icon {
        color: #b0b0b0;
    }

    body.dark-mode .no-results {
        color: #ff7675;
    }

    /* MODAL DE CONFIRMACIÓN DE ELIMINACIÓN */
    .delete-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 10001;
        /* Mayor que el modal de logout */
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease;
    }

    .delete-modal-overlay.show {
        display: flex;
    }

    .delete-modal-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        text-align: center;
        transform: scale(0.9);
        transition: transform 0.3s ease;
        position: relative;
    }

    .delete-modal-overlay.show .delete-modal-content {
        transform: scale(1);
    }

    .delete-modal-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    .delete-modal-icon i {
        font-size: 28px;
        color: #dc2626;
    }

    .delete-modal-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #374151;
    }

    .delete-modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .delete-modal-client-name {
        font-weight: 600;
        color: #dc2626;
    }

    .delete-modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .delete-modal-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 100px;
        position: relative;
        overflow: hidden;
    }

    .delete-modal-btn:hover {
        transform: translateY(-1px);
    }

    .delete-modal-btn-cancel {
        background: #f3f4f6;
        color: #374151;
        border: 2px solid #e5e7eb;
    }

    .delete-modal-btn-cancel:hover {
        background: #e5e7eb;
        border-color: #d1d5db;
    }

    .delete-modal-btn-confirm {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        border: 2px solid transparent;
        box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.39);
    }

    .delete-modal-btn-confirm:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    /* MODO OSCURO */
    body.dark-mode .delete-modal-content {
        background: #2d2d2d;
        color: #e0e0e0;
    }

    body.dark-mode .delete-modal-icon {
        background: #7f1d1d;
    }

    body.dark-mode .delete-modal-icon i {
        color: #fca5a5;
    }

    body.dark-mode .delete-modal-title {
        color: #e0e0e0;
    }

    body.dark-mode .delete-modal-message {
        color: #9ca3af;
    }

    body.dark-mode .delete-modal-client-name {
        color: #fca5a5;
    }

    body.dark-mode .delete-modal-btn-cancel {
        background: #4b5563;
        color: #e0e0e0;
        border-color: #6b7280;
    }

    body.dark-mode .delete-modal-btn-cancel:hover {
        background: #6b7280;
        border-color: #9ca3af;
    }

    body.dark-mode .delete-modal-btn-confirm {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }
   

    /* Botón de tres puntos */
    .action-dropdown {
        position: relative;
        /* Esto hace que el menú se posicione relativo al botón */
        display: inline-block;
    }

    .dropdown-toggle {
        cursor: pointer;
        padding: 6px 10px;
        border: none;
        background: transparent;
        font-size: 18px;
    }

    .dropdown-menu {
        display: none;
        list-style: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #e5e7eb;
        min-width: 80px;
        /* Más angosto para caber al lado derecho */
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.13);
        z-index: 99999;
        border-radius: 12px;
        padding: 4px 0;
        padding-left: 2px;
        /* Menor padding lateral */
        padding-right: 2px;
        top: 100%;
        left: unset;
        right: 10px;
        /* Siempre pegado al lado derecho del contenedor */
        overflow: hidden;
    }

    .dropdown-menu li {
        border-bottom: 1px solid #f0f0f0;
    }

    .dropdown-menu li:last-child {
        border-bottom: none;
    }

    .dropdown-menu a,
    .dropdown-menu li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 8px;
        /* Menos padding horizontal */
        color: #222;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.18s, color 0.18s;
        border-radius: 0;
        justify-content: flex-start;
    }

    .dropdown-menu a i,
    .dropdown-menu li a i {
        font-size: 1.08em;
        color: #888;
        min-width: 18px;
        text-align: center;
    }

    .dropdown-menu a:hover,
    .dropdown-menu li a:hover {
        background-color: #f5f7fa;
        color: #09669C;
    }

    body.dark-mode .dropdown-menu {
        background: #23272a;
        border-color: #393e42;
    }

    body.dark-mode .dropdown-menu li {
        border-bottom: 1px solid #393e42;
    }

    body.dark-mode .dropdown-menu a,
    body.dark-mode .dropdown-menu li a {
        color: #e0e0e0;
    }

    body.dark-mode .dropdown-menu a:hover,
    body.dark-mode .dropdown-menu li a:hover {
        background: #2d3238;
        color: #4fc3f7;
    }

    /* =======================  RESPONSIVE DESIGN ======================= */

/* Pantallas medianas: tablets, laptops pequeñas */
@media (max-width: 900px) {

    .titulos,
    .solicitud-row {
        grid-template-columns: 20px 1fr 1fr 0.7fr 1fr 1.2fr;
        font-size: 0.85rem;
    }

    .titulos > div,
    .solicitud-row > div {
        padding: 4px 2px;
        font-size: 0.82rem;
    }

    .status-indicator {
        width: 14px;
        height: 14px;
    }

    .filters {
        width: 95%;
        flex-direction: column;
        padding: 15px;
        gap: 15px;
    }

    .search-container {
        width: 100%;
    }

    .search-bar {
        margin-left: 0;
        max-width: 100%;
    }

    .form-group label {
        font-size: 13px;
    }

    .form-control {
        font-size: 13px;
        padding: 8px 12px;
    }

    .archivados-btn {
        font-size: 0.9rem;
        padding: 6px 14px;
    }

    .alert-semaforizacion {
        font-size: 13px;
        min-width: 150px;
        max-width: 200px;
        padding: 6px 10px;
    }

    .alert-content h4 {
        font-size: 14px;
    }

    .alert-content p {
        font-size: 12px;
    }

}

/* === Pantallas pequeñas: móviles (≤ 480px) === */
@media (max-width: 480px) {

* {
    box-sizing: border-box;
}


main {
    padding: 0 8px;
    max-width: 100%;
}
.titulos {
    display: none;
}
.solicitud-row {
    display: grid;
    grid-template-columns: 18px 100px 100px 20px; /* semáforo | nombre/estado | fecha/servicio | menú */
    grid-template-rows: auto auto; /* dos filas: arriba (cliente, fecha) / abajo (estado, servicio) */
    align-items: center;
    gap: 4px 6px; /* espacio entre filas y columnas */
    padding: 6px 8px;
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    font-size: 0.8rem;
    width: 100%;
}

/* 🔹 Semáforo: ocupa ambas filas */
.solicitud-row > div:nth-child(1) {
    grid-row: 1 / span 2;
    grid-column: 1;
    align-self: center;
}

/* 🔹 Nombre del cliente (arriba a la izquierda) */
.solicitud-row > div:nth-child(3) {
    grid-column: 2;
    grid-row: 1;
    font-weight: 600;
    white-space: normal;
    word-break: break-word;
}

/* 🔹 Fecha (arriba a la derecha) */
.solicitud-row > div:nth-child(4) {
    grid-column: 3;
    grid-row: 1;
    text-align: right;
    font-size: 0.78rem;
    color: #555;
}

/* 🔹 Estado (debajo del nombre) */
.solicitud-row > div:nth-child(5) {
    grid-column: 2;
    grid-row: 2;
}

/* 🔹 Servicio (debajo de la fecha) */
.solicitud-row > div:nth-child(2) {
    grid-column: 3;
    grid-row: 2;
    text-align: right;
}

/* 🔹 Menú de acciones (ocupa toda la altura, columna 4) */
.solicitud-row > .action-dropdown {
    grid-column: 4;
    grid-row: 1 / span 2;
    justify-self: end;
    align-self: center;
}

/* 🔹 Badges (estado/servicio) más compactos */
.service-badge {
    padding: 2px 6px;
    border-radius: 5px;
    font-size: 0.7rem;
    display: inline-block;
}


/* 🔹 Badges compactos */
.service-badge {
    padding: 2px 6px;
    border-radius: 5px;
    font-size: 0.7rem;
    display: inline-block;
    margin-top: 2px;
}


    /* 🔹 Dropdown reducido */
    .action-dropdown {
        justify-self: end;
        position: relative;
        margin-left: auto;
    }

    .action-dropdown .dropdown-toggle {
        font-size: 13px;
        padding: 2px 5px;
    }

    /* 🔹 Filtros compactos */
    .filters {
        flex-direction: column;
        width: 90%;
        padding: 8px;
        gap: 6px;
    }

    .form-group label {
        font-size: 12px;
    }

    .form-control {
        font-size: 12px;
        padding: 6px 8px;
    }

    /* 🔹 Barra de búsqueda */
    .search-bar {
        margin-left: 0;
    }

    .search-bar input[type="text"] {
        width: 90%;
        font-size: 13px;
        padding: 7px 10px 7px 26px;
    }

    .search-icon {
        left: 7px;
        font-size: 12.5px;
    }

    /* 🔹 Botón archivados */
    .archivados-btn {
        font-size: 0.8rem;
        padding: 5px 9px;
    }

    /* 🔹 Alertas pequeñas */
    .alert-semaforizacion {
        font-size: 12px;
        min-width: 120px;
        max-width: 170px;
        padding: 5px 7px;
        border-radius: 6px;
        z-index: 9999;
    }

    .alert-content h4 {
        font-size: 13px;
    }

    .alert-content p {
        font-size: 11.5px;
    }


    .solicitud-row > div {
        min-width: 0;
    }

    /* 🔹 Modales */
    .delete-modal-content,
    .logout-modal-content {
        padding: 15px;
        margin: 10px;
    }

    .delete-modal-buttons,
    .logout-modal-buttons {
        flex-direction: column;
        gap: 8px;
    }

    .delete-modal-btn,
    .logout-modal-btn {
        width: 100%;
    }

}

</style>


<?php
function adjustBrightness($hex, $steps)
{
    // Steps: -255 (más oscuro) a 255 (más claro)
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $r = max(0, min(255, hexdec(substr($hex, 0, 2)) + $steps));
    $g = max(0, min(255, hexdec(substr($hex, 2, 2)) + $steps));
    $b = max(0, min(255, hexdec(substr($hex, 4, 2)) + $steps));
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
?>


<!-- Modificación del HTML de los filtros -->
<div class="filters">
    <div class="search-container">
        <div class="form-group">
            <label>Buscar cliente</label>
            <div class="search-bar">
                <i class="fas fa-search search-icon"></i>
                <input id="searchInput" type="text" placeholder="Nombre del cliente...">
            </div>
            <p id="noResults" class="no-results">No se encontraron resultados.</p>
        </div>
    </div>
    <div class="search-container">
        <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="IdEstado" class="form-control">
                <option value="">Seleccione un estado</option>
                <?php foreach ($estados as $estado): ?>
                    <option value="<?php echo $estado->id; ?>">
                        <?php echo $estado->State; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="search-container">
        <div class="form-group">
            <label>Filtrar servicios</label>
            <select id="servicio" name="IdServicio" class="form-control">
                <option value="">Todos los servicios</option>
                <?php foreach ($servicios as $servicio): ?>
                    <option value="<?php echo $servicio->id; ?>">
                        <?php echo $servicio->service; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>


<?php
// Detectar si estamos en la sección de enviadas o archivadas
$isArchivadas = (isset($esArchivadas) && $esArchivadas) || 
    (strpos($_SERVER['REQUEST_URI'], '/solicitud/archivadas') !== false);
$isEnviadas = (isset($esEnviadas) && $esEnviadas) || 
    (strpos($_SERVER['REQUEST_URI'], '/solicitud/enviadas') !== false);

    $rolUsuario = $_SESSION['rol'] ?? null;
?>

<div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 18px;">
    <?php if ($isArchivadas): ?>
        <a href="/solicitud/view" class="archivados-btn">
            <i class="fas fa-list"></i> Mis solicitudes
        </a>
    <?php elseif ($isEnviadas && $rolUsuario != 1): ?>
        <a href="/solicitud/view" class="archivados-btn">
            <i class="fas fa-list"></i> Mis solicitudes
        </a>
    <?php else: ?>
        <a href="/solicitud/archivadas" class="archivados-btn">
            <i class="fas fa-archive"></i> Archivados
        </a>
        <?php if ($rolUsuario != 1): ?>
            <a href="/solicitud/enviadas" class="archivados-btn">
                <i class="fas fa-paper-plane"></i> Enviadas
            </a>
        <?php endif; ?>
        
    <?php endif; ?>
</div>

<main>

    <div class="table">
        <div class="titulos">
            <div></div>
            <div>Nombre Cliente</div>
            <div>Fecha Emisión</div>
            <div>Estado</div>
            <div>Servicio</div>
            <div>Acciones</div>
        </div>
        <?php if (empty($solicitudes)): ?>
            <?php if (in_array($_SESSION['rol'], [3, 4])): ?>
                <div class="solicitud-row">
                    <div colspan="6" style="text-align:center; width:80%;">Aún no tienes solicitudes asignadas.</div>
                </div>
            <?php else: ?>
                <div class="solicitud-row">
                    <div colspan="6" style="text-align:center; width:80%;">No se encuentran solicitudes </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php foreach ($solicitudes as $solicitud): ?>
                <?php
                $dias = (new DateTime())->diff(new DateTime($solicitud->createdAt))->days;
                $estado = strtolower($solicitud->FKstates);
                // === ID'S de los ESTADOS 
                // Pendiente == 1
                //Asignado == 3
                //En proceso == 4
                // Ejecutado == 5
                // Resuelto == 6
                //Ceerrado == 7
                $statusClass = "";
                // ----- Lógica combinada (tiempo + estado) ---
                if ($dias < 7) {
                    switch ($estado) {
                        case 1:
                            $statusClass = "status-green-soft"; // verde pero tenue
                            break;
                        case 3:
                        case 4:
                            $statusClass = "status-green"; // verde normal (va avanzando)
                            break;
                        case 5:
                        case 6:
                        case 7:
                            $statusClass = "status-green-strong"; // verde intenso (va muy bien)
                            break;
                        default:
                            $statusClass = "status-green-soft";
                    }
                } elseif ($dias <= 15) {
                    switch ($estado) {
                        case 1:
                            $statusClass = "status-orange-dark"; // naranja oscuro (atención)
                            break;
                        case 3:
                        case 4:
                            $statusClass = "status-yellow"; // amarillo intermedio
                            break;
                        case 5:
                            $statusClass = "status-yellow-light"; // amarillo claro (a punto de cerrar)
                            break;
                        case 6:
                        case 7:
                            $statusClass = "status-green-strong"; // sigue bien
                            break;
                        default:
                            $statusClass = "status-yellow";
                    }
                } else {
                    // más de 15 días
                    switch ($estado) {
                        case 1:
                            $statusClass = "status-red-dark"; // rojo muy oscuro (crítico)
                            break;
                        case 3:
                        case 4:
                            $statusClass = "status-orange-dark"; // naranja fuerte (demorado)
                            break;
                        case 5:
                            $statusClass = "status-yellow-dark"; // amarillo más oscuro
                            break;
                        case 6:
                        case 7:
                            $statusClass = "status-green-strong"; // ya finalizado, se mantiene verde
                            break;
                        default:
                            $statusClass = "status-red";
                    }
                }

                //Determinar si estamos en la vista de enviadas
                $isEnviadas = (isset($esEnviadas) && $esEnviadas) ||
                (strpos($_SERVER['REQUEST_URI'], '  /solicitudes/enviadas') !== false);
                // Mostrar botón archivar solo si estado es Resuelto (6) o Cerrado (7)
                $mostrarArchivar = in_array($solicitud->FKstates ?? $solicitud->id ?? null, [6, 7]);
                // Mostrar botón eliminar solo si es administrador (rol 4)
                $mostrarEliminar = isset($_SESSION['rol']) && $_SESSION['rol'] == 4 && !$isEnviadas;

                $mostrarEditar = !$isEnviadas;
                // Colores para servicio
                $colorOriginalServicio = $solicitud->service_color;
                $colorFondoServicio = adjustBrightness($colorOriginalServicio, 80);   // Más claro
                $colorBordeYTextoServicio = adjustBrightness($colorOriginalServicio, -60); // Más oscuro

                // Colores para estado
                $colorOriginalEstado = $solicitud->state_color ?? '#cccccc';
                $colorFondoEstado = adjustBrightness($colorOriginalEstado, 80);
                $colorBordeYTextoEstado = adjustBrightness($colorOriginalEstado, -60);
                ?>
                <div class="solicitud-row">
                    <div>
                        <span class="status-indicator <?= $statusClass ?>" onclick="mostrarMensajeSemaforizacion(this, '<?= $statusClass ?>')"></span>
                    </div>
                      <!-- Contenedor general de mensajes -->
                        <div id="semaforizacion-alert-container"></div>
                   
                    <div><?php echo htmlspecialchars($solicitud->NameClient); ?></div>
                    <div>
                    <?php echo htmlspecialchars(date('d/m/Y', strtotime($solicitud->createdAt))); ?>
                    </div>
                  
                    <div>
                        <span class="service-badge"
                            style="
                                background-color: <?php echo $colorFondoEstado; ?>;
                                color: <?php echo $colorBordeYTextoEstado; ?>;
                                border: 1.5px solid <?php echo $colorBordeYTextoEstado; ?>;
                            ">
                            <?php echo htmlspecialchars($solicitud->State); ?>
                        </span>
                    </div>
                    <div>
                        <span class="service-badge"
                            style="
                                background-color: <?php echo $colorFondoServicio; ?>;
                                color: <?php echo $colorBordeYTextoServicio; ?>;
                                border: 1.5px solid <?php echo $colorBordeYTextoServicio; ?>;
                            ">
                            <?php echo htmlspecialchars($solicitud->service); ?>
                        </span>
                    </div>
                    <div class="action-dropdown">
                        <button class="dropdown-toggle">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/solicitud/view/<?php echo $solicitud->id; ?>">
                                    <i class="fas fa-eye" style="margin-right: 8px;"></i> Ver
                                </a>
                            </li>
                            <?php if ($mostrarEditar): ?>
                            <li>
                                <a href="/solicitud/edit/<?php echo $solicitud->id; ?>">
                                    <i class="fas fa-edit" style="margin-right: 8px;"></i> Editar
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if ($mostrarEliminar): ?>
                                <li>
                                    <a href="/solicitud/delete/<?php echo $solicitud->id; ?>" class="eliminar">
                                        <i class="fas fa-trash-alt" style="margin-right: 8px;"></i> Eliminar
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($isArchivadas): ?>
                                <li>
                                    <a href="#" class="desarchivar" data-id="<?php echo $solicitud->id; ?>">
                                        <i class="fas fa-box-open" style="margin-right: 8px;"></i> Desarchivar
                                    </a>
                                </li>
                            <?php elseif ($mostrarArchivar): ?>
                                <li>
                                    <a href="#" class="archivar" data-id="<?php echo $solicitud->id; ?>">
                                        <i class="fas fa-archive" style="margin-right: 8px;"></i> Archivar
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

   

    <script>
document.addEventListener('DOMContentLoaded', () => {

    // =======================
    // FILTRO DE SOLICITUDES
    // =======================
    const searchInput = document.getElementById('searchInput');
    const estadoSelect = document.getElementById('estado');
    const servicioSelect = document.getElementById('servicio');
    const solicitudRows = document.querySelectorAll('.solicitud-row');
    const noResults = document.getElementById('noResults');

    function filterSolicitudes() {
        const searchTerm = searchInput.value.toLowerCase();
        const estadoSelected = estadoSelect.value;
        const servicioSelected = servicioSelect.value;
        let visibleRows = 0;

        solicitudRows.forEach(row => {
            const nombreCliente = row.children[1].textContent.toLowerCase();
            const estado = row.children[3].textContent.trim().toLowerCase();
            const servicio = row.children[4].textContent.trim().toLowerCase();

            const matchesSearch = nombreCliente.includes(searchTerm);
            const matchesEstado = !estadoSelected || estado === estadoSelect.options[estadoSelect.selectedIndex].text.toLowerCase();
            const matchesServicio = !servicioSelected || servicio === servicioSelect.options[servicioSelect.selectedIndex].text.toLowerCase();

            if (matchesSearch && matchesEstado && matchesServicio) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        noResults.style.display = visibleRows === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterSolicitudes);
    estadoSelect.addEventListener('change', filterSolicitudes);
    servicioSelect.addEventListener('change', filterSolicitudes);

    // =======================
    // MODALES DE ELIMINAR Y ARCHIVAR
    // =======================
    const modalHTML = `
        <!-- MODAL ELIMINAR -->
        <div id="deleteModal" class="delete-modal-overlay">
            <div class="delete-modal-content">
                <div class="delete-modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <h3 class="delete-modal-title">¿Confirmar eliminación?</h3>
                <p class="delete-modal-message">
                    Esta acción eliminará permanentemente la solicitud de 
                    <span id="clientName"></span>.<br><br>
                    <strong>Esta acción no se puede deshacer.</strong>
                </p>
                <div class="delete-modal-buttons">
                    <button type="button" class="delete-modal-btn" id="cancelDelete"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="button" class="delete-modal-btn" id="confirmDelete"><i class="fas fa-trash-alt"></i> Eliminar</button>
                </div>
            </div>
        </div>

        <!-- MODAL ARCHIVAR -->
        <div id="archiveModal" class="delete-modal-overlay">
            <div class="delete-modal-content">
                <div class="delete-modal-icon"><i class="fas fa-archive"></i></div>
                <h3 class="delete-modal-title">¿Archivar solicitud?</h3>
                <p class="delete-modal-message">
                    Esta acción archivará la solicitud de 
                    <span id="archiveClientName"></span>.<br><br>
                    Podrás consultarla en la sección de archivados.
                </p>
                <div class="delete-modal-buttons">
                    <button type="button" class="delete-modal-btn" id="cancelArchive"><i class="fas fa-times"></i> Cancelar</button>
                    <button type="button" class="delete-modal-btn" id="confirmArchive"><i class="fas fa-archive"></i> Archivar</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // ===== ELIMINAR =====
    const deleteModal = document.getElementById('deleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const clientNameSpan = document.getElementById('clientName');
    let deleteUrl = '';
    let currentRow = null;

    function showDeleteModal(url, clientName, row) {
        deleteUrl = url;
        currentRow = row;
        clientNameSpan.textContent = clientName;
        deleteModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function hideDeleteModal() {
        deleteModal.classList.remove('show');
        document.body.style.overflow = '';
        deleteUrl = '';
        currentRow = null;
    }

    document.querySelectorAll('.eliminar').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const url = btn.getAttribute('href');
            const row = btn.closest('.solicitud-row');
            const clientName = row.children[1].textContent.trim();
            showDeleteModal(url, clientName, row);
        });
    });

    cancelDeleteBtn.addEventListener('click', hideDeleteModal);
    confirmDeleteBtn.addEventListener('click', () => {
        if (deleteUrl) {
            confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Eliminando...';
            confirmDeleteBtn.disabled = true;
            window.location.href = deleteUrl;
        }
    });

    deleteModal.addEventListener('click', e => { if (e.target === deleteModal) hideDeleteModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && deleteModal.classList.contains('show')) hideDeleteModal(); });

    // ===== ARCHIVAR =====
    const archiveModal = document.getElementById('archiveModal');
    const cancelArchiveBtn = document.getElementById('cancelArchive');
    const confirmArchiveBtn = document.getElementById('confirmArchive');
    const archiveClientNameSpan = document.getElementById('archiveClientName');
    let archiveId = '';
    let archiveRow = null;

    function showArchiveModal(id, clientName, row) {
        archiveId = id;
        archiveRow = row;
        archiveClientNameSpan.textContent = clientName;
        archiveModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function hideArchiveModal() {
        archiveModal.classList.remove('show');
        document.body.style.overflow = '';
        archiveId = '';
        archiveRow = null;
    }

    document.querySelectorAll('.archivar').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.getAttribute('data-id');
            const row = btn.closest('.solicitud-row');
            const clientName = row.children[1].textContent.trim();
            showArchiveModal(id, clientName, row);
        });
    });

    cancelArchiveBtn.addEventListener('click', hideArchiveModal);
    confirmArchiveBtn.addEventListener('click', () => {
        if (!archiveId) return;
        confirmArchiveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Archivando...';
        confirmArchiveBtn.disabled = true;

        fetch(`/solicitud/archivar/${archiveId}`, { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if (data.success && archiveRow) archiveRow.style.display = 'none';
                hideArchiveModal();
                confirmArchiveBtn.innerHTML = '<i class="fas fa-archive"></i> Archivar';
                confirmArchiveBtn.disabled = false;
            })
            .catch(() => {
                confirmArchiveBtn.innerHTML = '<i class="fas fa-archive"></i> Archivar';
                confirmArchiveBtn.disabled = false;
            });
    });

    archiveModal.addEventListener('click', e => { if (e.target === archiveModal) hideArchiveModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && archiveModal.classList.contains('show')) hideArchiveModal(); });

    // ===== DESARCHIVAR =====
    document.querySelectorAll('.desarchivar').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.dataset.id;
            fetch(`/solicitud/desarchivarSolicitud/${id}`, { method: 'POST' })
                .then(res => res.json())
                .then(data => {
                    if (data.success) btn.closest('.solicitud-row').remove();
                    else alert('No se pudo desarchivar');
                });
        });
    });

});

function mostrarMensajeSemaforizacion(element, statusClass) {
  const container = document.getElementById('semaforizacion-alert-container');
  container.innerHTML = ''; // elimina mensajes anteriores

  const mensaje = document.createElement('div');
  mensaje.classList.add('alert-semaforizacion');
  let title = '';
  let description = '';

  // Define el contenido según el color (semaforización)
  switch (statusClass) {
    case 'status-green-soft':
         title = '¡Buen comienzo!';
        description = 'Esta solicitud está iniciando correctamente. Mantén el ritmo.';
        mensaje.classList.add('success','success-green-soft');
        break;
    case 'status-green':
        title = '¡Vas muy bien!';
        description = 'La solicitud avanza según lo esperado. Buen progreso.';
        mensaje.classList.add('success','success-green');
        break;
    case 'status-green-strong':
       title = '¡Excelente progreso!';
        description = 'La solicitud está en muy buen estado y casi finalizada. ¡Felicitaciones!';
        mensaje.classList.add('success','success-green-strong');
      break;
    case 'status-yellow-light':
        title = 'Casi listo';
        description = 'La solicitud está por completarse, pero aún requiere seguimiento.';
        mensaje.classList.add('info','warning-yellow-light');
    break;
    case 'status-yellow':
        title = 'Atención moderada';
        description = 'Tu solicitud lleva algunos días. Revisa su avance para evitar demoras.';
        mensaje.classList.add('warning','warning-yellow');
    break;
    case 'status-yellow-dark':
        title = 'Advertencia';
        description = 'Esta solicitud está tomando más tiempo de lo esperado. Verifica su estado.';
        mensaje.classList.add('warning','warning-yellow-dark');
    break;
    case 'status-orange-dark':
        title = 'Precaución';
        description = 'Tu solicitud podría estar retrasándose. Considera hacer seguimiento.';
        mensaje.classList.add('warning', 'warning-orange-dark');
    break;
    case 'status-red':
        title = 'Demora detectada';
        description = 'Esta solicitud ha superado el tiempo recomendado. Requiere atención.';
        mensaje.classList.add('danger', 'danger-red');
    break;
    case 'status-red-dark':
        title = '¡Atención urgente!';
        description = 'La solicitud lleva demasiado tiempo pendiente. Actúa cuanto antes.';
        mensaje.classList.add('danger','danger-red-dark');
    break;
    default:
        title = 'Información';
        description = 'No se pudo determinar el estado exacto de esta solicitud.';
        mensaje.classList.add('info');
  }
   mensaje.innerHTML = `
    <div class="alert-content">
      <h4>${title}</h4>
      <p>${description}</p>
    </div>
  `;

  // Calcula la posición al lado derecho del punto
  const rect = element.getBoundingClientRect();
  mensaje.style.top = (rect.top + window.scrollY - 2) + 'px';
  mensaje.style.left = (rect.right + 10 + window.scrollX) + 'px';

  // Agrega al contenedor
  container.appendChild(mensaje);

  // --- Ocultar la alerta si el usuario hace scroll ---
window.addEventListener('scroll', () => {
  const alerta = document.querySelector('.alert-semaforizacion');
  if (alerta) alerta.remove();
});

// --- Si tu tabla tiene un contenedor con scroll interno ---
const tabla = document.querySelector('.table');
if (tabla) {
  tabla.addEventListener('scroll', () => {
    const alerta = document.querySelector('.alert-semaforizacion');
    if (alerta) alerta.remove();
  });
}


  // Se elimina automáticamente a los 3 segundos
  setTimeout(() => mensaje.remove(), 3000);
}




</script>

    <script src="/js/ActionsRequest.js"></script>


</main>