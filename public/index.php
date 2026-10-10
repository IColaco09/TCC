<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!defined('BASE_URL')) {
    define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));
}

// pega a rota da URL
$url = $_GET['url'] ?? 'login';

// Remove barra no final (ex: /login/)
$url = trim($url, '/');

// ROTAS
if (empty($url)) {
    $url = 'login';
}

switch ($url) {

    case 'login':
        require __DIR__ .'/../app/Controller/ControllerLogin.php';
        (new ControllerLogin())->login();
        break;

    case 'home':
        require __DIR__ .'/../app/Controller/ControllerHome.php';
        (new ControllerHome())->index();
        break;

    case 'usuarios':
        require __DIR__ .'/../app/Controller/ControllerUsuarios.php';
        (new ControllerUsuarios())->Usuario();
        break;

    case 'clientes':
        require __DIR__ .'/../app/Controller/ControllerClientes.php';
        (new ControllerClientes())->clientes();
        break;

    case 'relatorios':
        require __DIR__ . '/../app/Controller/ControllerRelatorios.php';
        (new ControllerRelatorios())->relatorios();
        break;

    case 'pedidos':
        require __DIR__ .'/../app/Controller/ControllerPedidos.php';
        (new ControllerPedidos())->pedidos();
        break;

    case 'produtos':
        require __DIR__ .'/../app/Controller/ControllerProdutos.php';
        (new ControllerProdutos())->produtos();
        break;

    case 'vendas':
        require __DIR__ .'/../app/Controller/ControllerVendas.php';
        (new ControllerVendas())->vendas();
        break;

    case 'sair':
        if (session_status() === PHP_SESSION_NONE) {
            session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
        }
        $_SESSION = [];
        session_destroy();
        header("Location: ?url=login");
        exit;

    default:
        http_response_code(404);
        require __DIR__ . '/../app/View/Erro/404.php';
        break;
}
