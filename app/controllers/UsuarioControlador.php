<?php
// app/controllers/UsuarioControlador.php

class UsuarioControlador {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    // Muestra el formulario
    public function index() {
        // (Opcional) Verificar que solo el ADMIN pueda entrar aquí
        require_once APP_PATH . '/views/usuarios/crear.php';
    }

    // Procesa el formulario
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_completo = trim($_POST['nombre_completo'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $rol = $_POST['rol'] ?? 'VENDEDOR';

            // Validación básica
            if (empty($nombre_completo) || empty($username) || empty($password)) {
                $_SESSION['error'] = "Todos los campos son obligatorios.";
                header("Location: " . BASE_URL . "index.php?controller=Usuario&action=index");
                exit;
            }

            // Insertar en la BD (El DAO se encarga del hash, estado y fecha)
            if ($this->usuarioDAO->crear($nombre_completo, $username, $password, $rol)) {
                $_SESSION['mensaje_exito'] = "Usuario registrado correctamente.";
                header("Location: " . BASE_URL . "index.php?controller=Usuario&action=index");
                exit;
            } else {
                $_SESSION['error'] = "Error al registrar el usuario (quizás el username ya existe).";
                header("Location: " . BASE_URL . "index.php?controller=Usuario&action=index");
                exit;
            }
        }
    }
}
?>