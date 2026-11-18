<?php $titulo = "Nueva Venta"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Registrar Venta</h2>
<form action="<?= BASE_URL ?>index.php?controller=Venta&action=guardar" method="POST">
    <div class="form-group">
        <label>Cliente:</label>
        <select name="id_cliente" required>
            <option value="">Seleccione...</option>
            <?php foreach($clientes as $c): ?>
                <option value="<?= $c['id_cliente'] ?>"><?= $c['razon_social'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Tipo de Pago:</label>
        <select name="tipo_pago"><option value="CONTADO">CONTADO</option><option value="CREDITO">CRÉDITO</option></select>
    </div>
    
    <h3>Productos</h3>
    <div id="productos-container">
        <div class="producto-row" style="display:flex; gap:10px; margin-bottom:10px;">
            <select name="id_producto[]" style="flex:2;">
                <option value="">Seleccione Producto</option>
                <?php foreach($productos as $p): ?>
                    <option value="<?= $p['id_producto'] ?>"><?= $p['nombre'] ?> (Stock: <?= $p['stock_total_unidades'] ?>)</option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="cantidad[]" placeholder="Cantidad (Unidades)" style="flex:1;">
        </div>
    </div>
    <button type="button" class="btn" onclick="agregarFila()">+ Agregar otro producto</button>
    <br><br>
    <button type="submit" class="btn" style="background:#0056b3;">Procesar Venta</button>
</form>

<script>
function agregarFila() {
    const container = document.getElementById('productos-container');
    const newRow = document.createElement('div');
    newRow.className = 'producto-row';
    newRow.style = 'display:flex; gap:10px; margin-bottom:10px;';
    newRow.innerHTML = `
        <select name="id_producto[]" style="flex:2;">
            <option value="">Seleccione Producto</option>
            <?php foreach($productos as $p): ?>
                <option value="<?= $p['id_producto'] ?>"><?= $p['nombre'] ?> (Stock: <?= $p['stock_total_unidades'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="cantidad[]" placeholder="Cantidad" style="flex:1;">
    `;
    container.appendChild(newRow);
}
</script>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>