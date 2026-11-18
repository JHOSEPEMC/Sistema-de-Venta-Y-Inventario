<?php $titulo = "Clientes"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Clientes y Créditos</h2>
<a href="<?= BASE_URL ?>index.php?controller=Cliente&action=crear" class="btn">+ Nuevo Cliente</a>
<br><br>

<?php if (isset($_SESSION['mensaje_exito'])): ?>
    <div class="alert alert-success"><?= $_SESSION['mensaje_exito'] ?></div>
    <?php unset($_SESSION['mensaje_exito']); ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>RUC/DNI</th>
            <th>Razón Social</th>
            <th>Tipo</th>
            <th>Límite Crédito</th>
            <th>Saldo Pendiente</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= $c['ruc_dni'] ?></td>
            <td><?= htmlspecialchars($c['razon_social']) ?></td>
            <td><?= $c['tipo_cliente'] ?></td>
            <td><?= MONEDA ?> <?= number_format($c['limite_credito'], 2) ?></td>
            <td><strong style="color: <?= $c['saldo_pendiente'] > 0 ? 'red' : 'green' ?>;">
                <?= MONEDA ?> <?= number_format($c['saldo_pendiente'], 2) ?>
            </strong></td>
            <td>
                <!-- Botón para ver el detalle del cliente y abonar -->
                <a href="<?= BASE_URL ?>index.php?controller=Cliente&action=ver&id=<?= $c['id_cliente'] ?>" class="btn" style="padding: 5px 10px;">Ver / Abonar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>