<?php
// app/dao/UsuarioDAO.php

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Busca un usuario por su username (para el login)
    public function buscarPorUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username AND estado = 'ACTIVO'");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }

    // NUEVO: Crear un usuario con contraseña encriptada
    public function crear($nombre_completo, $username, $password, $rol = 'VENDEDOR') {
        // Encriptamos la contraseña de forma segura
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre_completo, username, password_hash, rol) 
                VALUES (:nombre_completo, :username, :password_hash, :rol)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre_completo' => $nombre_completo,
            ':username'        => $username,
            ':password_hash'   => $password_hash,
            ':rol'             => $rol
        ]);
    }
}
?>