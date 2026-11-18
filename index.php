<?php
require_once __DIR__ . '/app/config/Config.php';
require_once __DIR__ . '/vendor/autoload.php';
Config::init();

spl_autoload_register(function ($clase) {
    $rutas = [APP_PATH . '/config/', APP_PATH . '/dao/', APP_PATH . '/models/', APP_PATH . '/controllers/', APP_PATH . '/services/'];
    foreach ($rutas as $ruta) {
        if (file_exists($ruta . $clase . '.php')) { require_once $ruta . $clase . '.php'; return; }
    }
});

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Login';
$action     = isset($_GET['action'])     ? $_GET['action']     : 'index';
$clase      = ucfirst($controller) . 'Controlador';

if (!class_exists($clase)) { die("<h1>404 - Controlador no encontrado: $clase</h1>"); }
$obj = new $clase();
if (!method_exists($obj, $action)) { die("<h1>404 - Acción no encontrada: $action</h1>"); }
$obj->$action();