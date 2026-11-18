<?php $titulo = "Dashboard"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Bienvenido, <?= $_SESSION['usuario_nombre'] ?> (<?= $_SESSION['usuario_rol'] ?>)</h2>
<div style="display: flex; gap: 20px;">
    <div class="container" style="flex:1; background: #0056b3; color:white;"><h3>Productos</h3><p style="font-size:24px;"><?= $totalProductos ?></p></div>
    <div class="container" style="flex:1; background: #28a745; color:white;"><h3>Ventas</h3><p style="font-size:24px;"><?= $totalVentas ?></p></div>
    <div class="container" style="flex:1; background: #ffc107; color:black;"><h3>Ingresos</h3><p style="font-size:24px;"><?= MONEDA ?> <?= number_format($ingresos ?? 0, 2) ?></p></div>
</div>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>