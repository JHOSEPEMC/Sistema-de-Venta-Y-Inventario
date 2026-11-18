<?php
class VentaControlador {
    private $ventaDAO, $productoDAO;
    public function __construct() {
        $this->ventaDAO = new VentaDAO();
        $this->productoDAO = new ProductoDAO();
    }
    public function index() {
        $ventas = $this->ventaDAO->listar();
        require_once APP_PATH . '/views/ventas/index.php';
    }
    public function crear() {
        $productos = $this->productoDAO->listar();
        // Obtener clientes para el select
        $db = Database::getConnection();
        $clientes = $db->query("SELECT * FROM clientes WHERE estado = 'ACTIVO'")->fetchAll();
        require_once APP_PATH . '/views/ventas/crear.php';
    }
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cliente = $_POST['id_cliente'];
            $tipo_pago = $_POST['tipo_pago'];
            $id_usuario = $_SESSION['usuario_id'];
            
            // Formatear items (vienen en arrays del formulario)
            $items = [];
            if (isset($_POST['id_producto']) && is_array($_POST['id_producto'])) {
                for ($i = 0; $i < count($_POST['id_producto']); $i++) {
                    if (!empty($_POST['cantidad'][$i])) {
                        $items[] = ['id_producto' => $_POST['id_producto'][$i], 'cantidad' => $_POST['cantidad'][$i]];
                    }
                }
            }

            if ($this->ventaDAO->registrarVenta($id_cliente, $id_usuario, $tipo_pago, $items)) {
                $_SESSION['mensaje_exito'] = "Venta registrada con éxito.";
                header("Location: " . BASE_URL . "index.php?controller=Venta&action=index"); exit;
            } else {
                $_SESSION['error'] = "Error al procesar venta (verifique stock o crédito).";
                header("Location: " . BASE_URL . "index.php?controller=Venta&action=crear"); exit;
            }
        }
    }
}