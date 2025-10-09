<style>
    .data-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-title {
        text-align: center;
        color: #0b5fa4;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        background-color: #f1f1f1; /* Tarjetas grises claras */
        padding: 1rem;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem 1rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 1rem;
        box-sizing: border-box;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #0b6e99;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .btn-submit {
        background-color: #003b5c;
        color: white;
        padding: 0.7rem 1.5rem;
        font-size: 1rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 2rem;
       
    }
        /* Botón guardar */
    .button-group {
    display: flex;
    justify-content: center;
    justify-self: center; 
    grid-column: span 2;  
    }
   

    .btn-submit:hover {
    background-color: #00547d;
    }

   

    @media (max-width: 768px) {
        form {
            grid-template-columns: 1fr;
        }

        .btn-submit {
            grid-column: span 1;
        }

        .form-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="data-container ">
    <?php
    //Permisos para mostrar cosas segun el rol
    //Elementos que se le mostraran solo al admin
    $esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] == 1);
    ?>
    <h2 class="form-title">Editar Solicitud</h2>
    <form action="/solicitud/update" method="post">
        
        <div class="form-group">
            <label for="idSolicitud">ID de la solicitud</label>
            <input readonly value="<?php echo $solicitud->id ?>" type="number" id="idSolicitud" name="idSolicitud" class="form-control">
        </div>
     
        
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" value="<?php echo $solicitud->needDescription ?>" id="descripcion" name="Descripcion" class="form-control" maxlength="255">
        </div>
        <div class="form-group">
            <label for="fecha">Fecha de la solicitud</label>
            <input value="<?php echo $solicitud->eventDate ?>" type="date" id="fecha" name="FechaSolicitud" class="form-control">
        </div>
        <div class="form-group">
            <label for="cliente">Cliente</label>
            <input type="text" value="<?php echo $solicitud->NameClient; ?>" id="cliente" name="NombreCliente" class="form-control" maxlength="255">
        </div>
        <div class="form-group">
            <label for="servicio">Servicio</label>
            <select id="servicio" name="IdServicio" class="form-control">
                <option value="">Seleccione un servicio</option>
                <?php foreach ($servicios as $servicio): ?>
                    <option value="<?php echo $servicio->id; ?>" 
                        <?php echo ($solicitud->Fkservice == $servicio->id) ? 'selected' : ''; ?>>
                        <?php echo $servicio->service; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tipoServicio">Tipo de Servicio</label>
            <select id="tipoServicio" name="IdTipoServicio" class="form-control" data-selected="<?php echo $solicitud->FKservicetypes; ?>">
                <option value="">Seleccione un tipo de servicio</option>
                <?php foreach ($tiposServicio as $tipoServicio): ?>
                    <option value="<?php echo $tipoServicio->id; ?>" 
                        <?php echo ($solicitud->FKservicetypes == $tipoServicio->id) ? 'selected' : ''; ?>>
                        <?php echo $tipoServicio->serviceType; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <?php
            // Mapeo de estados permitidos según el estado actual
            $estadoActual = $solicitud->FKstates;
            $estadosPermitidos = [];

            switch ($estadoActual) {
                case 1: // Pendiente
                    $estadosPermitidos = [3]; // Asignado
                    break;
                case 3: // Asignado
                    $estadosPermitidos = [4]; // En proceso
                    break;
                case 4: // En proceso
                    $estadosPermitidos = [5]; // Ejecutado
                    break;
                case 5: // Ejecutado
                    $estadosPermitidos = [6, 7]; // Resuelto y Cerrado
                    break;
                case 6: // Resuelto
                case 7: // Cerrado
                    break;
                default:
                    $estadosPermitidos = [$estadoActual]; // Solo el actual, por seguridad
            }
            ?>
            <select id="estado" name="IdEstado" class="form-control" required>
                <option value="">Seleccione un estado</option>
                <?php foreach ($estados as $estado): ?>
                    <?php
                    // Mostrar si es permitido avanzar o si es el estado actual
                    $mostrar = in_array($estado->id, $estadosPermitidos) || $solicitud->FKstates== $estado->id;
                    ?>
                    <?php if ($mostrar): ?>
                        <option value="<?php echo $estado->id; ?>" <?php echo ($solicitud->FKstates == $estado->id) ? 'selected' : ''; ?>>
                            <?php echo $estado->State; ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Solo el admin ve Asignar solicitud -->
        <?php if ($esAdmin): ?>
        <div class="form-group">
            <label for="asignacion">Asignar solicitud</label>
            <?php
            $roles = [
                5 => 'Instructor',
                6 => 'Funcionario'
                
            ];
            ?>
            <select id="asignacion" name="Asignacion" class="form-control">
                <option value="">Seleccione un usuario</option>
                <?php foreach ($usuariosAsignables as $usuario): ?>
                    <option value="<?php echo $usuario->id; ?>"
                        <?php echo ($solicitud->assignment == $usuario->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($usuario->nameUser); ?> (<?php echo $roles[$usuario->FKroles]; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="lugar">Lugar</label>
            <input type="text" value="<?php echo htmlspecialchars($solicitud->location ?? ''); ?>" id="lugar" name="Lugar" class="form-control">
        </div>
        <div class="form-group">
            <label for="municipio">Municipio</label>
            <input type="text" value="<?php echo htmlspecialchars($solicitud->municipality ?? ''); ?>" id="municipio" name="Municipio" class="form-control">
        </div>
        <div class="form-group">
            <label for="comentarios">Comentarios</label>
            <textarea id="comentarios" name="Comentarios" class="form-control"><?php echo htmlspecialchars($solicitud->comments ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" name="Observaciones" class="form-control"><?php echo htmlspecialchars($solicitud->observations ?? ''); ?></textarea>
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn-submit">Guardar Cambios</button>
        </div>
    </form>
</div>

<!-- Modal de confirmación para actualizar -->
<div id="update-modal-overlay" class="delete-modal-overlay">
    <div class="delete-modal-content">
        <div class="delete-modal-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="delete-modal-title">¿Actualizar solicitud?</div>
        <div class="delete-modal-message">
            ¿Estás seguro de que deseas guardar los cambios realizados en esta solicitud?
        </div>
        <div class="delete-modal-buttons">
            <button type="button" class="delete-modal-btn delete-modal-btn-cancel" id="cancel-update-btn">Cancelar</button>
            <button type="button" class="delete-modal-btn delete-modal-btn-confirm" id="confirm-update-btn">Actualizar</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const servicioSelect = document.getElementById('servicio');
    const tipoServicioSelect = document.getElementById('tipoServicio');

    servicioSelect.addEventListener('change', async () => {
        const servicioId = servicioSelect.value;
        tipoServicioSelect.innerHTML = '<option value="">Seleccione un tipo de servicio</option>';
        if (servicioId) {
            try {
                const response = await fetch(`/tipoServicio/getTiposServicioByServicio/${servicioId}`);
                const tiposServicio = await response.json();
                const selectedTipoServicio = tipoServicioSelect.getAttribute('data-selected');
                tiposServicio.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.id;
                    option.textContent = tipo.serviceType;
                    if (selectedTipoServicio && selectedTipoServicio == tipo.id) {
                        option.selected = true;
                    }
                    tipoServicioSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error al cargar los tipos de servicio:', error);
            }
        }
    });

    // Modal de confirmación para actualizar
    const form = document.querySelector('form[action="/solicitud/update"]');
    const updateModal = document.getElementById('update-modal-overlay');
    const cancelBtn = document.getElementById('cancel-update-btn');
    const confirmBtn = document.getElementById('confirm-update-btn');
    const submitBtn = document.querySelector('.btn-submit');

    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        updateModal.classList.add('show');
    });

    cancelBtn.addEventListener('click', function() {
        updateModal.classList.remove('show');
    });

    confirmBtn.addEventListener('click', function() {
        updateModal.classList.remove('show');
        form.submit();
    });
});
</script>

