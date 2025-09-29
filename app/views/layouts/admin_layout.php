<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/styles_admin_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hamburger-bar {
            fill: #262626;
            transition: fill 0.3s ease;
        }

        body.dark-mode .hamburger-bar {
            fill: #b0b0b0;
        }

        /* Estilos del modal */
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
            z-index: 1000;
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
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="hamburger" title="Menú">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <rect y="7" width="32" height="3" rx="1.5" class="hamburger-bar" />
                    <rect y="14.5" width="32" height="3" rx="1.5" class="hamburger-bar" />
                    <rect y="22" width="32" height="3" rx="1.5" class="hamburger-bar" />
                </svg>
            </button>
        </div>
        <div class="titleSisrel">Relacionamiento Corporativo</div>
        <div class="header-actions">
            <button id="toggle-dark-mode" title="Modo oscuro" class="header-action-btn">
                <i id="dark-mode-icon" class="fa-solid fa-moon" style="color:#262626;"></i>
            </button>
            <button id="logout-btn" title="Cerrar sesión" class="header-action-btn">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #696969;"></i>
            </button>
        </div>
    </header>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="<?php
                    switch ($_SESSION['rol']) {
                        case 1:
                            echo '/usuario/indexAdministrador';
                            break;
                        case 2:
                            echo '/usuario/indexAdministrativo';
                            break;
                        case 3:
                            echo '/usuario/indexBienvenida';
                            break;
                        default:
                            echo '/usuario/indexBienvenida';
                    }
                    ?>" class="sidebar-item <?php if ($titulo == "Home" || $titulo == "Home Admin") {
                                                echo "selected";
                                            } ?>">
            <i data-lucide="home"></i>
            <span class="sidebar-text">Home</span>
        </a>
        <a href="<?php
                    switch ($_SESSION['rol']) {
                        case 1:
                            echo '/solicitud/view';
                            break;
                        case 2:
                            echo '/solicitud/solicitudEstadisticas';
                            break;
                        case 3:
                            echo '/solicitud/view';
                            break;
                        default:
                            echo '/solicitud/view';
                    }
                    ?>" class="sidebar-item <?php if ($titulo == "solicitudes" || $titulo == "Solicitudes Estadisticas") {
                                                echo "selected";
                                            } ?>">
            <i data-lucide="message-square"></i>
            <span class="sidebar-text">Solicitudes</span>
        </a>
        <a href="/solicitud/new" class="sidebar-item <?php if ($titulo == "Nueva solicitud") {
                                                        echo "selected";
                                                    } ?>">
            <i data-lucide="file-edit"></i>
            <span class="sidebar-text">Formulario</span>
        </a>
        <a href="/usuario/perfil" class="sidebar-item <?php if ($titulo == "Perfil Usuario") {
                                                            echo "selected";
                                                        } ?>">
            <i data-lucide="user-round"></i>
            <span class="sidebar-text">Usuario</span>
        </a>
    </div>

    <!-- Modal de confirmación para cerrar sesión -->
    <div id="logout-modal" class="logout-modal-overlay">
        <div class="logout-modal-content">
            <div class="logout-modal-icon">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <h3 class="logout-modal-title">¿Cerrar sesión?</h3>
            <p class="logout-modal-message">
                ¿Estás seguro de que deseas cerrar tu sesión? Tendrás que iniciar sesión nuevamente para acceder al sistema.
            </p>
            <div class="logout-modal-buttons">
                <button id="cancel-logout" class="logout-modal-btn logout-modal-btn-cancel">Cancelar</button>
                <button id="confirm-logout" class="logout-modal-btn logout-modal-btn-confirm">Salir</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <section class="Container">
            <div class="content">
                <?php include_once $content; ?>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div style="margin-top: 10px;">
            <i class="fab fa-instagram" style="color: #B0B0B0; margin: 0 10px;"></i>
            <i class="fab fa-facebook" style="color: #B0B0B0; margin: 0 10px;"></i>
            <i class="fab fa-x-twitter" style="color: #B0B0B0; margin: 0 10px;"></i>
            <i class="fab fa-youtube" style="color: #B0B0B0; margin: 0 10px;"></i>
            <i class="fab fa-linkedin" style="color: #B0B0B0; margin: 0 10px;"></i>
        </div>
        <p style="color:#39a900; font-weight: bold; letter-spacing: 1px;">@SENAComunica</p>
        <p>Sistema de Gestión de Relacionamiento Corporativo SENA©</p>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        // Sidebar toggle
        const btnMenu = document.querySelector('.hamburger');
        const sidebar = document.getElementById('sidebar');
        const body = document.querySelector('body');
        const main = document.querySelector('main');

        btnMenu.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            body.classList.toggle('sidebar-open');

            if (sidebar.classList.contains('open')) {
                main.style.marginLeft = '140px';
            } else {
                main.style.marginLeft = '';
            }
        });

        // Modo oscuro con ícono dinámico
        const darkModeBtn = document.getElementById('toggle-dark-mode');
        const darkModeIcon = document.getElementById('dark-mode-icon');

        function updateDarkModeIcon() {
            if (document.body.classList.contains('dark-mode')) {
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
                darkModeIcon.style.color = '#facc15';
            } else {
                darkModeIcon.classList.remove('fa-sun');
                darkModeIcon.classList.add('fa-moon');
                darkModeIcon.style.color = '#262626';
            }
        }

        darkModeBtn.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', '1');
            } else {
                localStorage.removeItem('darkMode');
            }

            updateDarkModeIcon();
        });

        // Aplicar preferencia de modo oscuro al cargar
        if (localStorage.getItem('darkMode')) {
            document.body.classList.add('dark-mode');
        }
        updateDarkModeIcon();

        // Modal de confirmación para cerrar sesión
        const logoutBtn = document.getElementById('logout-btn');
        const logoutModal = document.getElementById('logout-modal');
        const cancelLogout = document.getElementById('cancel-logout');
        const confirmLogout = document.getElementById('confirm-logout');

        // Mostrar modal al hacer clic en cerrar sesión
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            logoutModal.classList.add('show');
        });

        // Cancelar cierre de sesión
        cancelLogout.addEventListener('click', function() {
            logoutModal.classList.remove('show');
        });

        // Confirmar cierre de sesión
        confirmLogout.addEventListener('click', function() {
            window.location.href = '/login/init';
        });

        // Cerrar modal al hacer clic en el overlay
        logoutModal.addEventListener('click', function(e) {
            if (e.target === logoutModal) {
                logoutModal.classList.remove('show');
            }
        });

        // Cerrar modal con tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && logoutModal.classList.contains('show')) {
                logoutModal.classList.remove('show');
            }
        });
    </script>
    <script src="/js/estadisticas.js"> </script>
    <script src="/js/session-timeout.js"></script>
</body>
</html>