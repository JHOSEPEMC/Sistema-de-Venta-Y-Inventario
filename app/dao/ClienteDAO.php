<?php
class ClienteDAO {
    private $db;
    
    public function __construct() { 
        $this->db = Database::getConnection(); 
    }
    
    public function listar() { 
        return $this->db->query("SELECT * FROM clientes ORDER BY razon_social ASC")->fetchAll(); 
    }
    
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id_cliente = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    // NUEVO: Obtener los últimos 10 pedidos del cliente
    public function obtenerHistorial($id_cliente) {
        $stmt = $this->db->prepare("SELECT * FROM ventas WHERE id_cliente = :id ORDER BY fecha_venta DESC LIMIT 10");
        $stmt->execute([':id' => $id_cliente]);
        return $stmt->fetchAll();
    }
    
    public function crear($ruc, $razon, $tipo, $limite) {
        $sql = "INSERT INTO clientes (ruc_dni, razon_social, tipo_cliente, limite_credito) 
                VALUES (:ruc, :raz, :tipo, :lim)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':ruc' => $ruc, ':raz' => $razon, ':tipo' => $tipo, ':lim' => $limite]);
    }
    
    public function registrarAbono($id_cliente, $monto) {
        $this->db->beginTransaction();
        try {
            // 1. Actualizar el saldo del cliente
            $stmt = $this->db->prepare("UPDATE clientes SET saldo_pendiente = saldo_pendiente - :monto WHERE id_cliente = :id");
            $stmt->execute([':monto' => $monto, ':id' => $id_cliente]);
            
            // 2. Registrar el abono en la tabla de abonos
            $stmtAbono = $this->db->prepare("INSERT INTO abonos (id_cliente, monto_abono, metodo_pago) VALUES (:id, :monto, 'EFECTIVO')");
            $stmtAbono->execute([':id' => $id_cliente, ':monto' => $monto]);
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}