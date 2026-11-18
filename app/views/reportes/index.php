<?php $titulo = "Reportes"; require_once APP_PATH . '/views/layouts/header.php'; ?>

<h2>Generación de Reportes de Ventas</h2>

<div class="container" style="background: #f8f9fa; padding: 20px; margin-bottom: 20px;">
    <form action="<?= BASE_URL ?>index.php" method="GET" style="display: flex; gap: 15px; align-items: flex-end;">
        <!-- Parámetros ocultos para que el enrutador sepa a dónde ir -->
        <input type="hidden" name="controller" value="Reporte">
        <input type="hidden" name="action" value="pdf" id="accion_form">

        <div class="form-group" style="margin-bottom: 0;">
            <label>Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" value="<?= date('Y-m-01') ?>" required>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Fecha Fin:</label>
            <input type="date" name="fecha_fin" value="<?= date('Y-m-d') ?>" required>
        </div>
        
        <button type="submit" class="btn" onclick="document.getElementById('accion_form').value='pdf';">📄 Descargar PDF</button>
        <button type="submit" class="btn" style="background:#1d6f42;" onclick="document.getElementById('accion_form').value='excel';">📊 Descargar Excel</button>
    </form>
</div>

<div class="container" style="background: #e9ecef;">
    <h4>Información del Reporte</h4>
    <p>Selecciona un rango de fechas y el sistema generará un reporte consolidado con todas las ventas, indicando el cliente, vendedor, tipo de pago y el monto total recaudado en ese periodo.</p>
</div>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>