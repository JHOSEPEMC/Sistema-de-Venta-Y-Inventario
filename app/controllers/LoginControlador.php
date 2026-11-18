<?php
class LoginControlador {
    public function index() {
        if (isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Dashboard&action=index"); exit; }
        require_once APP_PATH . '/views/login.php';
    }
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscarPorUsername($username);
            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                header("Location: " . BASE_URL . "index.php?controller=Dashboard&action=index"); exit;
            } else {
                $_SESSION['error_login'] = "Credenciales incorrectas.";
                header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit;
            }
        }
    }
    public function salir() { session_destroy(); header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
}