<?php
    require_once __DIR__ . '/../Model/ModelHome.php';
    require_once __DIR__ . '/../../config/Auth.php';

    class ControllerHome {
        private $model;

        public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true,
                'use_only_cookies' => true
            ]);
        }
        $this->model = new ModelHome();
        }

        public function index() {
            // Verifica se o usuário está logado

            if (!isset($_SESSION['id'])) {
                header("Location:?url=login");
                exit;
            }

            //Busca os dados para exibir no dashboard
            $totalClientes = $this->model->contarClientes();
            $totalProdutos = $this->model->contarProdutos();
            $totalVendas = $this->model->somarVendas();

            //Passa para a view
            include __DIR__ . '/../View/Home/index.php';
        }
    }
?>  