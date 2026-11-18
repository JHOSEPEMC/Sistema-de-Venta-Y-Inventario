<?php $titulo = "Lista de Productos"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Gestión de Productos</h2>
<a href="<?= BASE_URL ?>index.php?controller=Producto&action=crear" class="btn">+ Nuevo Producto</a>
<table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Código</th><th>Empaque</th><th>Stock</th><th>P. Unit</th><th>P. Mayor</th><th>P. Distrib</th></tr></thead>
    <tbody>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?= $p['id_producto'] ?></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= htmlspecialchars($p['codigo_barra']) ?></td>
            <td>1 <?= $p['unidad_empaque'] ?> = <?= $p['factor_conversion'] ?> <?= $p['unidad_base'] ?></td>
            <td><?= $p['stock_total_unidades'] ?></td>
            <td><?= MONEDA ?> <?= number_format($p['precio_unitario'], 2) ?></td>
            <td><?= MONEDA ?> <?= number_format($p['precio_mayorista'], 2) ?></td>
            <td><?= MONEDA ?> <?= number_format($p['precio_distribuidor'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>