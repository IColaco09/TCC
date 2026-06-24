<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css">
  <script src="<?= BASE_URL ?>/public/Assets/js/rotas.js"></script>
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaPedidos()" class="active">Pedidos</button>
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Gestão de Pedidos</h1>
      </header>

      <section class="search-header">
        <input type="text" placeholder="Buscar pedido..." class="search">

        <div class="buttons">
          <button class="btn">Buscar</button>
          <button class="btn">+ Novo Pedido</button>
        </div>
      </section>

      <section class="tabela">
        <table class="tabela-6">
          <thead>
            <tr>
              <th>Pedido</th>
              <th>Cliente</th>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Data</th>
              <th>Status</th> 
            </tr>

          </thead>

          <tbody>

            <tr>
              
            </tr>

          </tbody>
        </table>

      </section>

    </main>

  </div>

</body>

</html>