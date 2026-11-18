<?php
class Config {
    public static function init() {
        $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host      = $_SERVER['HTTP_HOST'] ?? 'localhost';
        // ⚠️ CAMBIA ESTO por el nombre de tu carpeta en htdocs
        $carpeta   = 'Anderson/sistema-ventas'; 
        
        define('BASE_URL', $protocolo . '://' . $host . '/' . $carpeta . '/');
        define('BASE_PATH', dirname(__DIR__, 2));
        define('APP_PATH',  BASE_PATH . '/app');
        define('ASSETS_URL', BASE_URL . 'assets/');
        define('NOMBRE_NEGOCIO', 'SISTEMA DE VENTAS E INVENTARIO');
        define('MONEDA', 'S/');
        
        date_default_timezone_set('America/Lima');
        define('DEBUG', true);
        if (DEBUG) { ini_set('display_errors', 1); error_reporting(E_ALL); }
        else { ini_set('display_errors', 0); error_reporting(0); }

        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
            session_start();
        }
    }

    public static function db() {
        return [
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'port'     => '3306',
            'database' => 'sistema_ventas_inventario',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8mb4',
        ];
    }
}