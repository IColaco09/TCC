<?php
    require_once __DIR__ . '/../Model/ModelUsuarios.php';
    require_once __DIR__ . '/../../config/Auth.php';
    require_once __DIR__ . '/../../config/prg.php';

    class ControllerUsuarios {
        private $model;

        public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
        }
        if (!isset($_SESSION['id'])) {
            header("Location: login");
            exit;
        }
        if ($_SESSION['tipo'] != 1) {

        header("Location: home");
            exit;
        } 

        permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);
        
        $this->model = new ModelUsuarios();
        }

        public function Usuario() {
            $sucesso = '';
            $erro = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrfValido()) {
                definirMensagem('erro', 'Requisição inválida. Tente novamente.');
                redirecionarPRG('usuarios');
            }
 
        // CADASTRAR
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $tipo = intval($_POST['tipo_usuario']);
 
            $resultado = $this->model->cadastrar($nome, $email, $senha, $tipo);
 
            if ($resultado['sucesso']) {
                definirMensagem('sucesso', "Usuário cadastrado com sucesso!");
            } elseif ($resultado['erro'] === 'duplicado') {
                definirMensagem('erro', "Já existe um usuário com esse email.");
            } else {
                definirMensagem('erro', "Erro ao cadastrar usuário.");
            }

            redirecionarPRG('usuarios');
        }
 
        // EDITAR
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'editar') {
            $id = intval($_POST['id']);
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $ativo = intval($_POST['ativo']);
            $tipo = intval($_POST['tipo_usuario']);
            $senha = $_POST['senha'] ?? '';
 
            if ($this->model->editar($id, $nome, $email, $senha, $ativo, $tipo)) {
                definirMensagem('sucesso', "Usuário atualizado com sucesso!");
            } else {
                definirMensagem('erro', "Erro ao atualizar usuário.");
            }
            redirecionarPRG('usuarios');
        }
 
        // EXCLUIR
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
            $id = intval($_POST['id'] ?? 0);
            if ($id === (int)$_SESSION['id']) {
                definirMensagem('erro', "Você não pode excluir seu próprio usuário.");
            } elseif ($this->model->excluir($id)) {
                definirMensagem('sucesso', "Usuário excluído com sucesso!");
            } else {
                definirMensagem('erro', "Erro ao excluir usuário.");
            }

            redirecionarPRG('usuarios');
        }
 
        // BUSCAR PARA EDITAR
        $usuario_editar = null;
        if (isset($_GET['editar'])) {
            $usuario_editar = $this->model->buscarPorId(intval($_GET['editar']));
        }
 
        $busca = trim($_GET['busca'] ?? '');
        $usuarios = $this->model->listar($busca);
 
        include __DIR__ . '/../View/Usuarios/index.php';
    }
}
