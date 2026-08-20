<?php

    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelPedidos{

        private $conn;

        public function __construct() {
            global $conn;
            $this->conn = $conn;
        }

        public function cancelarPedido($id) {
        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare("SELECT status FROM pedidos WHERE id = ? FOR UPDATE");
            $stmt->execute([$id]);
            $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$pedido || $pedido['status'] === 'cancelado') {
                $this->conn->rollBack();
                return false;
            }

            $stmt2 = $this->conn->prepare("
                UPDATE produtos p
                JOIN pedido_itens pi ON p.id = pi.produto_id
                SET p.estoque = p.estoque + pi.quantidade
                WHERE pi.pedido_id = ?
            ");
            $stmt2->execute([$id]);

            $stmt3 = $this->conn->prepare("UPDATE pedidos SET status = 'cancelado' WHERE id = ?");
            $stmt3->execute([$id]);

            $this->conn->commit();
            return true;

            } catch (PDOException $e) {
                $this->conn->rollBack();
                throw $e;
            }
        }

        public function concluirPedido($id){
            $stmt = $this->conn->prepare("UPDATE pedidos SET status = 'concluido' WHERE id = ?");
            return $stmt->execute([$id]);
        }

        public function buscarTodos() {
            $stmt = $this->conn->query("SELECT id, cliente_id, atualizado_em, total FROM pedidos ORDER BY atualizado_em DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarPorId($id) {
            $stmt = $this->conn->prepare("SELECT id, cliente_id, atualizado_em, total FROM pedidos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function cadastrarPedido($cliente_id, $usuario_id, $status, $observacoes, $total) {
            $stmt = $this->conn->prepare("INSERT INTO pedidos (cliente_id, usuario_id, status, observacoes, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$cliente_id, $usuario_id, $status, $observacoes, $total]);
        }

        public function atualizarPedido($id, $status, $observacoes, $total) {
            $stmt = $this->conn->prepare("UPDATE pedidos SET status = ?, observacoes = ?, total = ? WHERE id = ?");
            return $stmt->execute([$status, $observacoes, $total, $id]);
        }
    }