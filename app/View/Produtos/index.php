<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos</title>
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
        <button onclick="rotaProdutos()" class="active">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaRelatorios()">Pedidos</button><!-- mudar a rota-->
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Gestão de Produtos</h1>
      </header>

      <section class="search-header">
        <input type="text" placeholder="Buscar produto..." class="search">

        <div class="buttons">
          <button class="btn">Buscar</button>
          <button class="btn">Filtrar</button>
          <button class="btn">+ Novo Produto</button>
        </div>
      </section>

      <section class="tabela">
        <table class="tabela-4">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>Preço</th>
              <th>Estoque</th> <!-- add mais coisa se necessário-->
            </tr>

          </thead>

          <tbody>

            <tr>
              <th>067</th>
              <th>Labubu Premium</th>
              <th>R$ 200</th>
              <th>1910</th> <!--dados de demonstração-->
            </tr>
            <tr>
              <th>068</th>
              <th>Labubu Deluxe</th>
              <th>R$ 310</th>
              <th>734</th> <!--dados de demonstração-->
            </tr>

          </tbody>
        </table>

      </section>

    </main>

  </div>

</body>

</html>