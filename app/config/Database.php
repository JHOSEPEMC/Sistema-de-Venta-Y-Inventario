<?php
// app/config/Database.php

class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            $config = Config::db();
            $driver = $config['driver'];
            
            try {
                // DSN dependiendo del motor (MySQL o PostgreSQL)
                if ($driver === 'pgsql') {
                    $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']};";
                } else {
                    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
                }

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$conn = new PDO($dsn, $config['username'], $config['password'], $options);
                
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}