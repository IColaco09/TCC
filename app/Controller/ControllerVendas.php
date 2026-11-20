<?php
require_once __DIR__ . '/../Model/ModelProdutos.php';

    require_once __DIR__ . '/../Model/ModelProdutos.php';
    require_once __DIR__ . '/../../config/Auth.php';
    require_once __DIR__ . '/../../config/prg.php';

    class ControllerVendas {
        private $model;

        public function __construct() {

            if (!isset($_SESSION['id'])) {
                header("Location: login");
                exit;
            }

            permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

            $this->model = new ModelProdutos();
        }

        public function vendas() {
            include __DIR__ . '/../View/Vendas/index.php';
        }
    }
