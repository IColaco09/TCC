<?php

    require_once __DIR__.'/../Model/ModelPedidos.php';
    require_once __DIR__ . '/../../config/Auth.php';

    class ControllerPedidos {

        private $model;
        public function __construct() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start(['cookie_httponly' => true, 'use_only_cookies' => true]);
            }

            if (!isset($_SESSION['id'])) {
                header("Location: ?url=login");
                exit;
            }

            permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

            $this->model = new ModelProdutos();
        }

        public function pedidos() {
            include __DIR__ . '/../View/Pedidos/index.php';
        }
    }       