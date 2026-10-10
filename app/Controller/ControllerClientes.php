<?php

require_once __DIR__ . '/../../config/Auth.php';
require_once __DIR__ . '/../../config/prg.php';
require_once __DIR__ . '/../Model/ModelClientes.php';

class ControllerClientes
{

    private $model;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
        }

        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }

        permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

        $this->model = new ModelClientes();
    }


    public function clientes()
    {

        $sucesso = '';
        $erro = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrfValido()) {
                definirMensagem('erro', 'Requisição inválida. Tente novamente.');
                redirecionarPRG('clientes');
            }


        //Cadastro de cliente
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
            $nome = trim($_POST['nome']);
            $cpf_cnpj = trim($_POST['cpf_cnpj']);
            $telefone = trim($_POST['telefone']);
            $email = trim($_POST['email']);
            $endereco = trim($_POST['endereco']);
            $cidade = trim($_POST['cidade']);
            $estado = trim($_POST['estado']);
            $cep = trim($_POST['cep']);

            $resultado = $this->model->cadastrar($nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep);

            if ($resultado['sucesso']){
                definirMensagem('sucesso', "Cliente cadastrado com sucesso!");
            } elseif ($resultado['erro'] === 'duplicado') {
                definirMensagem('erro', "Já existe um cliente com esse CPF/CNPJ.");
            } else {
                definirMensagem('erro', "Erro ao cadastrar cliente.");
            }

            redirecionarPRG('clientes');
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'editar') {
            $id = intval($_POST['id']);
            $nome = trim($_POST['nome']);
            $cpf_cnpj = trim($_POST['cpf_cnpj']);
            $telefone = trim($_POST['telefone']);
            $email = trim($_POST['email']);
            $endereco = trim($_POST['endereco']);
            $cidade = trim($_POST['cidade']);
            $estado = trim($_POST['estado']);
            $cep = trim($_POST['cep']);

            if ($this->model->atualizar($id, $nome, $cpf_cnpj, $telefone, $email, $endereco, $cidade, $estado, $cep )) {
                definirMensagem('sucesso', "Cliente atualizado com sucesso!");
            } else {
                definirMensagem('erro', "Erro ao atualizar cliente.");
            }
            redirecionarPRG('clientes');
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
            $id = intval($_POST['id'] ?? 0);

            try {
                $this->model->excluir($id);
                definirMensagem('sucesso', "Cliente excluído com sucesso!");
            } catch (PDOException $e) {
                definirMensagem('erro', "Não foi possível excluir: o cliente possui pedidos.");
            }

            redirecionarPRG('clientes');
        }

        $cliente_editar = null;
        if (isset($_GET['editar'])) {
            $cliente_editar = $this->model->buscarPorId(intval($_GET['editar']));
        }

        $busca = trim($_GET['busca'] ?? '');
        $clientes = $this->model->buscarTodos($busca);

        include __DIR__ . '/../View/Clientes/index.php';
    }
}
