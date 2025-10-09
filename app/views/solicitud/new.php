<?php
// Mover esto al inicio del archivo
$servicioModel = new \App\Models\ServicioModel();
$tipoServicioModel = new \App\Models\TipoServicioModel();
$tipoEventoModel = new \App\Models\TipoEventoModel();
$estadoModel = new \App\Models\EstadoModel();

$servicios = $servicioModel->getAll();
$tiposServicio = $tipoServicioModel->getAll();
$tiposEvento = $tipoEventoModel->getAll();
$estados = $estadoModel->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio Nacional de Aprendizaje - Registro</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        main.content {
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 129px);
            /* altura del header fijo */
            padding-bottom: 60px;
            /* altura del footer fijo */
            box-sizing: border-box;
        }

        .form-container {
            width: 100%;
            max-width: 350px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .logo {
            background-color: #39a900;
            border-radius: 50px;
            width: 100px;
            margin-bottom: 20px;
        }

        .title {
            color: #333;
            margin-bottom: 6px;
            font-size: 15px;
            font-weight: 900;
        }

        h4 {
            font-weight: 100;
            font-size: 17px;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 13px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: black;
        }

        .form-group input:valid,
        .form-group select:valid,
        .form-group textarea:valid {
            background-color: #d4edda;
            /* Color de fondo verde claro */
            border-color: #28a745;
            /* Borde verde */
        }


        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .form-group input:invalid,
        .form-group select:invalid,
        .form-group textarea:invalid {
            background-color: #f8d7da;
            /* Fondo rojo claro */
            border-color: #dc3545;
            /* Borde rojo */
        }

        .form-group select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>') no-repeat right 8px center;
            background-size: 24px;
        }

        .continue-btn,
        .submit-btn {
            background-color: #005a96;
            border-radius: 4px;
            border: none;
            border-radius: 100px;
            color: white;
            cursor: pointer;
            padding: 10px;
            width: 70%;
        }

        .back-btn {
            position: relative;
            /* Cambiado de absolute a relative */
            margin-bottom: 15px;
            /* Añadido margen inferior */
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            text-align: left;
            width: 100%;
        }

        #secondForm {
            display: none;
        }
        
        /* MODO OSCURO PARA FORMULARIO DE NUEVA SOLICITUD */
        /* No cambia el color de fondo del logo */
        body.dark-mode {
            background: #181a1b;
            color: #e0e0e0;
        }

        body.dark-mode .form-container {
            background: #23272a !important;
            color: #e0e0e0;
            border: 1px solid #393e42;
            box-shadow: 0 2px 15px rgba(0,0,0,0.4);
        }

        body.dark-mode .form-group label {
            color: #e0e0e0;
        }

        body.dark-mode .form-group input,
        body.dark-mode .form-group select,
        body.dark-mode .form-group textarea {
            background: #393e42;
            color: #e0e0e0;
            border: 1px solid #393e42;
        }

        body.dark-mode .form-group input:valid,
        body.dark-mode .form-group select:valid,
        body.dark-mode .form-group textarea:valid {
            background-color: #2d3238;
            border-color: #28a745;
        }

        body.dark-mode .form-group input:invalid,
        body.dark-mode .form-group select:invalid,
        body.dark-mode .form-group textarea:invalid {
            background-color: #3a2323;
            border-color: #dc3545;
        }

        body.dark-mode .continue-btn,
        body.dark-mode .submit-btn {
            background-color: #09669C;
            color: #fff;
        }

        body.dark-mode .back-btn {
            color: #e0e0e0;
        }

        /* No modificar el fondo del logo en modo oscuro */
        body.dark-mode .logo {
            background-color: #39a900 !important;
        }
    </style>
</head>

