// Configuración del timeout de sesión (15 minutos para coincidir con PHP)
const SESSION_TIME = 15 * 60 * 1000;     // 15 minutos en milisegundos
const WARNING_TIME = 2 * 60 * 1000;      // 2 minutos de advertencia

let sessionTimer;
let warningTimer;
let lastActivity = Date.now();

// Crear el modal de sesión expirada
function createSessionModal() {
    const modalHTML = `
        <div id="session-modal" class="session-modal-overlay">
            <div class="session-modal-content">
                <div class="session-modal-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="session-modal-title">Sesión Expirada</h3>
                <p class="session-modal-message">Tu sesión ha expirado por inactividad. Por tu seguridad, debes iniciar sesión nuevamente.</p>
                <div class="session-modal-buttons">
                    <button id="session-login-btn" class="session-modal-btn session-modal-btn-primary">Iniciar Sesión</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}

// Crear el modal de advertencia
function createWarningModal() {
    const warningHTML = `
        <div id="warning-modal" class="session-modal-overlay">
            <div class="session-modal-content">
                <div class="session-modal-icon warning">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                </div>
                <h3 class="session-modal-title">Sesión por Expirar</h3>
                <p class="session-modal-message">Tu sesión expirará en <span id="countdown">2:00</span> minutos por inactividad.</p>
                <div class="session-modal-buttons">
                    <button id="extend-session-btn" class="session-modal-btn session-modal-btn-primary">Continuar Sesión</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', warningHTML);
}

// Mostrar modal de sesión expirada
function showSessionExpiredModal() {
    if (!document.getElementById('session-modal')) {
        createSessionModal();
    }
    const modal = document.getElementById('session-modal');
    modal.classList.add('show');
    
    // Remover listener anterior si existe
    const loginBtn = document.getElementById('session-login-btn');
    const newLoginBtn = loginBtn.cloneNode(true);
    loginBtn.parentNode.replaceChild(newLoginBtn, loginBtn);
    
    newLoginBtn.addEventListener('click', () => {
        window.location.href = '/login/init';
    });
}

// Mostrar advertencia
function showWarningModal() {
    if (!document.getElementById('warning-modal')) {
        createWarningModal();
    }

    const modal = document.getElementById('warning-modal');
    modal.classList.add('show');

    let timeLeft = WARNING_TIME / 1000;
    const countdownElement = document.getElementById('countdown');

    const countdownInterval = setInterval(() => {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = (timeLeft % 60).toString().padStart(2, '0');
        countdownElement.textContent = `${minutes}:${seconds}`;
        timeLeft--;

        if (timeLeft < 0) {
            clearInterval(countdownInterval);
            hideWarningModal();
            showSessionExpiredModal();
        }
    }, 1000);

    // Remover listener anterior si existe
    const extendBtn = document.getElementById('extend-session-btn');
    const newExtendBtn = extendBtn.cloneNode(true);
    extendBtn.parentNode.replaceChild(newExtendBtn, extendBtn);
    
    newExtendBtn.addEventListener('click', () => {
        clearInterval(countdownInterval);
        hideWarningModal();
        resetSessionTimer();
        
        // Llamar al endpoint para mantener la sesión activa
        fetch('/session/keep-alive', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Sesión extendida:', data);
        })
        .catch(err => {
            console.log('Error manteniendo sesión:', err);
        });
    });
}

// Ocultar modal de advertencia
function hideWarningModal() {
    const modal = document.getElementById('warning-modal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            if (modal.parentNode) {
                modal.remove();
            }
        }, 300);
    }
}

// Resetear temporizadores de sesión
function resetSessionTimer() {
    clearTimeout(sessionTimer);
    clearTimeout(warningTimer);
    lastActivity = Date.now();

    // Configurar advertencia 2 minutos antes del timeout
    warningTimer = setTimeout(showWarningModal, SESSION_TIME - WARNING_TIME);
    
    // Configurar timeout de sesión
    sessionTimer = setTimeout(showSessionExpiredModal, SESSION_TIME);
}

// Detectar actividad del usuario
function detectUserActivity() {
    const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
    
    const activityHandler = () => {
        const now = Date.now();
        // Solo resetear si ha pasado más de 1 minuto desde la última actividad
        if (now - lastActivity > 60000) {
            resetSessionTimer();
        }
        lastActivity = now;
    };

    events.forEach(event => {
        document.addEventListener(event, activityHandler, { passive: true });
    });
}

// Verificar el estado de sesión con el servidor
function checkSessionStatus() {
    fetch('/session/status', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (!data.active) {
            clearTimeout(sessionTimer);
            clearTimeout(warningTimer);
            showSessionExpiredModal();
        }
    })
    .catch(err => {
        console.log('Error verificando sesión:', err);
        // En caso de error, asumir que la sesión sigue activa
    });
}

// CSS para modales
const sessionModalCSS = `
<style>
.session-modal-overlay {
    position: fixed;
    top: 0; 
    left: 0;
    width: 100%; 
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    backdrop-filter: blur(4px);
}

.session-modal-overlay.show { 
    display: flex; 
}

.session-modal-content {
    background: white;
    border-radius: 16px;
    padding: 40px;
    max-width: 450px;
    width: 90%;
    text-align: center;
    animation: slideIn 0.3s ease-out;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

body.dark-mode .session-modal-content {
    background: #2d2d2d;
    color: #e0e0e0;
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(-20px) scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}

.session-modal-icon {
    width: 80px; 
    height: 80px;
    margin: 0 auto 25px;
    border-radius: 50%;
    background: #fee2e2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.session-modal-icon.warning { 
    background: #fef3cd; 
}

body.dark-mode .session-modal-icon {
    background: #7f1d1d;
}

body.dark-mode .session-modal-icon.warning {
    background: #654321;
}

.session-modal-icon i {
    font-size: 32px;
    color: #dc2626;
}

.session-modal-icon.warning i {
    color: #f59e0b;
}

.session-modal-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #374151;
}

body.dark-mode .session-modal-title {
    color: #e0e0e0;
}

.session-modal-message {
    font-size: 16px;
    margin-bottom: 30px;
    line-height: 1.6;
    color: #6b7280;
}

body.dark-mode .session-modal-message {
    color: #9ca3af;
}

#countdown {
    font-weight: bold;
    color: #dc2626;
}

body.dark-mode #countdown {
    color: #f87171;
}

.session-modal-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.session-modal-btn {
    padding: 12px 24px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    min-width: 120px;
    transition: all 0.2s ease;
}

.session-modal-btn-primary {
    background: #dc2626;
    color: white;
}

.session-modal-btn-primary:hover {
    background: #b91c1c;
    transform: translateY(-1px);
}
</style>
`;

// Insertar CSS solo si no existe
if (!document.getElementById('session-modal-styles')) {
    const styleElement = document.createElement('div');
    styleElement.id = 'session-modal-styles';
    styleElement.innerHTML = sessionModalCSS;
    document.head.appendChild(styleElement);
}

// Función de inicialización
function initSessionTimeout() {
    detectUserActivity();
    resetSessionTimer();
    
    // Verificar estado de sesión cada 5 minutos
    setInterval(checkSessionStatus, 5 * 60 * 1000);
    
    console.log('Sistema de timeout de sesión inicializado');
    console.log(`Tiempo de sesión: ${SESSION_TIME / 60000} minutos`);
    console.log(`Tiempo de advertencia: ${WARNING_TIME / 60000} minutos`);
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSessionTimeout);
} else {
    initSessionTimeout();
}