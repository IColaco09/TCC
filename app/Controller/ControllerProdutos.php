<?php

    require_once __DIR__.'/../Model/ModelProdutos.php';

    class ControllerProdutos{
        private $model;

        public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
            }

            if (!isset($_SESSION['id'])) {
                header("Location: ?url=login");
                exit;
            }

            permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

            $this->model = new ModelProdutos();
        }

        public function produtos() {
            $sucesso = '';
            $erro = '';

            // CADASTRAR
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
                $nome = trim($_POST['nome']);
                $codigo = intval($_POST['codigo']);
                $preco = floatval($_POST['preco']);
                $estoque = intval($_POST['estoque']);
                $tipo = intval($_POST['tipo_produto']);
                $descricao = trim($_POST['descricao']);

                if($this->model->cadastrarProduto($nome, $codigo, $preco, $descricao, $estoque, $tipo)) {
                    $sucesso = "Produto cadastrado com sucesso!";
                } else {
                    $erro = "Erro ao cadastrar produto.";
                }
            }

            // CADASTRAR TIPO
            if($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrarTipo'){
                $nome = trim($_POST['nomeTipo']);
                $desc = trim($_POST['desc']);

                if ($this->model->cadastrarTipo($nome, $desc)) {
                    $sucesso = "Tipo Cadastrado com Sucesso!";
                } else{
                    $erro = "Erro ao cadastrar Tipo de Produto";
                }
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
                    $sucesso = "Produto atualizado com sucesso!";
                } else {
                    $erro = "Erro ao atualizar produto.";
                }
            }

            // EXCLUIR
            if (isset($_GET['excluir'])) {
                $codigo = intval($_GET['excluir']);
                if($this->model->excluirProduto($codigo)){
                    $sucesso = "Produto excluído com sucesso!";
                } else {
                    $erro = "Erro ao excluir produto.";
                }
            }

            // BUSCAR
            $produto_buscar = null;
            if (isset($_GET['buscar'])) {
                $produto_buscar = $this->model->buscarPorCodigo(intval($_GET['buscar']));
            }

            $produtos = $this->model->listarProdutos();
            require_once __DIR__.'/../View/Produtos/index.php';
        }
    }