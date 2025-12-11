<?php
require_once __DIR__ . '/../modelo/Empleado.php';
require_once __DIR__ . '/../modelo/Usuario.php';

class EmpleadoControlador
{
    private Empleado $model;

    public function __construct()
    {
        $this->model = new Empleado();
    }

    public function Procesar(): array
    {

        // ELIMINAR EMPLEADO
        if (isset($_GET['eliminar_empleado'])) {
            $this->model->Borrar((int)$_GET['eliminar_empleado']);
            header('Location: panelempleados.php');
            exit;
        }

        // EDITAR EMPLEADO
        $editar = null;
        if (isset($_GET['editar_empleado'])) {
            $editar = $this->model->BuscarID((int)$_GET['editar_empleado']);
        }

        // PROCESAR FORMULARIO
        if (isset($_POST['accion_empleado'])) {

            $accion = $_POST['accion_empleado'];

            if ($accion === 'insertar') {

                $this->model->Insertar(
                    (int)$_POST['usuario_id'],
                    $_POST['nombre'],
                    $_POST['apellido'],
                    $_POST['correo'] ?: null,
                    $_POST['telefono'] ?: null,
                    $_POST['cargo'] ?: null
                );

            } elseif ($accion === 'actualizar') {

                $this->model->Actualizar(
                    (int)$_POST['id_empleado'],
                    (int)$_POST['usuario_id'],
                    $_POST['nombre'],
                    $_POST['apellido'],
                    $_POST['correo'] ?: null,
                    $_POST['telefono'] ?: null,
                    $_POST['cargo'] ?: null
                );
            }

            header('Location: panelempleados.php');
            exit;
        }

        // DATOS PARA LA VISTA
        return [
            'editar_empleado' => $editar,
            'empleados'       => $this->model->Mostrar(),
            'usuarios_libres' => $this->model->ObtenerUsuariosDisponibles() // IMPORTANTE
        ];
    }
}
