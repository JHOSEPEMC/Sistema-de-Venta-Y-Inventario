<?php
class UsuarioDAO {
    private $db;
    public function __construct() { $this->db = Database::getConnection(); }
    public function buscarPorUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username AND estado = 'ACTIVO'");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
    public function crear($nombre_completo, $username, $password, $rol = 'VENDEDOR') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre_completo, username, password_hash, rol) VALUES (:nombre, :user, :pass, :rol)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nombre' => $nombre_completo, ':user' => $username, ':pass' => $hash, ':rol' => $rol]);
    }
}