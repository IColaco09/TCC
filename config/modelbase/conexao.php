<?php

$cfg = is_file(__DIR__ . '/creds.php') ? require __DIR__ . '/creds.php' : [];
$host = $cfg['host'] ?? 'localhost';
$user = $cfg['user'] ?? 'root';
$pass = $cfg['pass'] ?? '';
$db   = $cfg['db'] ?? 'tcc_provisorio';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    error_log("Falha na conexão: " . $e->getMessage());
    http_response_code(500);
    die("Erro interno. Tente novamente mais tarde.");

}

define('PERFIL_ADMIN', 1);
define('PERFIL_GERENTE', 2);
define('PERFIL_USER', 3);
