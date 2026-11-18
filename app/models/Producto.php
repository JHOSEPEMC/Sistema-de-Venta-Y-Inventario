<?php
class Producto {
    public $id_producto, $id_categoria, $codigo_barra, $nombre, $unidad_base, $unidad_empaque, $factor_conversion, $precio_unitario, $precio_mayorista, $precio_distribuidor, $stock_total_unidades, $stock_minimo;
    public function __construct($datos = []) {
        if (!empty($datos)) {
            $this->id_producto = $datos['id_producto'] ?? null;
            $this->id_categoria = $datos['id_categoria'] ?? null;
            $this->codigo_barra = $datos['codigo_barra'] ?? '';
            $this->nombre = $datos['nombre'] ?? '';
            $this->unidad_base = $datos['unidad_base'] ?? 'Unidad';
            $this->unidad_empaque = $datos['unidad_empaque'] ?? 'Caja';
            $this->factor_conversion = $datos['factor_conversion'] ?? 1;
            $this->precio_unitario = $datos['precio_unitario'] ?? 0.00;
            $this->precio_mayorista = $datos['precio_mayorista'] ?? 0.00;
            $this->precio_distribuidor = $datos['precio_distribuidor'] ?? 0.00;
            $this->stock_total_unidades = $datos['stock_total_unidades'] ?? 0;
            $this->stock_minimo = $datos['stock_minimo'] ?? 5;
        }
    }
}