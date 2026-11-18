<?php
class ClienteControlador {
    private $dao;
    
    public function __construct() { 
        $this->dao = new ClienteDAO(); 
    }
    
    public function index() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        $clientes = $this->dao->listar();
        require_once APP_PATH . '/views/clientes/index.php';
    }
    
    public function crear() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        require_once APP_PATH . '/views/clientes/crear.php';
    }
    
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ruc = trim($_POST['ruc_dni'] ?? '');
            $razon = trim($_POST['razon_social'] ?? '');
            $tipo = $_POST['tipo_cliente'] ?? 'MAYORISTA';
            $limite = $_POST['limite_credito'] ?? 0.00;
            
            if ($this->dao->crear($ruc, $razon, $tipo, $limite)) {
                $_SESSION['mensaje_exito'] = "Cliente registrado correctamente.";
                header("Location: " . BASE_URL . "index.php?controller=Cliente&action=index"); exit;
            } else {
                $_SESSION['error'] = "Error al registrar el cliente.";
                header("Location: " . BASE_URL . "index.php?controller=Cliente&action=crear"); exit;
            }
        }
    }
    
    // NUEVO: Ver detalle del cliente, saldo e historial
    public function ver() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        $id = $_GET['id'] ?? null;
        if (!$id) { header("Location: " . BASE_URL . "index.php?controller=Cliente&action=index"); exit; }
        
        $cliente = $this->dao->obtenerPorId($id);
        $historial = $this->dao->obtenerHistorial($id); // Últimos 10 pedidos
        
        require_once APP_PATH . '/views/clientes/ver.php';
    }
    
    public function abonar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cliente = $_POST['id_cliente'];
            $this->dao->registrarAbono($id_cliente, $_POST['monto']);
            $_SESSION['mensaje_exito'] = "Abono registrado correctamente.";
            header("Location: " . BASE_URL . "index.php?controller=Cliente&action=ver&id=" . $id_cliente); exit;
        }
    }
}