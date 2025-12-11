<?php
// CONTROLADOR EMPLEADO
require_once __DIR__ . '/../controlador/EmpleadoControlador.php';

$empleadoCtrl = new EmpleadoControlador();
$dataEmp = $empleadoCtrl->Procesar();

// Variables provenientes del controlador
$editarEmp            = $dataEmp['editar_empleado'] ?? null;
$empleados            = $dataEmp['empleados'] ?? [];
$usuariosDisponibles  = $dataEmp['usuarios_libres'] ?? [];

$mostrarFormularioEmpleado = isset($_GET['agregar_empleado']) || $editarEmp;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        h2 {
            font-size: 36px;
            text-shadow: 0 0 8px #38bdf8;
        }

        .card {
            border-radius: 15px;
            border: 1px solid #38bdf8 !important;
            background: rgba(30, 41, 59, 0.90) !important;
            box-shadow: 0px 0px 20px rgba(0, 200, 255, 0.25);
            backdrop-filter: blur(4px);
        }

        .card-header {
            background: rgba(0, 140, 255, 0.15);
            border-bottom: 1px solid #38bdf8;
            font-size: 20px;
        }

        /* BOTONES */
        .btn-custom-blue {
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            border: none;
            color: white !important;
            font-weight: bold;
            padding: 10px 22px;
            border-radius: 25px;
            transition: 0.3s;
        }

        .btn-custom-blue:hover {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            box-shadow: 0 0 12px #38bdf8;
        }

        .btn-custom-yellow {
            background: #facc15;
            color: #1e293b !important;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
        }

        .btn-custom-yellow:hover {
            background: #eab308;
        }

        /* TABLA */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background: #38bdf8;
            color: #1e293b;
            font-weight: bold;
        }

        .table tbody tr {
            background: rgba(15, 23, 42, 0.6);
        }

        .table tbody tr:hover {
            background: rgba(56, 189, 248, 0.2);
            transition: 0.2s;
        }

        /* INPUTS */
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

        /* LABELS */
        .form-label {
            color: #38bdf8;
            font-weight: bold;
        }

    </style>
<body style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #fff;">

<section class="container my-5">

    <!-- TÍTULO -->
    <h2 class="text-center text-info fw-bold mb-4">
        Gestión de Empleados
    </h2>

    <p class="lead text-center mb-4">
        Administra el personal de la empresa: agrega nuevos empleados, edita información o elimina registros.
    </p>
    <!-- BOTÓN VOLVER -->
<div class="text-start mb-4">
    <a href="../../public/sistema-web.html"
   class="btn btn-outline-info fw-bold px-4 py-2 rounded-pill">
    ← Volver al Sistema
</a>

</div>


    <!-- FORMULARIO -->
    <?php if ($mostrarFormularioEmpleado): ?>

    <div class="card shadow-lg mb-5"
        style="background-color:#1e293b; color:white; border: 1px solid #38bdf8;">

        <div class="card-header text-center fw-bold text-warning">
            <?= $editarEmp ? "Editar Empleado" : "Insertar Empleado"; ?>
        </div>

        <div class="card-body">

            <form method="post" class="row g-3">

                <input type="hidden" name="accion_empleado"
                    value="<?= $editarEmp ? 'actualizar' : 'insertar'; ?>">

                <?php if ($editarEmp): ?>
                    <input type="hidden" name="id_empleado"
                        value="<?= htmlspecialchars($editarEmp['id_empleado']) ?>">
                <?php endif; ?>

                <!-- Usuario -->
                <div class="col-md-4">
                    <label class="form-label">Usuario</label>

                    <?php if ($editarEmp): ?>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($editarEmp['usuario_id']) ?> (no modificable)"
                            disabled>
                        <input type="hidden" name="usuario_id"
                            value="<?= htmlspecialchars($editarEmp['usuario_id']) ?>">
                    <?php else: ?>
                        <select name="usuario_id" class="form-control" required>
                            <option value="">Seleccione un usuario</option>

                            <?php foreach ($usuariosDisponibles as $u): ?>
                                <option value="<?= $u['id_usuario'] ?>">
                                    <?= $u['id_usuario']." - ".htmlspecialchars($u['nombre_usuario']) ?>
                                </option>
                            <?php endforeach; ?>

                            <?php if (empty($usuariosDisponibles)): ?>
                                <option value="">No hay usuarios disponibles</option>
                            <?php endif; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <!-- Campos -->
                <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input name="nombre" class="form-control" required
                        value="<?= htmlspecialchars($editarEmp['nombre'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Apellido</label>
                    <input name="apellido" class="form-control" required
                        value="<?= htmlspecialchars($editarEmp['apellido'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input name="correo" class="form-control"
                        value="<?= htmlspecialchars($editarEmp['correo'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input name="telefono" class="form-control"
                        value="<?= htmlspecialchars($editarEmp['telefono'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Cargo</label>
                    <input name="cargo" class="form-control"
                        value="<?= htmlspecialchars($editarEmp['cargo'] ?? '') ?>">
                </div>

                <!-- Botones -->
                <div class="col-12 mt-3 text-center">
                    <button class="btn btn-info fw-bold px-4 py-2 rounded-pill">
                        <?= $editarEmp ? 'Actualizar' : 'Guardar' ?>
                    </button>

                    <a href="panelempleados.php"
                    class="btn btn-outline-light px-4 py-2 rounded-pill fw-bold">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php endif; ?>


    <!-- LISTA -->
    <?php if (!$mostrarFormularioEmpleado): ?>

    <!-- Crear Usuario -->
    <div class="text-end mb-3">
        <a href="frmRegistrar.php"
        class="btn btn-info fw-bold px-4 py-2 rounded-pill">
            + Crear Usuario
        </a>
    </div>

    <!-- Agregar Empleado -->
    <div class="text-end mb-4">
        <a href="?agregar_empleado=1"
        class="btn btn-warning fw-bold px-4 py-2 rounded-pill">
            + Agregar Empleado
        </a>
    </div>

    <!-- Tabla -->
    <div class="card shadow-lg mb-5"
        style="background-color:#1e293b; color:white; border: 1px solid #38bdf8;">

        <div class="card-body">
            <h4 class="text-warning mb-3 text-center fw-bold">Lista de Empleados</h4>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle">
                    <thead class="table-info text-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Cargo</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($empleados as $e): ?>
                            <tr>
                                <td><?= $e['id_empleado'] ?></td>
                                <td><?= $e['usuario_id'] ?></td>
                                <td><?= htmlspecialchars($e['nombre']) ?></td>
                                <td><?= htmlspecialchars($e['apellido']) ?></td>
                                <td><?= htmlspecialchars($e['correo']) ?></td>
                                <td><?= htmlspecialchars($e['telefono']) ?></td>
                                <td><?= htmlspecialchars($e['cargo']) ?></td>
                                <td><?= htmlspecialchars($e['fecha_registro']) ?></td>

                                <td>
                                    <a href="?editar_empleado=<?= $e['id_empleado'] ?>"
                                    class="btn btn-warning btn-sm">Editar</a>

                                    <a href="?eliminar_empleado=<?= $e['id_empleado'] ?>"
                                    onclick="return confirm('¿Eliminar empleado?');"
                                    class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($empleados)): ?>
                            <tr>
                                <td colspan="9" class="text-center">No hay empleados registrados.</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?php endif; ?>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
