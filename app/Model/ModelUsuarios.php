<?php 

    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelUsuarios{
        private $conn;

        public function __construct(){
            global $conn;
            $this->conn = $conn;
        }
        public function listar(){
            $res = $this->conn->query("SELECT id, nome, email, tipo_usuario, ativo FROM usuarios ORDER BY nome");
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarPorId($id){
            $stmt = $this->conn->prepare("SELECT id, nome, email, tipo_usuario, ativo FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function cadastrar($nome, $email, $senha, $tipo_usuario){
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$nome, $email, $senhaHash, $tipo_usuario]);
        }

        public function editar($id, $nome, $email, $senha, $ativo, $tipo_usuario){
            if($senha){
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, ativo = ?, tipo_usuario = ? WHERE id= ?");
                return $stmt->execute([$nome, $email, $senhaHash, $ativo, $tipo_usuario, $id]);
            } else{
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, ativo = ?, tipo_usuario = ? WHERE id= ?");
                return $stmt->execute([$nome, $email, $ativo, $tipo_usuario, $id]);
            }
        }

        public function excluir($id){
            $stmt = $this->conn->prepare("UPDATE usuarios SET ativo = 0 WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }