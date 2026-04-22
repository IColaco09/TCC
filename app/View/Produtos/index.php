<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/TCC/public/Assets/css/Login.css"/>
    <link rel="stylesheet" href="/TCC/public/Assets/css/Home.css">
</head>
<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">Sistema</h2> <!--Nome provisório, só pra ter por enquanto msm-->

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button class="active">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button> 
        <button onclick="rotaUsuarios()">Usuários</button>
        <button onclick="rotaRelatorios()">Relatórios</button> 
        <button onclick="rotaConfiguracoes()">Configurações</button> <!-- Meio opcional, mas achei q podia servir pra alguma coisa mais tarde-->
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">
  
    <!--daqui pra baixo-->

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
  <div class="tabela-header">
    <span>Código</span>
    <span>Nome</span>
    <span>Preço</span>
    <span>Estoque</span> <!-- add mais coisa se necessário-->
  </div>

</section>

    </main>

  </div>

</body>
</html>

