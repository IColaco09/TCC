<?php 
    require_once __DIR__.'/../../config/modelbase/conexao.php';

    class ModelProdutos{
        private $conn;

        public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

        public function listarProdutos(){
            $sql = "SELECT * FROM produtos";
            $res = $this->conn->query($sql);
            return $res->fetch_all(MYSQLI_ASSOC);
        }

        public function addProduto($nome, $codigo, $preco, $estoque, $tipo){
            $stmt = $this->conn->prepare("INSERT INTO produtos (nome, codigo, preco, estoque, tipo) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdii", $nome, $codigo, $preco, $estoque, $tipo);
            return $stmt->execute();
        }

        public function editarProduto($nome, $preco, $estoque, $tipo, $codigo){
            $stmt = $this->conn->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ?, tipo = ? WHERE codigo = ?");
            $stmt->bind_param("sdiii", $nome, $preco, $estoque, $tipo, $codigo);
            return $stmt->execute();
        }

        public function excluirProduto($codigo){
            $stmt = $this->conn->prepare("DELETE FROM produtos WHERE codigo = ?");
            $stmt->bind_param("i", $codigo);
            return $stmt->execute();
        }

    }