<?php

class ControllerVendas {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
        }

        if (!isset($_SESSION['id'])) {
            header("Location: ?url=login");
            exit;
        }

        $this->model = new ModelProdutos();
    }

    public function vendas() {
        include __DIR__ . '/../View/Vendas/index.php';
    }
}       