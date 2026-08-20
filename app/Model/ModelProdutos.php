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
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cadastrarTipo($nome, $desc){
            $stmt = $this->conn->prepare("INSERT INTO categorias (nome, descricao) VALUES (?, ?)");
            return $stmt->execute([$nome, $desc]);
        }


        public function cadastrarProduto($nome, $codigo, $preco, $descricao, $estoque, $tipo){
            $stmt = $this->conn->prepare("INSERT INTO produtos (nome, codigo, preco, descricao, estoque, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nome, $codigo, $preco, $descricao, $estoque, $tipo]);
        }

        public function listarTipos(){
            $res = $this->conn->query("SELECT id, nome FROM categorias");
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

        public function editarProduto($nome, $preco, $descricao, $estoque, $tipo, $codigo){
            $stmt = $this->conn->prepare("UPDATE produtos SET nome = ?, preco = ?, descricao = ?, estoque = ?, categoria_id = ? WHERE codigo = ?");
            return $stmt->execute([$nome, $preco, $descricao, $estoque, $tipo, $codigo]);
        }

        public function excluirProduto($codigo){
        $stmt = $this->conn->prepare("DELETE FROM produtos WHERE codigo = ?");
        return $stmt->execute([$codigo]); 
        }

        public function buscarPorCodigo($codigo){
            $stmt = $this->conn->prepare("SELECT codigo, nome, preco, descricao, estoque, tipo FROM produtos WHERE codigo = ?");
            $stmt->execute([$codigo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }