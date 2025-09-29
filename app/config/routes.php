<?php
return [
    "/" => [
        "controller" => 'App\Controllers\Homecontroller',
        "action" => 'index'
    ],
    '/home' => [
        "controller" => 'App\Controllers\Homecontroller',
        "action" => 'index'
    ],
    '/hello' => [
        "controller" => 'App\Controllers\Homecontroller',
        "action" => 'saludar'
    ],



    '/login/init' => [
        "controller" => 'App\Controllers\LoginController',
        "action" => 'initLogin'
    ],
    /*  '/login' => [
        "controller" => 'App\Controllers\LoginController',
        "action" => 'index'
    ], */
    '/login/handleLogin' => [
        "controller" => 'App\Controllers\LoginController',
        "action" => 'handleLogin'
    ],
    '/login/logout' => [
        "controller" => 'App\Controllers\LoginController',
        "action" => 'logout'
    ],

    // Rutas para Cliente
    '/cliente/index' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'index'
    ],
    '/cliente/view' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'view'
    ],
    '/cliente/new' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'newCliente'
    ],

    '/cliente/create' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'createCliente'
    ],
    '/cliente/view/(\d+)' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'viewCliente'
    ],
    '/cliente/edit/(\d+)' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'editCliente'
    ],
    '/cliente/update' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'updateCliente'
    ],
    '/cliente/delete/(\d+)' => [
        "controller" => 'App\Controllers\ClienteController',
        "action" => 'deleteCliente'
    ],

    // Rutas para Usuario
    '/usuario/view' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'view'
    ],
    '/usuario/new' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'newUsuario'
    ],
    '/usuario/create' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'createUsuario'
    ],
    '/usuario/view/(\d+)' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'viewUsuario'
    ],
    '/usuario/edit/(\d+)' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'editUsuario'
    ],
    '/usuario/update' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'updateUsuario'
    ],
    '/usuario/delete/(\d+)' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'deleteUsuario'
    ],

    // Rutas para Rol
    '/rol/view' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'view'
    ],
    '/rol/new' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'newRol'
    ],
    '/rol/create' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'createRol'
    ],
    '/rol/view/(\d+)' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'viewRol'
    ],
    '/rol/edit/(\d+)' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'editRol'
    ],
    '/rol/update' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'updateRol'
    ],
    '/rol/form' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'saveDataFlutter'
    ],
    '/rol/delete/(\d+)' => [
        "controller" => 'App\Controllers\RolController',
        "action" => 'deleteRol'
    ],

    // Rutas para TipoServicio
    '/tipoServicio/view' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'view'
    ],
    '/tipoServicio/new' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'newTipoServicio'
    ],
    '/tipoServicio/create' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'createTipoServicio'
    ],
    '/tipoServicio/view/(\d+)' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'viewTipoServicio'
    ],
    '/tipoServicio/edit/(\d+)' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'editTipoServicio'
    ],
    '/tipoServicio/update' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'updateTipoServicio'
    ],
    '/tipoServicio/delete/(\d+)' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'deleteTipoServicio'
    ],
    '/tipoServicio/getTiposServicioByServicio/(\d+)' => [
        "controller" => 'App\Controllers\TipoServicioController',
        "action" => 'getTiposServicioByServicio'
    ],

    // Rutas para Servicio
    '/servicio/view' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'view'
    ],
    '/servicio/new' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'newServicio'
    ],
    '/servicio/create' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'createServicio'
    ],
    '/servicio/view/(\d+)' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'viewServicio'
    ],
    '/servicio/edit/(\d+)' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'editServicio'
    ],
    '/servicio/update' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'updateServicio'
    ],
    '/servicio/delete/(\d+)' => [
        "controller" => 'App\Controllers\ServicioController',
        "action" => 'deleteServicio'
    ],

    // Rutas para TipoEvento
    '/tipoEvento/view' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'view'
    ],
    '/tipoEvento/new' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'newTipoEvento'
    ],
    '/tipoEvento/create' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'createTipoEvento'
    ],
    '/tipoEvento/view/(\d+)' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'viewTipoEvento'
    ],
    '/tipoEvento/edit/(\d+)' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'editTipoEvento'
    ],
    '/tipoEvento/update' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'updateTipoEvento'
    ],
    '/tipoEvento/delete/(\d+)' => [
        "controller" => 'App\Controllers\TipoEventoController',
        "action" => 'deleteTipoEvento'
    ],
    //Estado
    '/estado/view' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'view'
    ],
    '/estado/new' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'newEstado'
    ],
    '/estado/create' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'createEstado'
    ],
    '/estado/view/(\d+)' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'viewEstado'
    ],
    '/estado/edit/(\d+)' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'editEstado'
    ],
    '/estado/update' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'updateEstado'
    ],
    '/estado/delete/(\d+)' => [
        "controller" => 'App\Controllers\EstadoController',
        "action" => 'deleteEstado'
    ],
    //Solicitud
    '/solicitud/view' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'view'
    ],
    '/solicitud/new' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'newSolicitud'
    ],
    '/solicitud/create' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'createSolicitud'
    ],
    '/solicitud/view/(\d+)' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'viewSolicitud'
    ],
    '/solicitud/edit/(\d+)' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'editSolicitud'
    ],
    '/solicitud/update' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'updateSolicitud'
    ],
    '/solicitud/delete/(\d+)' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'deleteSolicitud'
    ],
    '/solicitud/archivadas' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'archivadas'
    ],
    '/solicitud/archivar/(\d+)' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'archivarSolicitud'
    ],
    '/solicitud/solicitudesPorEstadoAPI' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'solicitudesPorEstadoAPI'
    ],
    '/solicitud/serviciosMasSolicitadosAPI' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'serviciosMasSolicitadosAPI'
    ],
    '/solicitud/solicitudesPorMesAPI' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'solicitudesPorMesAPI'
    ],
    '/solicitud/municipiosMasSolicitudesAPI' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'municipiosMasSolicitudesAPI'
    ],
    '/solicitud/desarchivarSolicitud/(\d+)' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'desarchivarSolicitud'
    ],
    '/solicitud/enviadas' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'enviadas'
    ],

    // Formulario
    /*  '/formulario/new' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'newSolicitud'
    ], */

    // Direcciones de sidebar
    '/usuario/indexBienvenida' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'bienvenida'
    ],
    '/usuario/indexAdministrador' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'HomeAdmin'
    ],
    '/usuario/indexAdministrativo' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'Estadisticas'
    ],

    '/usuario/indexSolicitudes' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'solicitudes'
    ],
    '/usuario/perfil' => [
        "controller" => 'App\Controllers\UsuarioController',
        "action" => 'perfil'
    ],
    '/solicitud/solicitudEstadisticas' => [
        "controller" => 'App\Controllers\SolicitudController',
        "action" => 'SolicitudEstadisticas'
    ],
    /* -------------------- */
    '/session/keep-alive' => [
        'controller' => 'App\Controllers\LoginController',
        'action' => 'keepAlive'
    ],
    '/session/status' => [
        'controller' => 'App\Controllers\LoginController',
        'action' => 'status'
    ],
    


];
