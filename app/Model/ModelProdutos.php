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
    }
