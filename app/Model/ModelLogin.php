<?php

    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelLogin {

        private $conn;

        public function __construct() {
            global $conn;
            $this->conn = $conn;
        }

        public function procurarUsuario($usuario) {
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ? AND ativo = 1");
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function tentativasRecentes($email, $ip) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM login_tentativas WHERE email = ? AND ip = ? AND criado_em > NOW() - INTERVAL 15 MINUTE");
        $stmt->execute([$email, $ip]);
        return (int)$stmt->fetchColumn();
        }

        public function registrarFalha($email, $ip) {
            $this->conn->prepare("DELETE FROM login_tentativas WHERE criado_em < NOW() - INTERVAL 1 DAY")->execute();
            $this->conn->prepare("INSERT INTO login_tentativas (email, ip) VALUES (?, ?)")->execute([$email, $ip]);
        }

        public function limparFalhas($email, $ip) {
            $this->conn->prepare("DELETE FROM login_tentativas WHERE email = ? AND ip = ?")->execute([$email, $ip]);
        }
    }