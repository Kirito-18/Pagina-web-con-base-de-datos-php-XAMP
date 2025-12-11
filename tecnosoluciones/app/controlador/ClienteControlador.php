<?php
require_once __DIR__ . '/../modelo/Cliente.php';

class ClienteControlador
{
    private Cliente $model;

    public function __construct()
    {
        $this->model = new Cliente();
    }

    public function Procesar(): array
    {
        /* ELIMINAR CLIENTE */
        if (isset($_GET['eliminar_cliente'])) {
            $this->model->Borrar((int)$_GET['eliminar_cliente']);
            header("Location: frmcliente.php");
            exit;
        }

        /* EDITAR CLIENTE */
        $editar = null;
        if (isset($_GET['editar_cliente'])) {
            $editar = $this->model->BuscarID((int)$_GET['editar_cliente']);
        }

        /* INSERTAR O ACTUALIZAR */
        if (isset($_POST['accion_cliente'])) {

            $accion = $_POST['accion_cliente'];

            if ($accion === 'insertar') {
                $this->model->Insertar(
                    (int)$_POST['usuario_id'],
                    $_POST['nombre_empresa'],
                    $_POST['representante'] ?: null,
                    $_POST['correo'] ?: null,
                    $_POST['telefono'] ?: null,
                    $_POST['direccion'] ?: null
                );

            } elseif ($accion === 'actualizar') {
                $this->model->Actualizar(
                    (int)$_POST['id_cliente'],
                    (int)$_POST['usuario_id'],
                    $_POST['nombre_empresa'],
                    $_POST['representante'] ?: null,
                    $_POST['correo'] ?: null,
                    $_POST['telefono'] ?: null,
                    $_POST['direccion'] ?: null
                );
            }

            header("Location: frmcliente.php");
            exit;
        }

        /* RETORNAR DATOS */
        return [
            'editar_cliente'  => $editar,
            'clientes'        => $this->model->Mostrar(),
            'usuarios_libres' => $this->model->ObtenerUsuariosDisponibles()
        ];
    }
}
