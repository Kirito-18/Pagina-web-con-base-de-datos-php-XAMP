<?php
// Modelo Proyecto
require_once __DIR__ . '/../datos/DB.php';

class Proyecto
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function listar()
    {
        $sql = "SELECT p.*, c.nombre_empresa 
                FROM proyectos p
                INNER JOIN clientes c ON c.id_cliente = p.id_cliente
                ORDER BY p.id_proyecto DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id_proyecto)
    {
        $sql = "SELECT * FROM proyectos WHERE id_proyecto = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_proyecto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        $sql = "INSERT INTO proyectos
                    (id_cliente, nombre_proyecto, descripcion, fecha_inicio, fecha_fin, porcentaje_avance, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['id_cliente'],
            $data['nombre_proyecto'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['porcentaje_avance'],
            $data['estado']
        ]);
    }
    public function actualizar($id_proyecto, $data)
    {
        $sql = "UPDATE proyectos SET
                    id_cliente = ?, 
                    nombre_proyecto = ?, 
                    descripcion = ?, 
                    fecha_inicio = ?, 
                    fecha_fin = ?, 
                    porcentaje_avance = ?, 
                    estado = ?
                WHERE id_proyecto = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['id_cliente'],
            $data['nombre_proyecto'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['porcentaje_avance'],
            $data['estado'],
            $id_proyecto
        ]);
    }

    public function eliminar($id_proyecto)
    {
        $sql = "DELETE FROM proyectos WHERE id_proyecto = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_proyecto]);
    }
    public function clienteExiste($id_cliente)
    {
        $sql = "SELECT id_cliente FROM clientes WHERE id_cliente = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_cliente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function clientesDisponibles()
    {
        $sql = "SELECT id_cliente, nombre_empresa 
                FROM clientes
                WHERE id_cliente NOT IN (SELECT id_cliente FROM proyectos)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clientesTodos()
    {
        $sql = "SELECT id_cliente, nombre_empresa FROM clientes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
