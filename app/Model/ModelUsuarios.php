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
            return $res->fetch_all(MYSQLI_ASSOC);
        }

        public function buscarPorId($id){
            $stmt = $this->conn->prepare("SELECT id, nome, email, tipo_usuario, ativo FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function cadastrar($nome, $email, $senha, $tipo_usuario){
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
            $stmt ->bind_param("sssi", $nome, $email, $senha, $tipo_usuario);
            return $stmt->execute();
        }

        public function editar($id, $nome, $email, $senha, $tipo_usuario){
            if($senha){
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ?, tipo_usuario = ? WHERE id= ?");
                $stmt->bind_param("ssii", $nome, $email, $senha, $tipo_usuario, $id);
            } else{
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, tipo_usuario = ? WHERE id= ?");
                $stmt->bind_param("ssii", $nome, $email, $tipo_usuario, $id);
            }
            return $stmt->execute();
        }

        public function excluir($id){
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }

?>