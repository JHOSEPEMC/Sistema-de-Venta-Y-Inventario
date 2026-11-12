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
        return $stmt->fetch(); // Retorna el array asociativo o false
    }
}
?>