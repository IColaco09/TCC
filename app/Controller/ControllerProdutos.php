<?php

    require_once __DIR__.'/../Model/ModelProdutos.php';
    require_once __DIR__ . '/../../config/Auth.php';
    require_once __DIR__ . '/../../config/prg.php';

    class ControllerProdutos{
        private $model;

        public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
            }

            if (!isset($_SESSION['id'])) {
                header("Location: login");
                exit;
            }

            permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

            $this->model = new ModelProdutos();
        }

        public function produtos() {
            $sucesso = '';
            $erro = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrfValido()) {
                definirMensagem('erro', 'Requisição inválida. Tente novamente.');
                redirecionarPRG('produtos');
            }

            // CADASTRAR
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
                $nome = trim($_POST['nome']);
                $codigo = intval($_POST['codigo']);
                $preco = floatval($_POST['preco']);
                $estoque = intval($_POST['estoque']);
                $tipo = intval($_POST['tipo_produto']);
                $descricao = trim($_POST['descricao']);

                $resultado = $this->model->cadastrarProduto($nome, $codigo, $preco, $descricao, $estoque, $tipo);

                if ($resultado['sucesso']) {
                    definirMensagem('sucesso', "Produto cadastrado com sucesso!");
                } elseif ($resultado['erro'] === 'duplicado') {
                    definirMensagem('erro', "Já existe um produto com esse código.");
                } else {
                    definirMensagem('erro', "Erro ao cadastrar produto.");
                }

                redirecionarPRG('produtos');
            }

            // CADASTRAR TIPO
            if($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrarTipo'){
                $nome = trim($_POST['nomeTipo']);
                $desc = trim($_POST['desc']);

                if ($this->model->cadastrarTipo($nome, $desc)) {
                    definirMensagem('sucesso', "Tipo Cadastrado com Sucesso!");
                } else{
                    definirMensagem('erro', "Erro ao cadastrar Tipo de Produto");
                }

                redirecionarPRG('produtos');
            }

            // BUSCAR TIPO
            $categorias = $this->model->listarTipos();

            // EDITAR
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'editar') {
                $codigo = intval($_POST['codigo']);
                $nome = trim($_POST['nome']);   
                $preco = floatval($_POST['preco']);
                $estoque = intval($_POST['estoque']);
                $tipo = intval($_POST['tipo_produto']);
                $descricao = trim($_POST['descricao']);

                if($this->model->editarProduto($nome, $preco, $descricao, $estoque, $tipo, $codigo)){
                    definirMensagem('sucesso', "Produto atualizado com sucesso!");
                } else {
                    definirMensagem('erro', "Erro ao atualizar produto.");
                }

                redirecionarPRG('produtos');
            }

            // EXCLUIR
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
                $codigo = intval($_POST['codigo'] ?? 0);
                try {
                    if($this->model->excluirProduto($codigo)){
                        definirMensagem('sucesso', "Produto excluído com sucesso!");
                    } else {
                        definirMensagem('erro', "Erro ao excluir produto.");
                    }
                } catch (PDOException $e) {
                    definirMensagem('erro', "Não foi possível excluir: o produto está em pedidos.");
                }

                redirecionarPRG('produtos');
            }

            // BUSCAR
            $produto_buscar = null;
            if (isset($_GET['buscar'])) {
                $produto_buscar = $this->model->buscarPorCodigo(intval($_GET['buscar']));
            }

            $busca = trim($_GET['busca'] ?? '');
            $produtos = $this->model->listarProdutos($busca);
            require_once __DIR__.'/../View/Produtos/index.php';
        }
    }
