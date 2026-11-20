<?php

    require_once __DIR__ . '/../../config/modelbase/conexao.php';

    class ModelHome
    {
        private $conn;

        public function __construct(){
            global $conn;
            $this->conn = $conn;
        }

        public function contarClientes(){
            $res = $this->conn->query("SELECT COUNT(*) AS total FROM clientes WHERE ativo = 1 ");
            return $res->fetch()['total'];
        }

        public function contarProdutos(){
            $res = $this->conn->query("SELECT COUNT(*) AS total FROM produtos WHERE ativo = '1' ");
            return $res->fetch()['total'];
        }

        public function somarVendas(){
            $res = $this->conn->query("SELECT SUM(total) as soma FROM pedidos WHERE status = 'concluido' ");
            $row = $res->fetch();
            return $row['soma'] ?? 0; //Retorna 0 se ainda não houver vendas concluidas
        }

        public function estoqueBaixo($limite = 10){
            $stmt = $this->conn->prepare("SELECT codigo, nome, estoque FROM produtos WHERE ativo = 1 AND tipo = 'produto' AND estoque < ? ORDER BY estoque ASC LIMIT 5");
            $stmt->execute([$limite]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
