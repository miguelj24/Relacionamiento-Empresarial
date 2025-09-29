<?php

namespace App\Controllers;

session_start();

use ValueError;

class BaseController
{
    public $layout = "default";

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Tiempo máximo de inactividad (15 minutos)
        $max_inactive = 15 * 60;

        // Inicializa el timestamp si no está seteado
        if (!isset($_SESSION['timeOut'])) {
            $_SESSION['timeOut'] = time();
        }

        // Validar inactividad
        if (time() - $_SESSION['timeOut'] > $max_inactive) {
            session_unset();
            session_destroy();
            header("Location: /login/init?timeout=1");
            exit();
        } else {
            $_SESSION['timeOut'] = time();
        }
    }

    public function render(string $view, array $arrayData = null)
    {
        if (isset($arrayData) && is_array($arrayData)) {
            foreach ($arrayData as $key => $value) {
                $$key = $value;
            }
        }
        $content = MAIN_APP_ROUTE . "../views/$view";
        $layout = MAIN_APP_ROUTE . "../views/layouts/{$this->layout}.php";
        include_once $layout;
    }

    protected function renderPartial($view, $data = [])
    {
        extract($data);
        require MAIN_APP_ROUTE . "../views/" . $view;
    }

    public function formatNumber($number)
    {
        // Formatear número con separador de miles y decimales
        return number_format($number, 2, ',', '.');
    }

    public function redirectTo($view)
    {
        header("Location: /$view");
        exit();
    }

    protected function dbConnect()
    {
        try {
            $dsn = "mysql:host=localhost;dbname=relacionamientoempresarial;charset=utf8mb4";
            $username = "root";
            $password = "";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            ];
            return new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    protected function verificarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
    }
}
