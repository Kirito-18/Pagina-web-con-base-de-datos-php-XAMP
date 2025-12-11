<?php
require_once __DIR__ . '/../modelo/Usuario.php';

class UsuarioControlador
{
    private Usuario $model;

    public function __construct()
    {
        $this->model = new Usuario();
    }

    public function Procesar()
    {
        if (isset($_POST['accion_usuario']) && $_POST['accion_usuario'] === 'registrar') {

            $nombre = $_POST['nombre_usuario'];
            $passwordPlano = $_POST['password'];
            $rol = $_POST['rol'];

            // Encriptar la contraseña
            $passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);

            // Insertar el usuario
            $this->model->InsertarUsuario($nombre, $passwordHash, $rol);

            // Redirigir al panel de empleados
            header("Location: panelempleados.php");
            exit;
        }

        return [];
    }
}
