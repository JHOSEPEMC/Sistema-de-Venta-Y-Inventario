<?php
class ProductoDAO {
    private $db;
    public function __construct() { $this->db = Database::getConnection(); }
    public function listar() { return $this->db->query("SELECT * FROM productos ORDER BY nombre ASC")->fetchAll(); }
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id_producto = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    public function crear(Producto $p) {
        $sql = "INSERT INTO productos (id_categoria, codigo_barra, nombre, unidad_base, unidad_empaque, factor_conversion, precio_unitario, precio_mayorista, precio_distribuidor, stock_total_unidades, stock_minimo) 
                VALUES (:id_cat, :cod, :nom, :ub, :ue, :fc, :pu, :pm, :pd, :stock, :min)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_cat' => $p->id_categoria, ':cod' => $p->codigo_barra, ':nom' => $p->nombre,
            ':ub' => $p->unidad_base, ':ue' => $p->unidad_empaque, ':fc' => $p->factor_conversion,
            ':pu' => $p->precio_unitario, ':pm' => $p->precio_mayorista, ':pd' => $p->precio_distribuidor,
            ':stock' => $p->stock_total_unidades, ':min' => $p->stock_minimo
        ]);
    }
    // Método crítico para Ventas (Descuento de stock)
    public function descontarStock($id_producto, $cantidad_unidades) {
        $stmt = $this->db->prepare("UPDATE productos SET stock_total_unidades = stock_total_unidades - :cant WHERE id_producto = :id");
        return $stmt->execute([':cant' => $cantidad_unidades, ':id' => $id_producto]);
    }
}