<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
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
        <button onclick="rotaClientes()" class="active">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaRelatorios()">Pedidos</button><!-- mudar a rota-->
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Gestão de Clientes</h1>
      </header>

      <section class="search-header">
        <input type="text" placeholder="Buscar cliente..." class="search">

        <div class="buttons">
          <button class="btn">Buscar</button>
          <button class="btn">+ Novo Cliente</button>
        </div>
      </section>

      <section class="tabela">

        <table class="tabela-4">
          <thead>
            <tr>
              <th>Nome</th>
              <th>CPF/CNPJ</th>
              <th>Contato</th>
              <th>Ações</th> <!-- add mais coisa se necessário-->
            </tr>

          </thead>
          <tbody>

            <tr>
              <th>Yuri Alberto</th>
              <th>414124414</th>
              <th>40028922</th>
              <th>X</th> <!--dados de demonstração-->
            </tr>
            <tr>
              <th>Jesse Lingard</th>
              <th>132233311</th>
              <th>237992000</th>
              <th>Y</th> <!--dados de demonstração-->
            </tr>

          </tbody>
        </table>

      </section>

    </main>

  </div>

</body>

</html>