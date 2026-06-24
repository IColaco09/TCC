<?php

require_once __DIR__ . '/../../config/modelbase/conexao.php';

class ModelPedidos{

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function cancelarPedido($this, $codigo){
        $this->beginTransaction();
        
        try{
            $stmt = $this->conn->prepare("
            UPDATE produtos p
            JOIN pedido_itens pi ON p.id = pi.produto_id
            SET p.estoque = p.estoque + pi.quantidade
            WHERE pi.pedido_id = ?
            ");

            $stmt->bind_param("");
        }
    }

    public function concluirPedido(){
        $stmt = $this->conn->prepare("UPDATE pedidos SET status = 'concluido' WHERE id = ?");
        return $stmt->execute();
    }

    public function buscarTodos() {
        $stmt = $this->conn->query("SELECT id, cliente_id, atualizado_em, total FROM pedidos ORDER BY atualizado_em DESC");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT id, cliente_id, atualizado_em, total FROM pedidos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function cadastrarPedido($cliente_id, $usuario_id, $status, $observacoes, $total) {
        $stmt = $this->conn->prepare("INSERT INTO pedidos (cliente_id, usuario_id, status, observacoes, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissd", $cliente_id, $usuario_id, $status, $observacoes, $total);
        return $stmt->execute();
    }

    public function atualizar
}