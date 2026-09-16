<?php
    
    function permitirEntrada($tipos_permitidos) {
    if (!isset($_SESSION['tipo']) || !in_array($_SESSION['tipo'], $tipos_permitidos)) {
        header("Location: ?url=home");
        exit;
    }
}