<?php
function definirMensagem($tipo, $texto) {
    $_SESSION['flash'][$tipo] = $texto;
}
 
function pegarMensagens() {
    $sucesso = $_SESSION['flash']['sucesso'] ?? '';
    $erro = $_SESSION['flash']['erro'] ?? '';
    unset($_SESSION['flash']);
    return [$sucesso, $erro];
}
 
function redirecionarPRG($url) {
    header("Location: $url");
    exit;
}
 