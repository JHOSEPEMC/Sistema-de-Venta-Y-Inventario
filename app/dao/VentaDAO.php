<?php
class VentaDAO {
    private $db;
    public function __construct() { $this->db = Database::getConnection(); }

    // Obtener precio según volumen (HU-02)
    private function obtenerPrecio($id_producto, $cantidad) {
        $stmt = $this->db->prepare("SELECT precio_unitario, precio_mayorista, precio_distribuidor FROM productos WHERE id_producto = :id");
        $stmt->execute([':id' => $id_producto]);
        $p = $stmt->fetch();
        if (!$p) return 0;
        if ($cantidad > 50) return $p['precio_distribuidor'];
        if ($cantidad >= 11) return $p['precio_mayorista'];
        return $p['precio_unitario'];
    }

    // Procesar Venta (Transacción ACID)
    public function registrarVenta($id_cliente, $id_usuario, $tipo_pago, $items) {
        try {
            $this->db->beginTransaction();
            $total = 0;
            $detalles = [];

            // 1. Calcular totales y verificar stock
            foreach ($items as $item) {
                $cantidad = $item['cantidad'];
                $id_prod = $item['id_producto'];
                
                // Verificar stock
                $stmtStock = $this->db->prepare("SELECT stock_total_unidades FROM productos WHERE id_producto = :id");
                $stmtStock->execute([':id' => $id_prod]);
                $stock = $stmtStock->fetchColumn();
                if ($stock < $cantidad) throw new Exception("Stock insuficiente para el producto ID: $id_prod");

                $precio = $this->obtenerPrecio($id_prod, $cantidad);
                $subtotal = $precio * $cantidad;
                $total += $subtotal;
                $detalles[] = ['id_producto' => $id_prod, 'cantidad' => $cantidad, 'precio' => $precio, 'subtotal' => $subtotal];
            }

            // 2. Insertar Venta
            $stmtVenta = $this->db->prepare("INSERT INTO ventas (id_cliente, id_usuario, tipo_pago, monto_subtotal, monto_total) VALUES (:cli, :usr, :tp, :sub, :tot)");
            $stmtVenta->execute([':cli' => $id_cliente, ':usr' => $id_usuario, ':tp' => $tipo_pago, ':sub' => $total, ':tot' => $total]);
            $id_venta = $this->db->lastInsertId();

            // 3. Insertar Detalles y Descontar Stock
            $stmtDetalle = $this->db->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario_aplicado, subtotal) VALUES (:v, :p, :c, :pr, :s)");
            $stmtStockUpd = $this->db->prepare("UPDATE productos SET stock_total_unidades = stock_total_unidades - :cant WHERE id_producto = :id");

            foreach ($detalles as $d) {
                $stmtDetalle->execute([':v' => $id_venta, ':p' => $d['id_producto'], ':c' => $d['cantidad'], ':pr' => $d['precio'], ':s' => $d['subtotal']]);
                $stmtStockUpd->execute([':cant' => $d['cantidad'], ':id' => $d['id_producto']]);
            }

            // 4. Si es CRÉDITO, actualizar saldo del cliente
            if ($tipo_pago === 'CREDITO') {
                $stmtCredito = $this->db->prepare("UPDATE clientes SET saldo_pendiente = saldo_pendiente + :tot WHERE id_cliente = :id");
                $stmtCredito->execute([':tot' => $total, ':id' => $id_cliente]);
            }

            $this->db->commit();
            return $id_venta;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function listar() {
        $sql = "SELECT v.*, c.razon_social as cliente, u.nombre_completo as vendedor 
                FROM ventas v 
                LEFT JOIN clientes c ON v.id_cliente = c.id_cliente 
                LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario 
                ORDER BY v.fecha_venta DESC";
        return $this->db->query($sql)->fetchAll();
    }
}