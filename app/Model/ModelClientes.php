<?php 

    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelClientes {

        private $conn;


        public function __construct() {
            global $conn;
            $this->conn = $conn;
        }
        
        // Busca todos os clientes (filtra por nome, CPF/CNPJ, telefone ou email)
        public function buscarTodos($busca = '') {
            $like = "%$busca%";
            $stmt = $this->conn->prepare("SELECT id, nome, cpf_cnpj, telefone, email, endereco, cidade, estado, cep FROM clientes WHERE nome LIKE ? OR cpf_cnpj LIKE ? OR telefone LIKE ? OR email LIKE ? ORDER BY nome");
            $stmt->execute([$like, $like, $like, $like]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Busca cliente pelo ID
        public function buscarPorId($id) {
            $stmt = $this->conn->prepare("SELECT id, nome, cpf_cnpj, telefone, email, endereco, cidade, estado, cep FROM clientes WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Insere novo cliente no Banco
        public function cadastrar($nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep) {
            try{$stmt = $this->conn->prepare("INSERT INTO clientes (nome, cpf_cnpj, telefone, email, endereco, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep]);
            return ['sucesso' => true];
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    return ['sucesso' => false, 'erro' => 'duplicado'];
                }
                throw $e;
            }
            
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
