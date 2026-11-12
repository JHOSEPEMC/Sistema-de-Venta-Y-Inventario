<?php
class Config {
    public static function init() {
        // Rutas dinámicas
        $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host      = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $carpeta   = 'Anderson/sistema-ventas'; // CAMBIA ESTO por el nombre de tu carpeta en htdocs
        
        // BASE_URL para los enlaces (CSS, JS, redirecciones)
        define('BASE_URL', $protocolo . '://' . $host . '/' . $carpeta . '/');
        define('BASE_PATH', dirname(__DIR__, 2));
        define('APP_PATH',  BASE_PATH . '/app');
        define('VENDOR_PATH', BASE_PATH . '/vendor');
        define('ASSETS_PATH', BASE_PATH . '/assets');
        define('ASSETS_URL', BASE_URL . 'assets/');

        // Datos del negocio (puedes cambiarlos)
        define('NOMBRE_NEGOCIO', 'SISTEMA DE VENTAS E INVENTARIO');
        define('MONEDA', 'S/');
        
        date_default_timezone_set('America/Lima');

        // Manejo de errores (Desarrollo)
        define('DEBUG', true);
        if (DEBUG) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
            error_reporting(0);
        }

        // Configuración de la sesión segura
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => false, // Cambiar a true en producción con HTTPS
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    // Configuración de Base de Datos (PDO)
    public static function db() {
        return [
            // 'driver' => 'pgsql', // PostgreSQL (Si decides usar el que mencionaste antes)
            'driver'   => 'mysql',  // MySQL (XAMPP) - Según tus documentos
            'host'     => 'localhost',
            'port'     => '3306', // Puerto por defecto de MySQL en XAMPP
            'database' => 'sistema_ventas_inventario',
            'username' => 'root', // Usuario por defecto de XAMPP
            'password' => '',     // Contraseña por defecto de XAMPP (vacía)
            'charset'  => 'utf8mb4',
        ];
    }
}