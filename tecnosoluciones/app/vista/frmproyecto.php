<?php
require_once __DIR__ . '/../controlador/ProyectoControlador.php';

$proyectoCtrl = new ProyectoControlador();
$data = $proyectoCtrl->Procesar();

$editar = $data['editar'] ?? false;
$proyecto = $data['proyecto'] ?? null;

$mostrarForm = $data['mostrar_formulario'] ?? false;

$clientes_disponibles = $data['clientes_disponibles'] ?? [];
$clientes_todos = $data['clientes_todos'] ?? [];

$proyectos = $data['proyectos'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Proyectos</title>

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

        .table thead {
            background: #38bdf8;
            color: #1e293b;
            font-weight: bold;
        }

        .form-control,
        .form-select {
            background: #0f172a;
            color: #e2e8f0;
            border: 1px solid #38bdf8;
        }

        .form-control:focus,
        .form-select:focus {
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
</head>

<body>

    <section class="container my-5">

        <h2 class="text-center text-info fw-bold mb-3">Gestión de Proyectos</h2>

        <p class="lead text-center mb-4">
            Administración de los proyectos asignados a clientes
        </p>

        <div class="text-start mb-4">
            <a href="../../public/sistema-web.html"
                class="btn btn-outline-info fw-bold px-4 py-2 rounded-pill">
                ← Volver al Sistema
            </a>
        </div>
        <?php if ($mostrarForm): ?>

            <div class="card shadow-lg mb-5">
                <div class="card-header text-center fw-bold text-warning">
                    <?= $editar ? "Editar Proyecto" : "Agregar Proyecto"; ?>
                </div>

                <div class="card-body">
                    <form method="POST" action="proyectos.php" class="row g-3">

                        <input type="hidden" name="accion"
                            value="<?= $editar ? 'actualizar' : 'guardar'; ?>">

                        <?php if ($editar): ?>
                            <input type="hidden" name="id_proyecto"
                                value="<?= $proyecto['id_proyecto']; ?>">
                        <?php endif; ?>

                        <!-- CLIENTE -->
                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>

                            <select name="id_cliente" class="form-select" required>
                                <option value="">Seleccione un cliente</option>

                                <?php
                                $lista = $editar ? $clientes_todos : $clientes_disponibles;

                                foreach ($lista as $c):
                                    $sel = ($editar && $c['id_cliente'] == $proyecto['id_cliente']) ? "selected" : "";
                                ?>
                                    <option value="<?= $c['id_cliente'] ?>" <?= $sel ?>>
                                        <?= $c['id_cliente'] . " - " . htmlspecialchars($c['nombre_empresa']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- NOMBRE -->
                        <div class="col-md-6">
                            <label class="form-label">Nombre del Proyecto</label>
                            <input class="form-control" name="nombre_proyecto" required
                                value="<?= $editar ? $proyecto['nombre_proyecto'] : '' ?>">
                        </div>

                        <!-- DESCRIPCION -->
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" rows="2" name="descripcion"><?= $editar ? $proyecto['descripcion'] : '' ?></textarea>
                        </div>

                        <!-- FECHAS -->
                        <div class="col-md-6">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio"
                                value="<?= $editar ? $proyecto['fecha_inicio'] : '' ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" name="fecha_fin"
                                value="<?= $editar ? $proyecto['fecha_fin'] : '' ?>">
                        </div>

                        <!-- PORCENTAJE -->
                        <div class="col-md-6">
                            <label class="form-label">Porcentaje Avance</label>
                            <input type="number" min="0" max="100" class="form-control"
                                name="porcentaje_avance"
                                value="<?= $editar ? $proyecto['porcentaje_avance'] : '0' ?>">
                        </div>

                        <!-- ESTADO -->
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>

                            <select name="estado" class="form-select">
                                <?php
                                $estados = ['pendiente', 'en_progreso', 'finalizado', 'pausado'];
                                foreach ($estados as $e):
                                    $sel = ($editar && $proyecto['estado'] == $e) ? "selected" : "";
                                ?>
                                    <option value="<?= $e ?>" <?= $sel ?>><?= ucfirst($e) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- BOTONES -->
                        <div class="col-12 text-center mt-3">
                            <button class="btn btn-info fw-bold px-4 py-2 rounded-pill">
                                <?= $editar ? 'Actualizar' : 'Guardar' ?>
                            </button>

                            <a href="frmproyecto.php"
                            class="btn btn-outline-light px-4 py-2 rounded-pill fw-bold">
                                Cancelar
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        <?php endif; ?>

        <?php if (!$mostrarForm): ?>

            <div class="text-end mb-4">
                <a href="?accion=nuevo"
                    class="btn btn-warning fw-bold px-4 py-2 rounded-pill">
                    + Agregar Proyecto
                </a>
            </div>

            <div class="card shadow-lg mb-5">
                <div class="card-body">
                    <h4 class="text-warning mb-3 text-center fw-bold">Lista de Proyectos</h4>

                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Proyecto</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Avance</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($proyectos)): ?>
                                    <?php foreach ($proyectos as $p): ?>
                                        <tr>
                                            <td><?= $p['id_proyecto'] ?></td>
                                            <td><?= htmlspecialchars($p['nombre_empresa']) ?></td>
                                            <td><?= htmlspecialchars($p['nombre_proyecto']) ?></td>
                                            <td><?= $p['fecha_inicio'] ?></td>
                                            <td><?= $p['fecha_fin'] ?></td>
                                            <td><?= $p['porcentaje_avance'] ?>%</td>
                                            <td><?= ucfirst($p['estado']) ?></td>

                                            <td>
                                                <a href="?accion=editar&id_proyecto=<?= $p['id_proyecto'] ?>"
                                                    class="btn btn-warning btn-sm px-3">Editar</a>

                                                <a href="?accion=eliminar&id_proyecto=<?= $p['id_proyecto'] ?>"
                                                    onclick="return confirm('¿Eliminar proyecto?')"
                                                    class="btn btn-danger btn-sm px-3">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No hay proyectos registrados.</td>
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