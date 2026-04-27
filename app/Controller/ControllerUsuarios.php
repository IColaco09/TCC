<?php
    require_once '/app/Model/ModelUsuarios.php';

    class ControllerUsuarios {
        private $model;

        public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
        }
        if (!isset($_SESSION['id'])) {
            header("Location: /TCC/public/index.php?url=login");
            exit;
        }
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
                $sucesso = "Usuário cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar usuário.";
            }
        }
 
        // EDITAR
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'editar') {
            $id = intval($_POST['id']);
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $tipo = intval($_POST['tipo_usuario']);
            $senha = $_POST['senha'] ?? '';
 
            if ($this->model->editar($id, $nome, $email, $tipo, $senha)) {
                $sucesso = "Usuário atualizado com sucesso!";
            } else {
                $erro = "Erro ao atualizar usuário.";
            }
        }
 
        // EXCLUIR
        if (isset($_GET['excluir'])) {
            $id = intval($_GET['excluir']);
            if ($id === $_SESSION['id']) {
                $erro = "Você não pode excluir seu próprio usuário.";
            } else {
                $this->model->excluir($id);
                header("Location: /TCC/public/index.php?url=usuarios");
                exit;
            }
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