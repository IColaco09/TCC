<?php
require_once __DIR__ . '/../Model/ModelLogin.php';

class ControllerLogin{

    private $model;

    public function __construct()
    {
        $this->model = new ModelLogin();
    }

    public function login()
{
    $erro = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = trim($_POST['user'] ?? '');
        $senha   = $_POST['senha'] ?? '';

        if ($usuario === '' || $senha === '') {
            $erro = "Preencha todos os campos.";
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];

            if ($this->model->tentativasRecentes($usuario, $ip) >= 5) {
                $erro = "Muitas tentativas. Tente novamente em 15 minutos.";
            } else {
                $user = $this->model->procurarUsuario($usuario);

                if ($user && password_verify($senha, $user['senha'])) {
                    $this->model->limparFalhas($usuario, $ip);
                    session_regenerate_id(true);
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['tipo'] = $user['tipo_usuario'];
                    header("Location:home");
                    exit;
                }

                $this->model->registrarFalha($usuario, $ip);
                $erro = "Usuário ou senha incorretos!";
            }
        }
    }

    include __DIR__ . '/../View/Login/index.php';
}
}
