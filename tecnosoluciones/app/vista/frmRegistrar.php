<?php
require_once __DIR__ . '/../controlador/UsuarioControlador.php';
$ctrl = new UsuarioControlador();
$data = $ctrl->Procesar();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="icon" href="C:/xampp/htdocs/tecnosoluciones/public/image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<style>

    body {
        background: linear-gradient(135deg, #0a0f1f, #0f172a);
        color: #e2e8f0;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    /* TITULO CENTRADO */
    h2 {
        font-size: 36px;
        text-shadow: 0 0 8px #38bdf8;
        text-align: center;
    }

    .card {
        border-radius: 15px;
        border: 1px solid #38bdf8 !important;
        background: rgba(30, 41, 59, 0.90) !important;
        box-shadow: 0px 0px 20px rgba(0, 200, 255, 0.25);
        backdrop-filter: blur(4px);
        padding: 30px;
    }

    /* BOTONES MEJORADOS */
    .btn-custom-blue {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        border: none;
        color: white !important;
        font-weight: bold;
        padding: 12px 26px;
        border-radius: 30px;
        transition: 0.3s;
        width: 100%;
    }

    .btn-custom-blue:hover {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
        box-shadow: 0 0 12px #38bdf8;
    }

    .btn-custom-gray {
        background: #94a3b8;
        color: #1e293b !important;
        font-weight: bold;
        padding: 12px 26px;
        border-radius: 30px;
        width: 100%;
        transition: 0.3s;
    }

    .btn-custom-gray:hover {
        background: #cbd5e1;
    }

    .form-control {
        background: #0f172a;
        color: #e2e8f0;
        border: 1px solid #38bdf8;
    }

    .form-control:focus {
        background: #1e293b;
        border-color: #0ea5e9;
        color: white;
        box-shadow: 0 0 8px #38bdf8;
    }

    .form-label {
        color: #38bdf8;
        font-weight: bold;
    }

</style>

<body class="bg-light p-5">

<div class="container">
    
    <h2 class="mb-4">Registrar Nuevo Usuario</h2>

    <form method="post" class="card shadow-sm">

        <input type="hidden" name="accion_usuario" value="registrar">

        <label class="form-label">Nombre de Usuario</label>
        <input type="text" name="nombre_usuario" class="form-control" required>

        <label class="form-label mt-3">Contraseña</label>
        <input type="password" name="password" class="form-control" required>

        <label class="form-label mt-3">Rol</label>
        <select name="rol" class="form-control" required>
            <option value="administrador">Administrador</option>
            <option value="empleado">Empleado</option>
            <option value="cliente">Cliente</option>
        </select>

        <label class="form-label mt-3">Estado</label>
        <select name="estado" class="form-control" required>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>

        <!-- BOTONES MÁS BONITOS -->
        <button class="btn-custom-blue mt-4">Registrar Usuario</button>

        <a href="panelempleados.php" class="btn-custom-gray mt-3 text-center">Volver</a>

    </form>
</div>

</body>
</html>
