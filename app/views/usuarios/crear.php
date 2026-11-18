<?php $titulo = "Registrar Usuario"; require_once APP_PATH . '/views/layouts/header.php'; ?>
<h2>Registrar Nuevo Usuario</h2>
<?php if (isset($_SESSION['error'])): ?><div class="alert alert-danger"><?= $_SESSION['error'] ?></div><?php unset($_SESSION['error']); ?><?php endif; ?>
<?php if (isset($_SESSION['mensaje_exito'])): ?><div class="alert alert-success"><?= $_SESSION['mensaje_exito'] ?></div><?php unset($_SESSION['mensaje_exito']); ?><?php endif; ?>
<form action="<?= BASE_URL ?>index.php?controller=Usuario&action=guardar" method="POST">
    <div class="form-group"><label>Nombre Completo:</label><input type="text" name="nombre_completo" required></div>
    <div class="form-group"><label>Username:</label><input type="text" name="username" required></div>
    <div class="form-group"><label>Contraseña:</label><input type="password" name="password" required></div>
    <div class="form-group"><label>Rol:</label><select name="rol"><option value="VENDEDOR">VENDEDOR</option><option value="ALMACENERO">ALMACENERO</option><option value="ADMINISTRADOR">ADMINISTRADOR</option></select></div>
    <button type="submit" class="btn">Guardar Usuario</button>
</form>
<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>