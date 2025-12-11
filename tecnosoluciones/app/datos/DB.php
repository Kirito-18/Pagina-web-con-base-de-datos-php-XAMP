<?php
// app/config/DB.php

class DB
{
    public static function getConnection(): PDO 
    {
        try {
            return new PDO(
                'mysql:host=localhost; dbname=tecnosoluciones_db; charset=utf8mb4',
                'root',
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
