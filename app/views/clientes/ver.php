<?php $titulo = "Detalle del Cliente"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Detalle del Cliente: <?= htmlspecialchars($cliente['razon_social']) ?></h2>

<div style="display: flex; gap: 20px; margin-bottom: 20px;">
    <div class="container" style="flex:1; background: #f8f9fa;">
        <h4>Información</h4>
        <p><strong>RUC/DNI:</strong> <?= $cliente['ruc_dni'] ?></p>
        <p><strong>Tipo:</strong> <?= $cliente['tipo_cliente'] ?></p>
        <p><strong>Límite de Crédito:</strong> <?= MONEDA ?> <?= number_format($cliente['limite_credito'], 2) ?></p>
    </div>
    <div class="container" style="flex:1; background: #fff3cd;">
        <h4>Estado de Cuenta</h4>
        <p><strong>Saldo Pendiente:</strong> <span style="color: red; font-size: 20px;"><?= MONEDA ?> <?= number_format($cliente['saldo_pendiente'], 2) ?></span></p>
        
        <!-- Formulario de Abono -->
        <form action="<?= BASE_URL ?>index.php?controller=Cliente&action=abonar" method="POST" style="display: flex; gap: 10px; align-items: flex-end;">
            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
            <div class="form-group" style="flex:1; margin-bottom: 0;">
                <label>Monto a Abonar:</label>
                <input type="number" step="0.01" name="monto" required placeholder="0.00">
            </div>
            <button type="submit" class="btn" style="background: #0056b3;">Registrar Abono</button>
        </form>
    </div>
</div>

<h3>Historial de Compras (Últimos 10 pedidos)</h3>
<table>
    <thead><tr><th>ID Venta</th><th>Fecha</th><th>Tipo Pago</th><th>Total</th><th>Estado</th></tr></thead>
    <tbody>
        <?php if (!empty($historial)): ?>
            <?php foreach ($historial as $v): ?>
            <tr>
                <td><?= $v['id_venta'] ?></td>
                <td><?= $v['fecha_venta'] ?></td>
                <td><?= $v['tipo_pago'] ?></td>
                <td><?= MONEDA ?> <?= number_format($v['monto_total'], 2) ?></td>
                <td><?= $v['estado'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No hay compras registradas para este cliente.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= BASE_URL ?>index.php?controller=Cliente&action=index" class="btn" style="background:#6c757d; margin-top: 20px;">Volver a la lista</a>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>