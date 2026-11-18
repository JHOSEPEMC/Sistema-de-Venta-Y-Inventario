<?php $titulo = "Historial de Ventas"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Historial de Ventas</h2>
<a href="<?= BASE_URL ?>index.php?controller=Venta&action=crear" class="btn">+ Nueva Venta</a>
<table>
    <thead><tr><th>ID</th><th>Cliente</th><th>Vendedor</th><th>Fecha</th><th>Tipo Pago</th><th>Total</th><th>Estado</th></tr></thead>
    <tbody>
        <?php foreach ($ventas as $v): ?>
        <tr>
            <td><?= $v['id_venta'] ?></td>
            <td><?= htmlspecialchars($v['cliente'] ?? 'Cliente Genérico') ?></td>
            <td><?= htmlspecialchars($v['vendedor']) ?></td>
            <td><?= $v['fecha_venta'] ?></td>
            <td><?= $v['tipo_pago'] ?></td>
            <td><?= MONEDA ?> <?= number_format($v['monto_total'], 2) ?></td>
            <td><?= $v['estado'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>