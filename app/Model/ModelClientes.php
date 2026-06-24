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
        $res = $this->conn->query("SELECT id, nome, cpf_cnpj, telefone, email FROM clientes ORDER BY nome");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    // Busca cliente pelo ID
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT id, nome, cpf_cnpj, telefone, email FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Insere novo cliente no Banco
    public function cadastrar($nome, $cpf_cnpj, $telefone, $email) {
        $stmt = $this->conn->prepare("INSERT INTO clientes (nome, cpf_cnpj, telefone, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $cpf_cnpj, $telefone, $email);
        return $stmt->execute();
    }

    // Atualiza os dados de um cliente existente
    public function atualizar($id, $nome, $cpf_cnpj, $telefone, $email) {
        $stmt = $this->conn->prepare("UPDATE clientes SET nome = ?, cpf_cnpj = ?, telefone = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $cpf_cnpj, $telefone, $email, $id);
        return $stmt->execute();
    }

    // Remove um cliente do Banco
    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

}