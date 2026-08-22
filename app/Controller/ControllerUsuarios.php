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
            header("Location: ?url=login");
            exit;
        }
        if ($_SESSION['tipo'] != 1) {

        header("Location: ?url=home");
            exit;
        } 

        permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);
        
        $this->model = new ModelUsuarios();
        }

        public function Usuario() {
            $sucesso = '';
            $erro = '';
 
        // CADASTRAR
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'cadastrar') {
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $tipo = intval($_POST['tipo_usuario']);
 
            if ($this->model->cadastrar($nome, $email, $senha, $tipo)) {
                definirMensagem('sucesso', "Usuário cadastrado com sucesso!");
            } else {
                definirMensagem('erro', "Erro ao cadastrar usuário.");
            }

            redirecionarPRG('?url=usuarios');
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
            redirecionarPRG('?url=usuarios');
        }
 
        // EXCLUIR
        if (isset($_GET['excluir'])) {
            $id = intval($_GET['excluir']);
            if ($id === $_SESSION['id']) {
                definirMensagem('erro', "Você não pode excluir seu próprio usuário.");
            } else {
                $this->model->excluir($id);
            }

            redirecionarPRG('?url=usuarios');
        }
 
        // BUSCAR PARA EDITAR
        $usuario_editar = null;
        if (isset($_GET['editar'])) {
            $usuario_editar = $this->model->buscarPorId(intval($_GET['editar']));
        }
 
        $usuarios = $this->model->listar();
 
        include __DIR__ . '/../View/Usuarios/index.php';
    }
}