<?php
require_once '../app/config/global.php';
require_once '../app/controllers/homeController.php';
require_once '../app/controllers/loginController.php';
require_once '../app/controllers/clienteController.php';
require_once '../app/controllers/usuarioController.php';
require_once '../app/controllers/rolController.php';
require_once '../app/controllers/tipoServicioController.php';
require_once '../app/controllers/servicioController.php';
require_once '../app/controllers/tipoEventoController.php';
require_once '../app/controllers/estadoController.php';
require_once '../app/controllers/solicitudController.php';
require_once __DIR__ . '/../vendor/autoload.php';


$url = $_SERVER['REQUEST_URI']; //lo que se ingresa en URL

$routes = include_once "../app/config/routes.php";

$matchedRoute = null;
foreach($routes as $route => $routeConfig){
    if (preg_match("#^$route$#", $url, $matches)) {
        $matchedRoute = $routeConfig;
        break;
    }
}

if ($matchedRoute) {
    $controllerName = $matchedRoute["controller"];
    $actionName = $matchedRoute["action"];
    if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
        //Obtener los parámetros capturados por la URL
        $parameters = isset($matches) && is_array($matches) ? array_slice($matches, 1) : [];
        $controller = new $controllerName();
        $controller->$actionName(...$parameters);
        exit;
    }
}