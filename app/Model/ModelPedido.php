    <?php
    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelPedidos {

        private $conn;

        public function __construct() {
            global $conn;
            $this->conn = $conn;
        }

        public function buscarTodos() {
            $stmt = $this->conn->query("
                SELECT
                    p.id,
                    c.nome AS cliente_nome,
                    p.status,
                    p.total,
                    p.atualizado_em,
                    GROUP_CONCAT(CONCAT(pi.quantidade, 'x ', pr.nome) SEPARATOR ', ') AS itens_resumo
                FROM pedidos p
                JOIN clientes c ON c.id = p.cliente_id
                LEFT JOIN pedido_itens pi ON pi.pedido_id = p.id
                LEFT JOIN produtos pr ON pr.id = pi.produto_id
                GROUP BY p.id
                ORDER BY p.atualizado_em DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscarPorId($id) {
            $stmt = $this->conn->prepare("SELECT id, cliente_id, atualizado_em, total FROM pedidos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function buscarItensPorPedido($pedido_id) {
            $stmt = $this->conn->prepare("
                SELECT pi.produto_id, p.nome, pi.quantidade, pi.preco_unit, pi.subtotal
                FROM pedido_itens pi
                JOIN produtos p ON p.id = pi.produto_id
                WHERE pi.pedido_id = ?
            ");
            $stmt->execute([$pedido_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cadastrarPedido($cliente_id, $usuario_id, array $itens, $observacoes = null) {
            // $itens = [ ['produto_id' => 1, 'quantidade' => 2, 'preco_unit' => 10.50], ... ]

            if (empty($itens)) {
                throw new InvalidArgumentException('Pedido precisa de pelo menos um item.');
            }

            $this->conn->beginTransaction();

            try {
                // total calculado a partir dos itens, não confia em valor vindo de fora
                $total = 0;
                foreach ($itens as $item) {
                    $total += $item['quantidade'] * $item['preco_unit'];
                }

                $stmt = $this->conn->prepare("
                    INSERT INTO pedidos (cliente_id, usuario_id, status, observacoes, total)
                    VALUES (?, ?, 'aberto', ?, ?)
                ");
                $stmt->execute([$cliente_id, $usuario_id, $observacoes, $total]);
                $pedido_id = $this->conn->lastInsertId();

                $stmtItem = $this->conn->prepare("
                    INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unit)
                    VALUES (?, ?, ?, ?)
                ");
                // desconta estoque só se tiver saldo suficiente (checagem atômica no próprio WHERE)
                $stmtEstoque = $this->conn->prepare("
                    UPDATE produtos SET estoque = estoque - ? WHERE id = ? AND estoque >= ?
                ");

                foreach ($itens as $item) {
                    $stmtItem->execute([$pedido_id, $item['produto_id'], $item['quantidade'], $item['preco_unit']]);

                    $stmtEstoque->execute([$item['quantidade'], $item['produto_id'], $item['quantidade']]);
                    if ($stmtEstoque->rowCount() === 0) {
                        throw new RuntimeException("Estoque insuficiente para o produto ID {$item['produto_id']}.");
                    }
                }

                $this->conn->commit();
                return $pedido_id;

            } catch (\Throwable $e) {
                $this->conn->rollBack();
                throw $e;
            }
        }

        public function atualizarPedido($id, $status, $observacoes, $total) {
            $stmt = $this->conn->prepare("UPDATE pedidos SET status = ?, observacoes = ?, total = ? WHERE id = ?");
            return $stmt->execute([$status, $observacoes, $total, $id]);
        }

        public function concluirPedido($id) {
            $stmt = $this->conn->prepare("
                UPDATE pedidos
                SET status = 'concluido'
                WHERE id = ? AND status NOT IN ('cancelado', 'concluido')
            ");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
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
    }