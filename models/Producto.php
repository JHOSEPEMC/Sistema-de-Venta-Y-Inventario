<?php
// models/Producto.php

class Producto {
    public $id_producto;
    public $id_categoria;
    public $codigo_barra;
    public $nombre;
    public $unidad_base;
    public $unidad_empaque;
    public $factor_conversion;
    public $precio_unitario;
    public $precio_mayorista;
    public $precio_distribuidor;
    public $stock_total_unidades;
    public $stock_minimo;

    public function __construct($datos = []) {
        if (!empty($datos)) {
            $this->id_producto = $datos['id_producto'] ?? null;
            $this->id_categoria = $datos['id_categoria'] ?? null;
            $this->codigo_barra = $datos['codigo_barra'] ?? '';
            $this->nombre = $datos['nombre'] ?? '';
            $this->unidad_base = $datos['unidad_base'] ?? '';
            $this->unidad_empaque = $datos['unidad_empaque'] ?? '';
            $this->factor_conversion = $datos['factor_conversion'] ?? 1;
            $this->precio_unitario = $datos['precio_unitario'] ?? 0.00;
            $this->precio_mayorista = $datos['precio_mayorista'] ?? 0.00;
            $this->precio_distribuidor = $datos['precio_distribuidor'] ?? 0.00;
            $this->stock_total_unidades = $datos['stock_total_unidades'] ?? 0;
            $this->stock_minimo = $datos['stock_minimo'] ?? 5;
        }
    }
}
?>