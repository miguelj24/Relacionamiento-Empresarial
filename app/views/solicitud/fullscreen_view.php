<?php
// Si no necesitas ejecutar nada antes del HTML, elimina directamente esta línea
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f4f7f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .header-container {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-top h1 {
            color: #333;
            font-size: 1.8rem;
            font-weight: 600;
            text-align: center;
            flex-grow: 1; /* <-- Añade esta línea */
        }

                body.dark-mode .header-top h1 {
            color: #ffffff;  /* Blanco en modo oscuro */
        }

        .exit-fullscreen {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .exit-fullscreen:hover {
            background: #c82333;
        }

        .filters-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-size: 0.9rem;
            color: #555;
            font-weight: 500;
        }

        .filter-group input,
        .filter-group select {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
            background: white;
            transition: border-color 0.2s;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .filter-toggle-btn {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }

        .filter-toggle-btn:hover {
            background: #45a049;
        }

        .filter-toggle-btn.disabled {
            background: #95a5a6;
        }

        .fullscreen-container {
            display: flex;
            gap: 20px;
            padding: 0 15px 15px;
            width: 100%;
        }

        .column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .solicitud-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-left: 5px solid #4CAF50; /* BORDE VERDE APLICADO */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .solicitud-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .solicitud-card.hidden {
            display: none;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: #333;
            font-weight: 600;
        }

        .card-header span {
            font-size: 0.85rem;
            color: #777;
        }

        .card-body p {
            margin: 8px 0;
            font-size: 0.9rem;
            color: #555;
            display: flex;
            align-items: center;
        }

        .card-body strong {
            color: white;
            min-width: 80px;
            display: inline-block;
        }

        .service-badge {
            padding: 4px 10px;
            border-radius: 16px;
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1.5px solid transparent;
        }

        .card-actions {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .card-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .card-action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-view { background-color: #e7f3fe; color: #09669C; border-color: #b3d9f5; }
        .btn-edit { background-color: #fff8e1; color: #f57f17; border-color: #ffecb3; }
        .btn-delete { background-color: #ffebee; color: #c62828; border-color: #ffcdd2; }
        .btn-archive { background-color: #f3e5f5; color: #6a1b9a; border-color: #e1bee7; }
        .btn-unarchive { background-color: #e8f5e9; color: #2e7d32; border-color: #c8e6c9; }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #777;
            font-size: 1.1rem;
            display: none; /* Oculto por defecto */
        }

        @media (max-width: 968px) {
            .filters-container {
                grid-template-columns: 1fr 1fr;
            }
            .filter-toggle-btn { grid-column: 1 / -1; }
        }

        @media (max-width: 768px) {
            .fullscreen-container { flex-direction: column; }
            .filters-container { grid-template-columns: 1fr; }
            .header-top { flex-direction: column; gap: 15px; align-items: stretch; }
            .header-top h1 { font-size: 1.5rem; }
        }

        /* Estilos para modo oscuro */
        body.dark-mode {
            background-color: #18191a;
            color: #e0e0e0;
        }

        body.dark-mode .header-container {
            background: #23272a;
            color: #e0e0e0;
        }

        body.dark-mode .titleSisrel {
            color: #39a900;
        }

        body.dark-mode .solicitud-card {
            background: #242526;
            color: #e0e0e0;
            border-left: 5px solid #4CAF50;
        }

        body.dark-mode .card-header {
            border-bottom-color: #393e42;
        }

        body.dark-mode .card-header h3 {
            color: #e0e0e0;
        }

        body.dark-mode .card-header span {
            color: #b0b0b0;
        }

        body.dark-mode .filter-group label {
            color: #b0b0b0;
        }

        body.dark-mode .filter-group input,
        body.dark-mode .filter-group select {
            background: #242526;
            border-color: #393e42;
            color: #e0e0e0;
        }

        body.dark-mode .filter-group input:disabled,
        body.dark-mode .filter-group select:disabled {
            background: #18191a;
        }

        body.dark-mode .filter-toggle-btn {
            background: #393e42;
            color: #e0e0e0;
        }

        body.dark-mode .filter-toggle-btn:hover {
            background: #4b535a;
        }

        body.dark-mode .exit-fullscreen {
            background: #dc3545;
            color: #e0e0e0;
        }

        body.dark-mode .exit-fullscreen:hover {
            background: #c82333;
        }

        /* Modo oscuro para el modal de eliminación */
        body.dark-mode .swal2-popup {
            background: #242526;
            color: #e0e0e0;
        }

        body.dark-mode .swal2-title,
        body.dark-mode .swal2-content {
            color: #e0e0e0;
        }

        body.dark-mode .swal2-actions button {
            background: #393e42;
            color: #e0e0e0;
        }

        body.dark-mode .swal2-actions button:hover {
            background: #4b535a;
        }

        body.dark-mode .no-results {
            color: #b0b0b0;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="header-top">
            <h1>Solicitudes</h1>
            <a href="/solicitud/view" class="exit-fullscreen">
                Regresar
            </a>
        </div>

        <div class="filters-container">
            <div class="filter-group">
                <label for="filter-client">Buscar Cliente</label>
                <input type="text" id="filter-client" placeholder="Nombre del cliente..." disabled>
            </div>
            <div class="filter-group">
                <label for="filter-state">Estado</label>
                <select id="filter-state" disabled><option value="">Todos los estados</option></select>
            </div>
            <div class="filter-group">
                <label for="filter-service">Filtrar Servicio</label>
                <select id="filter-service" disabled><option value="">Todos los servicios</option></select>
            </div>
            <button class="filter-toggle-btn" id="toggle-filters">
                <i class="fas fa-filter"></i> Habilitar Filtros
            </button>
        </div>
    </div>

    <div class="fullscreen-container">
        <div class="column" id="column-a"></div>
        <div class="column" id="column-b"></div>
    </div>
    <div class="no-results" id="no-results-message">No se encontraron solicitudes que coincidan con los filtros.</div>

    <?php
        // Detectar si estamos en la sección de enviadas o archivadas
        $isArchivadas = (isset($esArchivadas) && $esArchivadas) || (strpos($_SERVER['REQUEST_URI'], '/solicitud/archivadas') !== false);
        $isEnviadas = (isset($esEnviadas) && $esEnviadas) || (strpos($_SERVER['REQUEST_URI'], '/solicitud/enviadas') !== false);
        $rolUsuario = $_SESSION['rol'] ?? null;
    ?>

    <script>
    // Pasamos las variables de sesión y de estado de PHP a JavaScript
    const USER_ROLE = <?php echo json_encode($rolUsuario); ?>;
    const IS_ARCHIVADAS_VIEW = <?php echo json_encode($isArchivadas); ?>;
    const IS_ENVIADAS_VIEW = <?php echo json_encode($isEnviadas); ?>;

    document.addEventListener('DOMContentLoaded', () => {
        const allSolicitudes = <?php echo json_encode($solicitudes); ?>;
        
        const columnAContainer = document.getElementById('column-a');
        const columnBContainer = document.getElementById('column-b');
        const filterClient = document.getElementById('filter-client');
        const filterState = document.getElementById('filter-state');
        const filterService = document.getElementById('filter-service');
        const toggleBtn = document.getElementById('toggle-filters');
        const noResultsMessage = document.getElementById('no-results-message');
        
        let filtersEnabled = false;
        let allCards = [];

        const adjustBrightnessJS = (hex, steps) => {
            if (!hex) hex = '#CCCCCC';
            let color = hex.replace('#', '');
            if (color.length === 3) color = color.split('').map(c => c + c).join('');
            let r = Math.max(0, Math.min(255, parseInt(color.substring(0, 2), 16) + steps));
            let g = Math.max(0, Math.min(255, parseInt(color.substring(2, 4), 16) + steps));
            let b = Math.max(0, Math.min(255, parseInt(color.substring(4, 6), 16) + steps));
            return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
        };

        const createCard = solicitud => {
            const card = document.createElement('div');
            card.className = 'solicitud-card';
            card.dataset.client = solicitud.NameClient.toLowerCase();
            card.dataset.stateId = solicitud.FKstates;
            card.dataset.serviceId = solicitud.FKservices;
            
            const fecha = new Date(solicitud.createdAt).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
            const bgColorEstado = adjustBrightnessJS(solicitud.state_color, 80);
            const textColorEstado = adjustBrightnessJS(solicitud.state_color, -60);
            const bgColorServicio = adjustBrightnessJS(solicitud.service_color, 80);
            const textColorServicio = adjustBrightnessJS(solicitud.service_color, -60);

            // --- Lógica para generar botones de acción ---
            let actionsHTML = '';
            const mostrarArchivar = ['6', '7'].includes(solicitud.FKstates); // Resuelto o Cerrado
            const mostrarEliminar = USER_ROLE == 4 && !IS_ENVIADAS_VIEW;
            const mostrarEditar = !IS_ENVIADAS_VIEW;

            // Botón Ver (siempre visible)
            actionsHTML += `<a href="/solicitud/view/${solicitud.id}" class="card-action-btn btn-view"><i class="fas fa-eye"></i> Ver</a>`;

            // Botón Editar
            if (mostrarEditar) {
                actionsHTML += `<a href="/solicitud/edit/${solicitud.id}" class="card-action-btn btn-edit"><i class="fas fa-edit"></i> Editar</a>`;
            }

            // Botón Eliminar
            if (mostrarEliminar) {
                actionsHTML += `<a href="/solicitud/delete/${solicitud.id}" class="card-action-btn btn-delete eliminar" data-id="${solicitud.id}" data-client-name="${solicitud.NameClient}"><i class="fas fa-trash-alt"></i> Eliminar</a>`;
            }

            // Botones Archivar / Desarchivar
            if (IS_ARCHIVADAS_VIEW) {
                actionsHTML += `<a href="#" class="card-action-btn btn-unarchive desarchivar" data-id="${solicitud.id}"><i class="fas fa-box-open"></i> Desarchivar</a>`;
            } else if (mostrarArchivar) {
                actionsHTML += `<a href="#" class="card-action-btn btn-archive archivar" data-id="${solicitud.id}" data-client-name="${solicitud.NameClient}"><i class="fas fa-archive"></i> Archivar</a>`;
            }
            
            card.innerHTML = `
                <div class="card-header">
                    <h3>${solicitud.NameClient}</h3>
                    <span><i class="far fa-calendar-alt"></i> ${fecha}</span>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Estado:</strong> 
                        <span class="service-badge" style="background-color:${bgColorEstado}; color:${textColorEstado}; border-color:${textColorEstado};">
                            ${solicitud.State}
                        </span>
                    </p>
                    <p>
                        <strong>Servicio:</strong> 
                        <span class="service-badge" style="background-color:${bgColorServicio}; color:${textColorServicio}; border-color:${textColorServicio};">
                            ${solicitud.service}
                        </span>
                    </p>
                </div>
                <div class="card-actions">${actionsHTML}</div>`;
            return card;
        };

        // Poblar columnas y selectores
        const uniqueStates = {};
        const uniqueServices = {};

        allSolicitudes.forEach((solicitud, index) => {
            const card = createCard(solicitud);
            if (index % 2 === 0) {
                columnAContainer.appendChild(card);
            } else {
                columnBContainer.appendChild(card);
            }
            allCards.push(card);

            if (!uniqueStates[solicitud.FKstates]) uniqueStates[solicitud.FKstates] = solicitud.State;
            if (!uniqueServices[solicitud.FKservices]) uniqueServices[solicitud.FKservices] = solicitud.service;
        });

        for (const id in uniqueStates) {
            filterState.add(new Option(uniqueStates[id], id));
        }
        for (const id in uniqueServices) {
            filterService.add(new Option(uniqueServices[id], id));
        }

        // Lógica de filtros
        const applyFilters = () => {
            const clientFilter = filterClient.value.toLowerCase();
            const stateFilter = filterState.value;
            const serviceFilter = filterService.value;
            let visibleCards = 0;

            allCards.forEach(card => {
                const matchClient = !clientFilter || card.dataset.client.includes(clientFilter);
                const matchState = !stateFilter || card.dataset.stateId === stateFilter;
                const matchService = !serviceFilter || card.dataset.serviceId === serviceFilter;

                const shouldShow = !filtersEnabled || (matchClient && matchState && matchService);
                
                card.classList.toggle('hidden', !shouldShow);
                if (shouldShow) visibleCards++;
            });
            noResultsMessage.style.display = (filtersEnabled && visibleCards === 0) ? 'block' : 'none';
        };

        toggleBtn.addEventListener('click', () => {
            filtersEnabled = !filtersEnabled;
            [filterClient, filterState, filterService].forEach(el => el.disabled = !filtersEnabled);
            
            if (filtersEnabled) {
                toggleBtn.innerHTML = '<i class="fas fa-filter-circle-xmark"></i> Deshabilitar';
            } else {
                toggleBtn.innerHTML = '<i class="fas fa-filter"></i> Habilitar Filtros';
                filterClient.value = '';
                filterState.value = '';
                filterService.value = '';
            }
            applyFilters();
        });

        filterClient.addEventListener('input', applyFilters);
        filterState.addEventListener('change', applyFilters);
        filterService.addEventListener('change', applyFilters);
    });
    </script>

    <script>
        // Aplicar modo oscuro si está guardado en localStorage
        if (localStorage.getItem('darkMode')) {
            document.body.classList.add('dark-mode');
        }

        // Escuchar cambios en tiempo real
        window.addEventListener('storage', (e) => {
            if (e.key === 'darkMode') {
                document.body.classList.toggle('dark-mode', e.newValue === '1');
            }
        });
    </script>
</body>
</html>