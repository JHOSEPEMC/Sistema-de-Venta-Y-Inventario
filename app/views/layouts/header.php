<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? NOMBRE_NEGOCIO ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/estilos.css">
</head>
<body>
<div class="container">
    <?php if(isset($_SESSION['usuario_id'])): ?>
    <div class="menu">
        <a href="<?= BASE_URL ?>index.php?controller=Dashboard&action=index">Inicio</a>
        <a href="<?= BASE_URL ?>index.php?controller=Producto&action=index">Productos</a>
        <a href="<?= BASE_URL ?>index.php?controller=Venta&action=index">Ventas</a>
        <a href="<?= BASE_URL ?>index.php?controller=Cliente&action=index">Clientes</a>
        <a href="<?= BASE_URL ?>index.php?controller=Reporte&action=index">Reportes</a>
        <a href="<?= BASE_URL ?>index.php?controller=Login&action=salir" style="float:right;">Cerrar Sesión (<?= $_SESSION['usuario_nombre'] ?>)</a>
    </div>
    <?php endif; ?>