<?php
require_once __DIR__ . '/../modelo/Proyecto.php';

class ProyectoControlador
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Proyecto();
    }

    public function Procesar()
    {
        $accion = $_REQUEST['accion'] ?? '';
        $data = [];

        switch ($accion) {


            case 'nuevo':
                $data['mostrar_formulario'] = true;
                $data['editar'] = false;
                $data['clientes_disponibles'] = $this->modelo->clientesDisponibles();
                break;

            case 'guardar':
                $this->guardarProyecto();
                header("Location: proyectos.php?msg=creado");
                exit();

            case 'editar':
                $id = $_GET['id_proyecto'] ?? 0;
                $data['proyecto'] = $this->modelo->obtenerPorId($id);
                $data['mostrar_formulario'] = true;
                $data['editar'] = true;
                $data['clientes_todos'] = $this->modelo->clientesTodos();
                break;

            case 'actualizar':
                $this->actualizarProyecto();
                header("Location: proyectos.php?msg=actualizado");
                exit();


            case 'eliminar':
                $id = $_GET['id_proyecto'] ?? 0;
                $this->modelo->eliminar($id);
                header("Location: proyectos.php?msg=eliminado");
                exit();

            default:
                $data['proyectos'] = $this->modelo->listar();
                $data['mostrar_formulario'] = false;
                $data['editar'] = false;
                break;
        }

        return $data;
    }

    private function guardarProyecto()
    {
        $data = [
            'id_cliente' => $_POST['id_cliente'],
            'nombre_proyecto' => $_POST['nombre_proyecto'],
            'descripcion' => $_POST['descripcion'],
            'fecha_inicio' => $_POST['fecha_inicio'],
            'fecha_fin' => $_POST['fecha_fin'],
            'porcentaje_avance' => $_POST['porcentaje_avance'],
            'estado' => $_POST['estado']
        ];

        return $this->modelo->crear($data);
    }
    private function actualizarProyecto()
    {
        $id_proyecto = $_POST['id_proyecto'];

        $data = [
            'id_cliente' => $_POST['id_cliente'],
            'nombre_proyecto' => $_POST['nombre_proyecto'],
            'descripcion' => $_POST['descripcion'],
            'fecha_inicio' => $_POST['fecha_inicio'],
            'fecha_fin' => $_POST['fecha_fin'],
            'porcentaje_avance' => $_POST['porcentaje_avance'],
            'estado' => $_POST['estado']
        ];

        return $this->modelo->actualizar($id_proyecto, $data);
    }
}
