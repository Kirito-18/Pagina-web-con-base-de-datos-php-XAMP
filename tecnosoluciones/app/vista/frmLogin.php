<?php
session_start();

require_once __DIR__ . '/../modelo/Usuario.php';

$usuarioModelo = new Usuario();
$error = "";

if ($_POST) {
    $nombre = $_POST['usuario'];
    $password = $_POST['password'];

    $user = $usuarioModelo->ObtenerPorNombre($nombre);

    if ($user && password_verify($password, $user['password'])) {

        // VARIABLES DE SESIÓN CORRECTAS
        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['usuario_nombre'] = $user['nombre_usuario'];   // ← CORREGIDO
        $_SESSION['usuario_rol'] = $user['rol'];

        header("Location: ../../public/pagina_web.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">

<div class="container col-md-4">
    <h3 class="text-center">Login</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" class="card p-4">
        <label>Usuario</label>
        <input type="text" name="usuario" class="form-control" required>

        <label class="mt-3">Contraseña</label>
        <input type="password" name="password" class="form-control" required>

        <button class="btn btn-primary w-100 mt-4">Entrar</button>
    </form>
</div>

</body>
</html>
