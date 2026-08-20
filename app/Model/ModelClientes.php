<?php 

    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelClientes {

        private $conn;


        public function __construct() {
            global $conn;
            $this->conn = $conn;
        }
        
        // Busca todos os clientes
        public function buscarTodos() {
            $res = $this->conn->query("SELECT id, nome, cpf_cnpj, telefone, email, endereco, cidade, estado, cep FROM clientes ORDER BY nome");
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

        // Busca cliente pelo ID
        public function buscarPorId($id) {
            $stmt = $this->conn->prepare("SELECT id, nome, cpf_cnpj, telefone, email, endereco, cidade, estado, cep FROM clientes WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Insere novo cliente no Banco
        public function cadastrar($nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep) {
            $stmt = $this->conn->prepare("INSERT INTO clientes (nome, cpf_cnpj, telefone, email, endereco, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep]);
        }

        // Atualiza os dados de um cliente existente
        public function atualizar($id, $nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep) {
            $stmt = $this->conn->prepare("UPDATE clientes SET nome = ?, cpf_cnpj = ?, telefone = ?, email = ?, endereco = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?");
            return $stmt->execute([$nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep, $id]);
        }

        // Remove um cliente do Banco
        public function excluir($id) {
            $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->execute([$id]);
        }

    }