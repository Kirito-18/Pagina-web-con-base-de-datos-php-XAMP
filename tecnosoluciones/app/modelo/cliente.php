<?php
require_once __DIR__ . '/../datos/DB.php';

class Cliente
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    public function Insertar(
        int $usuario_id,
        string $nombre_empresa,
        ?string $representante,
        ?string $correo,
        ?string $telefono,
        ?string $direccion
    ): void {

        // Validación: evitar usuarios duplicados
        $check = $this->db->prepare("
            SELECT COUNT(*) 
            FROM clientes
            WHERE usuario_id = ?
        ");
        $check->execute([$usuario_id]);

        if ($check->fetchColumn() > 0) {
            throw new Exception("El usuario ya está asignado a otro cliente.");
        }

        // Validación correo repetido
        if (!empty($correo)) {
            $checkCorreo = $this->db->prepare("
                SELECT COUNT(*) 
                FROM clientes
                WHERE correo = ?
            ");
            $checkCorreo->execute([$correo]);

            if ($checkCorreo->fetchColumn() > 0) {
                throw new Exception("El correo ya está registrado para otro cliente.");
            }
        }

        $sql = "INSERT INTO clientes
                (usuario_id, nombre_empresa, representante, correo, telefono, direccion) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $this->db->prepare($sql)->execute([
            $usuario_id,
            $nombre_empresa,
            $representante,
            $correo,
            $telefono,
            $direccion
        ]);
    }

    public function Mostrar(): array
    {
        return $this->db->query("
            SELECT c.*, u.nombre_usuario
            FROM clientes c
            LEFT JOIN usuarios u ON c.usuario_id = u.id_usuario
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

public function ObtenerUsuariosDisponibles(): array
{
    $sql = "
        SELECT u.id_usuario, u.nombre_usuario
        FROM usuarios u
        WHERE u.id_usuario NOT IN (
            SELECT usuario_id FROM clientes
            UNION
            SELECT usuario_id FROM empleado
        )
        ORDER BY u.id_usuario ASC
    ";

    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}




public function BuscarID(int $id): ?array
{
    $sql = $this->db->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
    $sql->execute([$id]);

    $row = $sql->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

    public function Actualizar(
        int $id,
        int $usuario_id,
        string $nombre_empresa,
        ?string $representante,
        ?string $correo,
        ?string $telefono,
        ?string $direccion
    ): void {

        // Validación usuario repetido (excepto el mismo cliente)
        $check = $this->db->prepare("
            SELECT COUNT(*) 
            FROM clientes
            WHERE usuario_id = ? AND id_cliente != ?
        ");
        $check->execute([$usuario_id, $id]);

        if ($check->fetchColumn() > 0) {
            throw new Exception("Ese usuario ya está asignado a otro cliente.");
        }

        // Validación correo único
        if (!empty($correo)) {
            $checkCorreo = $this->db->prepare("
                SELECT COUNT(*) 
                FROM clientes
                WHERE correo = ? AND id_cliente != ?
            ");
            $checkCorreo->execute([$correo, $id]);

            if ($checkCorreo->fetchColumn() > 0) {
                throw new Exception("Ese correo ya pertenece a otro cliente.");
            }
        }

        $sql = "UPDATE clientes
                SET usuario_id = ?, 
                    nombre_empresa = ?, 
                    representante = ?, 
                    correo = ?, 
                    telefono = ?, 
                    direccion = ?
                WHERE id_cliente = ?";

        $this->db->prepare($sql)->execute([
            $usuario_id,
            $nombre_empresa,
            $representante,
            $correo,
            $telefono,
            $direccion,
            $id
        ]);
    }

    public function Borrar(int $id): void
    {
        $sql = $this->db->prepare("DELETE FROM clientes WHERE id_cliente = ?");
        $sql->execute([$id]);
    }
}
