<?php
// app/controllers/LoginControlador.php

class LoginControlador {
    
    // Muestra el formulario de login
    public function index() {
        // Si ya está logueado, lo redirigimos al dashboard o a productos
        if (isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=Producto&action=index");
            exit;
        }
        require_once APP_PATH . '/views/login.php';
    }

    // Procesa el formulario de login
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $_SESSION['error_login'] = "Por favor, complete todos los campos.";
                header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
                exit;
            }

            // Instanciamos el DAO de Usuarios (debes crearlo, aquí te doy la lógica)
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscarPorUsername($username);

            // Verificamos si el usuario existe y la contraseña es correcta
            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                // Credenciales correctas: guardamos en sesión
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                // Redirigir al módulo principal (Productos)
                header("Location: " . BASE_URL . "index.php?controller=Producto&action=index");
                exit;
            } else {
                $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
                header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
                exit;
            }
        }
    }

    // Cierra la sesión
    public function salir() {
        session_destroy();
        header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
        exit;
    }
}
?>