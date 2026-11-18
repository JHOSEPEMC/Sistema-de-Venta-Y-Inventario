<?php
class UsuarioControlador {
    private $dao;
    public function __construct() { $this->dao = new UsuarioDAO(); }
    public function index() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        require_once APP_PATH . '/views/usuarios/crear.php';
    }
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre_completo'] ?? '');
            $user = trim($_POST['username'] ?? '');
            $pass = trim($_POST['password'] ?? '');
            $rol = $_POST['rol'] ?? 'VENDEDOR';
            if ($this->dao->crear($nombre, $user, $pass, $rol)) {
                $_SESSION['mensaje_exito'] = "Usuario registrado correctamente.";
            } else {
                $_SESSION['error'] = "Error al registrar (el username ya existe).";
            }
            header("Location: " . BASE_URL . "index.php?controller=Usuario&action=index"); exit;
        }
    }
}