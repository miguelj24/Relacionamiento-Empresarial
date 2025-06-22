<style>
    .data-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-title {
        color: #2c3e50;
        margin-bottom: 2rem;
        font-size: 1.8rem;
        text-align: center;
        font-weight: 600;
    }

    .record-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Cambia el número 2 para modificar columnas */
        gap: 1.5rem;
    }

    .detail-group {
        background-color: #f4f6f8;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .detail-group label {
        display: block;
        font-weight: bold;
        font-size: 0.95rem;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .detail-group span {
        font-weight: normal;
        font-size: 0.95rem;
        color: #333;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .record-details {
            grid-template-columns: 1fr; /* Una sola columna en móviles */
        }

        .form-title {
            font-size: 1.5rem;
        }
    }
</style>
<div class="data-container">
    <h2 class="form-title">Detalles de la Solicitud</h2>
    <?php
    
    //Permisos para mostrar cosas segun el rol
    //Elementos que se le mostraran solo al admin
    //$esAdmin = (isset($_SESSION['rol']) && $_SESSION['rol'] == 1);

    if ($solicitud && is_object($solicitud)) {
    
        echo  "
                <div class='record-details'>
                <div class='detail-group'>
                    <label>ID de la solicitud</label>
                    <span>{$solicitud->idSolicitud}</span>
                </div>
                <div class='detail-group'>
                    <label>Descripción</label>
                    <span>{$solicitud->DescripcionNecesidad}</span>
                </div>
                <div class='detail-group'>
                    <label>Fecha de la solicitud</label>
                    <span>{$solicitud->FechaEvento}</span>
                </div>
                <div class='detail-group'>
                    <label>Fecha de creación</label>
                    <span>{$solicitud->FechaCreacion}</span>
                </div>
                <div class='detail-group'>
                    <label>Cliente</label>
                    <span><a href='/cliente/view/{$solicitud->FKcliente}' style='color:#000;text-decoration:none;cursor:pointer'>{$solicitud->NombreCliente}</a></span>
                </div>
                
                <div class='detail-group'>
                    <label>Servicio</label>
                    <span>{$solicitud->Servicio}</span>
                </div>
                <div class='detail-group'>
                    <label>Tipo de Servicio</label>
                    <span>" . htmlspecialchars($solicitud->TipoServicio) . "</span>
                </div>
                <div class='detail-group'>
                    <label>Estado</label>
                    <span>{$solicitud->Estado} - {$solicitud->EstadoDescripcion}</span>
                </div>
                <div class='detail-group'>
                    <label>Usuario que realizó la solicitud</label>
                    <span><a href='/usuario/view/{$solicitud->FKusuario}' style='color:#000;text-decoration:none;cursor:pointer'>" . htmlspecialchars($solicitud->NombreUsuario) . "</a></span>
                </div>
                
                <div class='detail-group'>
                    <label>Responsable Asignado</label>
                    ";

                    if (!empty($solicitud->Asignacion) && !empty($solicitud->NombreUsuarioAsignado)) {
                        echo "<a href='/usuario/view/{$solicitud->Asignacion}' style='color:#000;text-decoration:none;cursor:pointer'>" . htmlspecialchars($solicitud->NombreUsuarioAsignado) . "</a>";
                    } else {
                        echo "<span>No asignado</span>";
                    }

                echo "
                </div>
                <div class='detail-group'>
                    <label>Lugar</label>
                    <span>" . htmlspecialchars($solicitud->Lugar ?? '') . "</span>
                </div>
                <div class='detail-group'>
                    <label>Municipio</label>
                    <span>" . htmlspecialchars($solicitud->Municipio ?? '') . "</span>
                </div>
                <div class='detail-group'>
                    <label>Comentarios</label>
                    <span>" . htmlspecialchars($solicitud->Comentarios ?? '') . "</span>
                </div>
                <div class='detail-group'>
                    <label>Observaciones</label>
                    <span>" . htmlspecialchars($solicitud->Observaciones ?? '') . "</span>
                </div>
              </div>";
    }
    ?>
</div>


