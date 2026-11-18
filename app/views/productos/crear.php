<?php $titulo = "Nuevo Producto"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Registrar Producto</h2>
<form action="<?= BASE_URL ?>index.php?controller=Producto&action=guardar" method="POST">
    <div class="form-group"><label>Nombre:</label><input type="text" name="nombre" required></div>
    <div class="form-group"><label>Código Barra:</label><input type="text" name="codigo_barra"></div>
    <div class="form-group"><label>Categoría ID:</label><input type="number" name="id_categoria" value="1"></div>
    <div class="form-group"><label>Unidad Base:</label><input type="text" name="unidad_base" value="Unidad"></div>
    <div class="form-group"><label>Unidad Empaque:</label><input type="text" name="unidad_empaque" value="Caja"></div>
    <div class="form-group"><label>Factor Conversión (ej. 24):</label><input type="number" name="factor_conversion" value="24"></div>
    <div class="form-group"><label>Precio Unitario:</label><input type="number" step="0.01" name="precio_unitario" required></div>
    <div class="form-group"><label>Precio Mayorista:</label><input type="number" step="0.01" name="precio_mayorista" required></div>
    <div class="form-group"><label>Precio Distribuidor:</label><input type="number" step="0.01" name="precio_distribuidor" required></div>
    <div class="form-group"><label>Stock Inicial:</label><input type="number" name="stock_total_unidades" value="0"></div>
    <button type="submit" class="btn">Guardar</button>
</form>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>