<body>
    <main class="content">
        <div id="firstForm" class="form-container">
            <img src="/img/logoSenaNegro.png" alt="SENA" class="logo">
            <h2 class="title">Bienvenid@ al Servicio Nacional de Aprendizaje</h2>
            <h4>Usted está a punto de realizar una solicitud de servicio</h4>
            <p>Datos de quien solicita la necesidad</p>

            <form onsubmit="showSecondForm(event)">


                <div class="form-group">
                    <label for="document-number">Número de Documento *</label>
                    <input type="text" id="document-number" required>
                </div>
                <div class="form-group">
                    <label for="full-name">Nombre Completo *</label>
                    <input type="text" id="full-name" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico *</label>
                    <input type="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono *</label>
                    <input type="tel" id="phone" required>
                </div>

                <button type="submit" class="continue-btn">CONTINUAR</button>
            </form>
        </div>

        <div id="secondForm" class="form-container">
            <button id="backBtn" class="back-btn" onclick="showFirstForm()">←</button>
            <form action="/solicitud/create" method="POST">
                <!-- Hidden fields for first form data -->
                <input type="hidden" name="documento" id="hidden-documento">
                <input type="hidden" name="nombre" id="hidden-nombre">
                <input type="hidden" name="correo" id="hidden-correo">
                <input type="hidden" name="telefono" id="hidden-telefono">

                <div class="form-group">
                    <label for="request-date">Fecha del Evento *</label>
                    <input type="date" id="request-date" name="fecha_evento" required>
                </div>

                <div class="form-group">
                    <label for="municipality">Municipio *</label>
                    <select id="municipality" name="municipio" required>
                        <option value="">Cargando municipios...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="place">Lugar</label>
                    <input type="text" id="place" name="lugar">
                </div>

                <div class="form-group">
                    <label for="service-to-request">Servicio a Solicitar *</label>
                    <select id="service-to-request" name="servicio" required>
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($servicios as $servicio): ?>
                            <option value="<?php echo $servicio->id; ?>">
                                <?php echo htmlspecialchars($servicio->service); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="service-type">Tipo Servicio *</label>
                    <select id="service-type" name="tipo_servicio" required>
                        <option value="">Selecciona una opción</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="need-description">Descripción necesidad *</label>
                    <textarea id="need-description" name="descripcion" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="event-type">Tipo Evento *</label>
                    <select id="event-type" name="tipo_evento" required>
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($tiposEvento as $tipoEvento): ?>
                            <option value="<?php echo $tipoEvento->id; ?>">
                                <?php echo htmlspecialchars($tipoEvento->eventType); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Hidden field for estado (default to Pendiente) -->
                <input type="hidden" name="estado" value="1">

                <button type="submit" class="submit-btn">ENVIAR</button>
            </form>
        </div>
    </main>
    <script src="/js/API-municipios.js"></script>
    <script>
        function showSecondForm(event) {
            event.preventDefault();
            // Transfer data from first form to hidden fields
            document.getElementById('hidden-documento').value = document.getElementById('document-number').value;
            document.getElementById('hidden-nombre').value = document.getElementById('full-name').value;
            document.getElementById('hidden-correo').value = document.getElementById('email').value;
            document.getElementById('hidden-telefono').value = document.getElementById('phone').value;

            document.getElementById('firstForm').style.display = 'none';
            document.getElementById('secondForm').style.display = 'block';
            document.getElementById('backBtn').style.display = 'block';
        }

        function showFirstForm() {
            document.getElementById('firstForm').style.display = 'block';
            document.getElementById('secondForm').style.display = 'none';
            document.getElementById('backBtn').style.display = 'none';
        }

        document.getElementById('service-to-request').addEventListener('change', function() {
            const servicioId = this.value;
            const tipoServicioSelect = document.getElementById('service-type');

            // Limpiar opciones actuales
            tipoServicioSelect.innerHTML = '<option value="">Selecciona una opción</option>';

            if (servicioId) {
                // Filtrar tipos de servicio según el servicio seleccionado
                <?php foreach ($tiposServicio as $tipoServicio): ?>
                    if ('<?php echo $tipoServicio->FKservices; ?>' === servicioId) {
                        const option = new Option('<?php echo htmlspecialchars($tipoServicio->serviceType); ?>',
                            '<?php echo $tipoServicio->id; ?>');
                        tipoServicioSelect.add(option);
                    }
                <?php endforeach; ?>
            }
        });
    </script>
</body>

</html>