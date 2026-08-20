<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

    default:
        echo "404 - Página não encontrada";
        break;
}
