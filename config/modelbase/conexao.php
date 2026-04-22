<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sistemacbs";

$conn = new mysqli($host, $user, $pass, $db);

if(!$conn){
    die("Falha na conexão: " . mysqli_connect_error());
}

define('PERFIL_ADMIN', 1);
define('PERFIL_GERENTE', 2);
define('PERFIL_USER', 3);