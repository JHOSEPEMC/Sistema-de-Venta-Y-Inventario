<?php
class DashboardControlador {
    public function index() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: " . BASE_URL . "index.php?controller=Login&action=index"); exit; }
        $db = Database::getConnection();
        $totalProductos = $db->query("SELECT COUNT(*) FROM productos")->fetchColumn();
        $totalVentas = $db->query("SELECT COUNT(*) FROM ventas")->fetchColumn();
        $ingresos = $db->query("SELECT SUM(monto_total) FROM ventas WHERE estado = 'COMPLETADA'")->fetchColumn();
        require_once APP_PATH . '/views/dashboard.php';
    }
}