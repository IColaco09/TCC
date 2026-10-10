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

function csrfToken() {
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrfValido() {
    return hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''));
}

function jsArgs(...$valores) {
    $json = array_map(fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE), $valores);
    return htmlspecialchars(implode(',', $json), ENT_QUOTES, 'UTF-8');
}
