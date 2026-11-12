<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .alert-success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrar Nuevo Usuario</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['mensaje_exito'] ?></div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>index.php?controller=Usuario&action=guardar" method="POST">
        
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" name="nombre_completo" required placeholder="Ej. Juan Pérez">
        </div>

        <div class="form-group">
            <label>Username (Usuario):</label>
            <input type="text" name="username" required placeholder="Ej. jperez">
        </div>

        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required placeholder="Mínimo 6 caracteres">
        </div>

        <div class="form-group">
            <label>Rol:</label>
            <select name="rol">
                <option value="VENDEDOR">VENDEDOR</option>
                <option value="ALMACENERO">ALMACENERO</option>
                <option value="CONTADOR">CONTADOR</option>
                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
            </select>
        </div>

        <button type="submit">Guardar Usuario</button>
        <a href="<?= BASE_URL ?>index.php?controller=Producto&action=index" style="margin-left: 10px; text-decoration: none; color: #0056b3;">Volver</a>
    </form>
</div>

</body>
</html>