<?php
require_once __DIR__ . '/../Model/ModelLogin.php';

class ControllerLogin{

    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true,
                'use_only_cookies' => true
            ]);
        }
        $this->model = new ModelLogin();
    }

    public function login()
    {
        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['user'] ?? '');
            $senha   = trim($_POST['senha'] ?? '');

            if (empty($usuario) || empty($senha)) {
                $erro = "Preencha todos os campos.";
            } else {
                $user = $this->model->procurarUsuario($usuario);

                if ($user && isset($user['senha']) && password_verify($senha, $user['senha'])) {
                    session_regenerate_id(true);
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['tipo'] = $user['tipo_usuario'];
                    header("Location: /TCC/public/index.php?url=home");
                    exit;
                } else {
                    $erro = "Usuário ou senha incorretos!";
                }
            }
        }

        include __DIR__ . '/../View/Login/index.php';
    }
}
