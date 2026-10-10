<?php
    require_once __DIR__ . '/../Model/ModelPedido.php';
    require_once __DIR__ . '/../Model/ModelClientes.php';
    require_once __DIR__ . '/../Model/ModelProdutos.php';
    require_once __DIR__ . '/../../config/modelbase/conexao.php'; 
    require_once __DIR__ . '/../../config/Auth.php';
    require_once __DIR__ . '/../../config/prg.php';

    class ControllerPedidos {
        private $model;
        private $modelClientes;
        private $modelProdutos;

        public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
            }

            if (!isset($_SESSION['id'])) {
                header("Location: login");
                exit;
            }

            permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

            $this->model = new ModelPedidos();
            $this->modelClientes = new ModelClientes();
            $this->modelProdutos = new ModelProdutos();
        }

        public function pedidos() {
            $sucesso = '';
            $erro = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrfValido()) {
                definirMensagem('erro', 'Requisição inválida. Tente novamente.');
                redirecionarPRG('pedidos');
            }

            // CADASTRAR — POST acao=cadastrar
            // Campos: cliente_id, observacoes (opcional), produto_id[], quantidade[], preco_unit[]
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
                $cliente_id  = intval($_POST['cliente_id'] ?? 0);
                $observacoes = trim($_POST['observacoes'] ?? '');
                $produtos_ids = $_POST['produto_id'] ?? [];
                $quantidades  = $_POST['quantidade'] ?? [];
                $precos       = $_POST['preco_unit'] ?? [];
                $itens = [];
                foreach ($produtos_ids as $i => $produto_id) {
                    $qtd   = intval($quantidades[$i] ?? 0);
                    $preco = floatval($precos[$i] ?? 0);
                    if ($produto_id && $qtd > 0) {
                        $itens[] = [
                            'produto_id' => intval($produto_id),
                            'quantidade' => $qtd,
                            'preco_unit' => $preco,
                        ];
                    }
                }

                try {
                    $pedido_id = $this->model->cadastrarPedido(
                        $cliente_id,
                        $_SESSION['id'],
                        $itens,
                        $observacoes !== '' ? $observacoes : null
                    );
                    definirMensagem('sucesso', "Pedido #$pedido_id cadastrado com sucesso!");
                } catch (\Throwable $e) {
                    definirMensagem('erro', "Erro ao cadastrar pedido: " . $e->getMessage());
                }

                redirecionarPRG('pedidos');
            }

            // CONCLUIR — POST acao=concluir
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'concluir') {
                $id = intval($_POST['id'] ?? 0);
                if ($this->model->concluirPedido($id)) {
                    definirMensagem('sucesso', "Pedido concluído com sucesso!");
                } else {
                    definirMensagem('erro', "Erro ao concluir pedido.");
                }

                redirecionarPRG('pedidos');
            }

            // CANCELAR — POST acao=cancelar
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cancelar') {
                $id = intval($_POST['id'] ?? 0);
                try {
                    if ($this->model->cancelarPedido($id)) {
                        definirMensagem('sucesso', "Pedido cancelado com sucesso!");
                    } else {
                        definirMensagem('erro', "Pedido já estava cancelado ou não existe.");
                    }
                } catch (\Throwable $e) {
                    definirMensagem('erro', "Erro ao cancelar pedido: " . $e->getMessage());
                }

                redirecionarPRG('pedidos');
            }

            $busca    = trim($_GET['busca'] ?? '');
            $pedidos  = $this->model->buscarTodos($busca);
            $clientes = $this->modelClientes->buscarTodos();
            $produtos = $this->modelProdutos->listarProdutos();

            require_once __DIR__ . '/../View/Pedidos/index.php';
        }
    }
