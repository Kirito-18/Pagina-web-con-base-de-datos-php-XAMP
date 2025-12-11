<?php
require_once __DIR__ . '/../datos/DB.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    // Registrar usuario
    public function InsertarUsuario(string $nombre_usuario, string $passwordHash, string $rol): bool
    {
        $sql = "INSERT INTO usuarios (nombre_usuario, password, rol, estado)
                VALUES (?, ?, ?, 'activo')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre_usuario, $passwordHash, $rol]);
    }

    // Obtener usuario por nombre (para login)
    public function ObtenerPorNombre(string $nombre_usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ver todos los usuarios
    public function Listar()
    {
        $sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
