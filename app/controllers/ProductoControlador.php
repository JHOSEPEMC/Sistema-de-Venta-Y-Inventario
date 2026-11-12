<?php
// app/controllers/ProductoControlador.php

class ProductoControlador {
    private $productoDAO;

    public function __construct() {
        // El Autoload ya cargó la clase ProductoDAO
        $this->productoDAO = new ProductoDAO();
    }

    // Muestra la lista de productos
    public function index() {
        // Verificación de seguridad: si no hay sesión, al login
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
            exit;
        }

        $productos = $this->productoDAO->listar();
        require_once APP_PATH . '/views/productos/index.php';
    }

    // Muestra el formulario para crear un producto
    public function crear() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
            exit;
        }
        require_once APP_PATH . '/views/productos/crear.php';
    }

    // Guarda el producto desde el formulario (POST)
    public function guardar() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creamos el objeto Producto con los datos del POST
            $producto = new Producto($_POST);
            
            // Llamamos al DAO para guardar
            if ($this->productoDAO->crear($producto)) {
                $_SESSION['mensaje_exito'] = "Producto registrado correctamente.";
                header("Location: " . BASE_URL . "index.php?controller=Producto&action=index");
                exit;
            } else {
                $_SESSION['error'] = "Error al registrar el producto.";
                header("Location: " . BASE_URL . "index.php?controller=Producto&action=crear");
                exit;
            }
        }
    }
}
?>