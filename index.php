<?php
    // 1. Cargamos la clase Config
    require_once __DIR__ . '/app/config/Config.php';
    // (Opcional) Si usas Composer, descomenta la siguiente línea
    // require_once __DIR__ . '/vendor/autoload.php';

    // 2. Inicializamos (Esto define BASE_URL, APP_PATH, MONEDA, etc.)
    Config::init(); 

    // 3. Autocarga de clases (MVC + DAO + PDO)
    spl_autoload_register(function ($clase) {
        $rutas = [
            APP_PATH . '/config/',
            APP_PATH . '/dao/',
            APP_PATH . '/models/',
            APP_PATH . '/controllers/',
            APP_PATH . '/services/' // Por si luego agregan lógica extra (ej. Reportes)
        ];
        
        foreach ($rutas as $ruta) {
            if (file_exists($ruta . $clase . '.php')) {
                require_once $ruta . $clase . '.php';
                return;
            }
        }
    });

    // 4. Enrutador simple (Front Controller)
    // Por defecto, si no se pasa nada, va al Login (o a Home)
    $controller = isset($_GET['controller']) ? $_GET['controller'] : 'Login';
    $action     = isset($_GET['action'])     ? $_GET['action']     : 'index';

    // Convertimos "producto" a "ProductoControlador"
    $clase      = ucfirst($controller) . 'Controlador';

    if (!class_exists($clase)) {
        echo "<h1>404 - Controlador no encontrado: $clase</h1>";
        exit;
    }

    $obj = new $clase();
    if (!method_exists($obj, $action)) {
        echo "<h1>404 - Acción no encontrada: $action</h1>";
        exit;
    }
$obj->$action();