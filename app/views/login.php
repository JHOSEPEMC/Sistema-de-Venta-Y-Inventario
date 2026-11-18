<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - <?= NOMBRE_NEGOCIO ?></title>
    <link rel="stylesheet" href="<?= ASSETS_URL ?>css/estilos.css">
    <style> body { display: flex; justify-content: center; align-items: center; height: 100vh; } .login-box { width: 300px; } </style>
</head>
<body>
<div class="container login-box">
    <h2 style="text-align:center;"><?= NOMBRE_NEGOCIO ?></h2>
    <?php if (isset($_SESSION['error_login'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error_login'] ?></div>
        <?php unset($_SESSION['error_login']); ?>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>index.php?controller=Login&action=autenticar" method="POST">
        <div class="form-group"><label>Usuario:</label><input type="text" name="username" required></div>
        <div class="form-group"><label>Contraseña:</label><input type="password" name="password" required></div>
        <button type="submit" class="btn" style="width:100%;">Ingresar</button>
    </form>
</div>
</body>
</html>