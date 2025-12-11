<?php
require_once __DIR__ . '/../datos/DB.php';

class Empleado
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    public function Insertar(
        int $usuario_id,
        string $nombre,
        string $apellido,
        ?string $correo,
        ?string $telefono,
        ?string $cargo
    ): void {

        // Validación: evitar usuario duplicado
        $check = $this->db->prepare("SELECT COUNT(*) FROM empleado WHERE usuario_id = ?");
        $check->execute([$usuario_id]);

        if ($check->fetchColumn() > 0) {
            throw new Exception("El ID de usuario ya está asignado a otro empleado.");
        }

        $sql = "INSERT INTO empleado 
                (usuario_id, nombre, apellido, correo, telefono, cargo)
                VALUES (?, ?, ?, ?, ?, ?)";

        $this->db->prepare($sql)->execute([
            $usuario_id,
            $nombre,
            $apellido,
            $correo,
            $telefono,
            $cargo
        ]);
    }

    public function Mostrar(): array
    {
        return $this->db->query("
            SELECT e.*, u.nombre_usuario
            FROM empleado e
            LEFT JOIN usuarios u ON e.usuario_id = u.id_usuario
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function ObtenerUsuariosDisponibles(): array
    {
        $sql = "SELECT u.id_usuario, u.nombre_usuario   
                FROM usuarios u
                LEFT JOIN empleado e ON u.id_usuario = e.usuario_id
                WHERE e.usuario_id IS NULL";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function BuscarID(int $id): ?array
    {
        $sql = $this->db->prepare("SELECT * FROM empleado WHERE id_empleado = ?");
        $sql->execute([$id]);

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
    public function Actualizar(
        int $id,
        int $usuario_id,
        string $nombre,
        string $apellido,
        ?string $correo,
        ?string $telefono,
        ?string $cargo
    ): void {

        // Validación: evitar usuario duplicado (excepto el del mismo empleado)
        $check = $this->db->prepare("
            SELECT COUNT(*) 
            FROM empleado 
            WHERE usuario_id = ? AND id_empleado != ?
        ");
        $check->execute([$usuario_id, $id]);

        if ($check->fetchColumn() > 0) {
            throw new Exception("Ese usuario ya está asignado a otro empleado.");
        }

        $sql = "UPDATE empleado 
                SET usuario_id = ?, nombre = ?, apellido = ?, correo = ?, telefono = ?, cargo = ?
                WHERE id_empleado = ?";

        $this->db->prepare($sql)->execute([
            $usuario_id,
            $nombre,
            $apellido,
            $correo,
            $telefono,
            $cargo,
            $id
        ]);
    }
    public function Borrar(int $id): void
    {
        $sql = $this->db->prepare("DELETE FROM empleado WHERE id_empleado = ?");
        $sql->execute([$id]);
    }
}
