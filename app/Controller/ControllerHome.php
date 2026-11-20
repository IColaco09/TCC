<?php
    require_once __DIR__ . '/../Model/ModelHome.php';
    require_once __DIR__ . '/../../config/prg.php';
    require_once __DIR__ . '/../../config/Auth.php';

    class ControllerHome {
        private $model;

        public function __construct() {

        if (!isset($_SESSION['id'])) {
            header("Location:login");
            exit;
        }

        if (!isset($_SESSION['id'])) {
                header("Location:login");
                exit;
        }

        permitirEntrada([PERFIL_ADMIN, PERFIL_GERENTE, PERFIL_USER]);

        $this->model = new ModelHome();
        }

        public function index() {
            
            $totalClientes = $this->model->contarClientes();
            $totalProdutos = $this->model->contarProdutos();
            $totalVendas = $this->model->somarVendas();
            $estoqueBaixo = $this->model->estoqueBaixo(10);

            include __DIR__ . '/../View/Home/index.php';
        }
    }
?>
