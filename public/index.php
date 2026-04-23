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
        require '../app/Controller/ControllerLogin.php';
        (new ControllerLogin())->login();
        break;

    case 'home':
        require '../app/Controller/ControllerHome.php';
        (new ControllerHome())->index();
        break;

    case 'usuarios':
        require '../app/Controller/ControllerUsuarios.php';
        (new ControllerUsuarios())->index();
        break;

    case 'clientes':
        require '../app/Controller/ControllerClientes.php';
        (new ControllerClientes())->index();
        break;

    case 'relatorios':
        require '../app/Controller/ControllerRelatorios.php';
        (new ControllerRelatorios())->index();
        break;

    case 'produtos':
        require '../app/Controller/ControllerProdutos.php';
        (new ControllerProdutos())->index();
        break;

    case 'vendas':
        require '../app/Controller/ControllerVendas.php';
        (new ControllerVendas())->index();
        break;

    case 'configuracoes':
        require '../app/Controller/ControllerConfiguracoes.php';
        (new ControllerConfiguracoes())->index();
        break;

    default:
        echo "404 - Página não encontrada";
        break;
}
