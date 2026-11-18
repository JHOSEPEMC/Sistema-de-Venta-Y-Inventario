<?php $titulo = "Nuevo Cliente"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Registrar Nuevo Cliente</h2>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form action="<?= BASE_URL ?>index.php?controller=Cliente&action=guardar" method="POST">
    <div class="form-group">
        <label>RUC / DNI:</label>
        <input type="text" name="ruc_dni" required placeholder="Ej. 20123456789 o 70123456">
    </div>
    <div class="form-group">
        <label>Razón Social / Nombre:</label>
        <input type="text" name="razon_social" required placeholder="Ej. Minimarket El Sol">
    </div>
    <div class="form-group">
        <label>Tipo de Cliente:</label>
        <select name="tipo_cliente">
            <option value="MINORISTA">MINORISTA</option>
            <option value="MAYORISTA" selected>MAYORISTA</option>
            <option value="DISTRIBUIDOR">DISTRIBUIDOR</option>
        </select>
    </div>
    <div class="form-group">
        <label>Límite de Crédito (S/):</label>
        <input type="number" step="0.01" name="limite_credito" value="0.00" required>
    </div>
    <button type="submit" class="btn">Guardar Cliente</button>
    <a href="<?= BASE_URL ?>index.php?controller=Cliente&action=index" class="btn" style="background:#6c757d;">Cancelar</a>
</form>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>