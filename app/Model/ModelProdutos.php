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

        public function cadastrarTipo($nome, $desc){
            $stmt = $this->conn->prepare("INSERT INTO categorias (nome, descricao) VALUES (?, ?)");
            $stmt->bind_param("ss", $nome, $desc);
            return $stmt->execute();
        }


        public function cadastrarProduto($nome, $codigo, $preco, $descricao, $estoque, $tipo){
            $stmt = $this->conn->prepare("INSERT INTO produtos (nome, codigo, preco, descricao, estoque, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsis", $nome, $codigo, $preco, $descricao, $estoque, $tipo);
            return $stmt->execute();
        }

        public function listarTipos(){
            $res = $this->conn->query("SELECT id, nome FROM categorias");
            return $res->fetch_all(MYSQLI_ASSOC);
        }

        public function editarProduto($nome, $preco, $descricao, $estoque, $tipo, $codigo){
            $stmt = $this->conn->prepare("UPDATE produtos SET nome = ?, preco = ?, descricao = ?, estoque = ?, categoria_id = ? WHERE codigo = ?");
            $stmt->bind_param("sdsii", $nome, $preco, $descricao, $estoque, $tipo, $codigo);
            return $stmt->execute();
        }

        public function excluirProduto($codigo){
            $stmt = $this->conn->prepare("DELETE FROM produtos WHERE codigo = ?");
            $stmt->bind_param("i", $codigo);
            return $stmt->execute();
        }

        public function buscarPorCodigo($codigo){
            $stmt = $this->conn->prepare("SELECT codigo, nome, preco, descricao, estoque, tipo FROM produtos WHERE codigo = ?");
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }