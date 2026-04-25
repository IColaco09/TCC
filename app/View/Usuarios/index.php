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
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaRelatorios()">Pedidos</button><!-- mudar a rota-->
        <button onclick="rotaUsuarios()" class="active">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Gestão de Usuários</h1>
      </header>

      <section class="search-header">
        <input type="text" placeholder="Buscar usuário..." class="search">

        <div class="buttons">
          <button class="btn">Buscar</button>
          <button class="btn">+ Novo Usuário</button>
        </div>
      </section>

      <section class="tabela">
        <table class="tabela-5">
          <thead>
            <tr>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Perfil</th>
              <th>Status</th>
              <th>Ações</th> <!-- add mais coisa se necessário-->
            </tr>

          </thead>

          <tbody>

            <tr>
              <th>Neymar Jr</th>
              <th>neymarjunior@auramail.com</th>
              <th>X</th>
              <th>Y</th>
              <th>Z</th> <!--dados de demonstração-->
            </tr>
            <tr>
              <th>Cristiano Ronaldo</th>
              <th>cr67siu@auramail.com</th>
              <th>X</th>
              <th>Y</th>
              <th>Z</th> <!--dados de demonstração-->
            </tr>

          </tbody>
        </table>

      </section>

    </main>

  </div>

</body>

</html>