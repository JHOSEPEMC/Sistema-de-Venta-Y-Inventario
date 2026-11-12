<?php
// dao/ProductoDAO.php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Producto.php';

class ProductoDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Listar todos los productos
    public function listar() {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // Obtener un producto por ID
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id_producto = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Crear un nuevo producto (HU-01)
    public function crear(Producto $producto) {
        $sql = "INSERT INTO productos (id_categoria, codigo_barra, nombre, unidad_base, unidad_empaque, factor_conversion, precio_unitario, precio_mayorista, precio_distribuidor, stock_total_unidades, stock_minimo) 
                VALUES (:id_categoria, :codigo_barra, :nombre, :unidad_base, :unidad_empaque, :factor_conversion, :precio_unitario, :precio_mayorista, :precio_distribuidor, :stock_total_unidades, :stock_minimo)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_categoria' => $producto->id_categoria,
            ':codigo_barra' => $producto->codigo_barra,
            ':nombre' => $producto->nombre,
            ':unidad_base' => $producto->unidad_base,
            ':unidad_empaque' => $producto->unidad_empaque,
            ':factor_conversion' => $producto->factor_conversion,
            ':precio_unitario' => $producto->precio_unitario,
            ':precio_mayorista' => $producto->precio_mayorista,
            ':precio_distribuidor' => $producto->precio_distribuidor,
            ':stock_total_unidades' => $producto->stock_total_unidades,
            ':stock_minimo' => $producto->stock_minimo
        ]);
    }
}
?>