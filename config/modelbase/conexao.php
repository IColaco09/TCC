<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "tcc_provisorio";

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
