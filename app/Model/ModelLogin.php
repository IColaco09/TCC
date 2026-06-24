<?php
require_once __DIR__ . '/../../config/modelbase/conexao.php';

class ModelLogin {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function procurarUsuario($usuario) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}