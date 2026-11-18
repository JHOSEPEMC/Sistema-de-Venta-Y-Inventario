<?php
class Venta {
    public $id_cliente, $id_usuario, $tipo_pago, $monto_subtotal, $monto_total, $estado;
    public function __construct($datos = []) {
        $this->id_cliente = $datos['id_cliente'] ?? null;
        $this->id_usuario = $datos['id_usuario'] ?? null;
        $this->tipo_pago = $datos['tipo_pago'] ?? 'CONTADO';
        $this->monto_subtotal = $datos['monto_subtotal'] ?? 0;
        $this->monto_total = $datos['monto_total'] ?? 0;
        $this->estado = $datos['estado'] ?? 'COMPLETADA';
    }
}