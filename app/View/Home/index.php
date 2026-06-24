<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css">
  <script src="<?= BASE_URL ?>/public/Assets/js/rotas.js"></script>
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>
      <nav>
        <button onclick="rotaHome()" class="active">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaPedidos()">Pedidos</button>
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Início</h1>
        <p>Bem-vindo</p>
      </header>

      <section class="cards">
        <div class="card">
          <h3>Lucro de vendas</h3>
          <p>R$ X</p>
        </div>

        <div class="card">
          <h3>Clientes</h3>
          <p>Y</p>
        </div>

        <div class="card">
          <h3>Pedidos</h3>
          <p>Z</p>
        </div>
      </section>

      <section class="panel">
        <h2>Visão geral</h2>
        <p>---</p>
      </section>

    </main>

  </div>

</body>

</html>