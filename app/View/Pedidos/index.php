<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/TCC/public/Assets/css/Login.css" />
  <link rel="stylesheet" href="/TCC/public/Assets/css/Home.css">
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">Sistema</h2> <!--Nome provisório, só pra ter por enquanto msm-->

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaRelatorios()" class="active">Pedidos</button><!-- mudar a rota-->
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
              <th>Status</th> <!-- add mais coisa se necessário-->
            </tr>

          </thead>

          <tbody>

            <tr>
              <th>067</th>
              <th>Igão da Pecuária</th>
              <th>Camisa Real Matizmo 25/26</th>
              <th>1910</th>
              <th>2025-10-15</th>
              <th>Concluída</th> <!--dados de demonstração-->
            </tr>
            <tr>
              <th>068</th>
              <th>Sandro Curió</th>
              <th>Camisa Real Matizmo 25/26</th>
              <th>734</th>
              <th>2025-10-16</th>
              <th>Pendente</th> <!--dados de demonstração-->
            </tr>

          </tbody>
        </table>

      </section>

    </main>

  </div>

</body>

</html>