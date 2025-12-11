<?php
require_once __DIR__ . '/../controlador/ClienteControlador.php';

$clienteCtrl = new ClienteControlador();
$data = $clienteCtrl->Procesar();

$editarCliente = $data['editar_cliente'] ?? null;
$clientes      = $data['clientes'] ?? [];
$mostrarForm   = isset($_GET['agregar_cliente']) || $editarCliente;
$usuarios_libres = $data['usuarios_libres'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
</head>

<body>
<section class="container my-5">

    <h2 class="text-center text-info fw-bold mb-4">
        Gestión de Clientes
    </h2>

    <p class="lead text-center mb-4">
        Administra la lista de clientes: registra nuevos, edita o elimina información.
    </p>

    <div class="text-start mb-4">
        <a href="../../public/sistema-web.html"
           class="btn btn-outline-info fw-bold px-4 py-2 rounded-pill">
            ← Volver al Sistema
        </a>
    </div>

    <!-- FORMULARIO -->
    <?php if ($mostrarForm): ?>

        <div class="card shadow-lg mb-5">
            <div class="card-header text-center fw-bold text-warning">
                <?= $editarCliente ? "Editar Cliente" : "Agregar Cliente"; ?>
            </div>

            <div class="card-body">
                <form method="POST" class="row g-3">

                    <input type="hidden" name="accion_cliente"
                           value="<?= $editarCliente ? 'actualizar' : 'insertar'; ?>">

                    <?php if ($editarCliente): ?>
                        <input type="hidden" name="id_cliente"
                               value="<?= htmlspecialchars($editarCliente['id_cliente']); ?>">
                    <?php endif; ?>

                    <div class="col-md-6">
                        <label class="form-label">Usuario</label>

                        <?php if ($editarCliente): ?>

                            <!-- USUARIO FIJO AL EDITAR -->
                            <input type="text" class="form-control"
                                   value="ID <?= htmlspecialchars($editarCliente['usuario_id']) ?> (no modificable)"
                                   disabled>

                            <input type="hidden" name="usuario_id"
                                   value="<?= htmlspecialchars($editarCliente['usuario_id']) ?>">

                        <?php else: ?>

                            <!-- LISTA DE USUARIOS DISPONIBLES -->
                            <select name="usuario_id" class="form-control" required>
                                <option value="">Seleccione un usuario</option>

                                <?php if (!empty($usuarios_libres)): ?>
                                    <?php foreach ($usuarios_libres as $u): ?>
                                        <option value="<?= $u['id_usuario'] ?>">
                                            <?= $u['id_usuario'] . " - " . htmlspecialchars($u['nombre_usuario']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay usuarios disponibles</option>
                                <?php endif; ?>

                            </select>

                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nombre de la Empresa</label>
                        <input name="nombre_empresa" class="form-control" required
                               value="<?= htmlspecialchars($editarCliente['nombre_empresa'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Representante</label>
                        <input name="representante" class="form-control"
                               value="<?= htmlspecialchars($editarCliente['representante'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input name="correo" class="form-control"
                               value="<?= htmlspecialchars($editarCliente['correo'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input name="telefono" class="form-control"
                               value="<?= htmlspecialchars($editarCliente['telefono'] ?? '') ?>">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2"><?= htmlspecialchars($editarCliente['direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <button class="btn btn-info fw-bold px-4 py-2 rounded-pill">
                            <?= $editarCliente ? 'Actualizar' : 'Guardar' ?>
                        </button>

                        <a href="frmcliente.php"
                           class="btn btn-outline-light px-4 py-2 rounded-pill fw-bold">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>

    <?php endif; ?>

    <!-- LISTA -->
    <?php if (!$mostrarForm): ?>

        <div class="text-end mb-4">
            <a href="?agregar_cliente=1"
               class="btn btn-warning fw-bold px-4 py-2 rounded-pill">
                + Agregar Cliente
            </a>
        </div>

        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="text-warning mb-3 text-center fw-bold">Lista de Clientes</h4>

                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover align-middle">
                        <thead class="table-info text-dark">
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Empresa</th>
                                <th>Representante</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($clientes as $c): ?>
                                <tr>
                                    <td><?= $c['id_cliente'] ?></td>
                                    <td><?= htmlspecialchars($c['nombre_usuario']) ?></td>
                                    <td><?= htmlspecialchars($c['nombre_empresa']) ?></td>
                                    <td><?= htmlspecialchars($c['representante']) ?></td>
                                    <td><?= htmlspecialchars($c['correo']) ?></td>
                                    <td><?= htmlspecialchars($c['telefono']) ?></td>

                                    <td>
                                        <a href="?editar_cliente=<?= $c['id_cliente'] ?>"
                                           class="btn btn-warning btn-sm">Editar</a>

                                        <a href="?eliminar_cliente=<?= $c['id_cliente'] ?>"
                                           onclick="return confirm('¿Eliminar cliente?');"
                                           class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($clientes)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay clientes registrados.</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    <?php endif; ?>

</section>


</body>

</html>