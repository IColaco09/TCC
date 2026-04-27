<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header("Location: /TCC/public/index.php?url=login");
        exit;
    }

    function permitirEntrada($tipo_user){
        if(in_array($_SESSION['tipo_usuario'], $tipo_user)){
            header("Location: /TCC/public/index.php?url=home");
            exit;
        }
    }