<style>
/* Modal de confirmación (reutiliza estilos del modal de eliminar) */
.delete-modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: none; justify-content: center; align-items: center;
    z-index: 10001;
    backdrop-filter: blur(4px);
    animation: fadeIn 0.3s ease;
}
.delete-modal-overlay.show { display: flex; }
.delete-modal-content {
    background: white;
    border-radius: 12px;
    padding: 30px;
    max-width: 420px;
    width: 90%;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    text-align: center;
    transform: scale(0.9);
    transition: transform 0.3s ease;
    position: relative;
}
.delete-modal-overlay.show .delete-modal-content { transform: scale(1); }
.delete-modal-icon {
    width: 70px; height: 70px; margin: 0 auto 20px; border-radius: 50%;
    background: #fee2e2; display: flex; align-items: center; justify-content: center;
    animation: pulse 2s infinite;
}
.delete-modal-icon i { font-size: 28px; color: #dc2626; }
.delete-modal-title {
    font-size: 22px; font-weight: 600; margin-bottom: 12px; color: #374151;
}
.delete-modal-message {
    font-size: 16px; color: #6b7280; margin-bottom: 25px; line-height: 1.6;
}
.delete-modal-buttons {
    display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;
}
.delete-modal-btn {
    padding: 12px 24px; border: none; border-radius: 8px; font-size: 15px;
    font-weight: 500; cursor: pointer; transition: all 0.2s ease; min-width: 100px;
    position: relative; overflow: hidden;
}
.delete-modal-btn-cancel {
    background: #f3f4f6; color: #374151; border: 2px solid #e5e7eb;
}
.delete-modal-btn-cancel:hover {
    background: #e5e7eb; border-color: #d1d5db;
}
.delete-modal-btn-confirm {
    background: linear-gradient(135deg, #0b5fa4, #003b5c);
    color: white; border: 2px solid transparent;
    box-shadow: 0 4px 14px 0 rgba(11, 95, 164, 0.25);
}
.delete-modal-btn-confirm:hover {
    background: linear-gradient(135deg, #003b5c, #0b5fa4);
    box-shadow: 0 6px 20px rgba(11, 95, 164, 0.3);
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
</style>




