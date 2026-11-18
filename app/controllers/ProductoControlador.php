<?php
class ProductoControlador {
    private $dao;
    public function __construct() { $this->dao = new ProductoDAO(); }
    public function index() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        $productos = $this->dao->listar();
        require_once APP_PATH . '/views/productos/index.php';
    }
    public function crear() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        require_once APP_PATH . '/views/productos/crear.php';
    }
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $p = new Producto($_POST);
            if ($this->dao->crear($p)) {
                $_SESSION['mensaje_exito'] = "Producto registrado.";
                header("Location: " . BASE_URL . "index.php?controller=Producto&action=index"); exit;
            } else {
                $_SESSION['error'] = "Error al registrar producto.";
                header("Location: " . BASE_URL . "index.php?controller=Producto&action=crear"); exit;
            }
        }
    }
}