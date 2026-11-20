<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início</title>
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/Assets/img/logo.png?v=1">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css">
  <script src="<?= BASE_URL ?>/public/Assets/js/tema.js"></script>
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
        <button onclick="rotaPedidos()">Pedidos</button>
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <div class="sidebar-footer">
        <button class="logout" id="btnTema" onclick="alternarTema()">Modo claro</button>
        <button class="logout" onclick="rotaSair()">Sair</button>
      </div>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Início</h1>
        <p>Bem-vindo</p>
      </header>

      <section class="cards">
        <div class="card">
          <h3>Receita</h3>
          <p>R$ <?= number_format((float)$totalVendas, 2, ',', '.') ?></p>
        </div>

        <div class="card">
          <h3>Clientes</h3>
          <p><?= (int)$totalClientes ?></p>
        </div>

        <div class="card">
          <h3>Produtos</h3>
          <p><?= (int)$totalProdutos ?></p>
        </div>
      </section>

      <section class="panel">
        <h2>Estoque baixo</h2>
        <?php if (empty($estoqueBaixo)): ?>
          <p>Nenhum produto com estoque baixo</p>
        <?php else: ?>
          <?php foreach ($estoqueBaixo as $p): ?>
            <p class="alerta-estoque <?= $p['estoque'] == 0 ? 'zerado' : '' ?>">
              <?= htmlspecialchars($p['codigo']) ?> - <?= htmlspecialchars($p['nome']) ?>:
              <b><?= (int)$p['estoque'] ?></b> un.
            </p>
          <?php endforeach; ?>
        <?php endif; ?>
      </section>

    </main>

  </div>

</body>

</html>