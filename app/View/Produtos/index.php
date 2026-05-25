<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/TCC/public/Assets/css/style.css">
  <script src="/TCC/public/Assets/js/modais.js" defer></script>
  <script src="/TCC/public/Assets/js/modalProdutos.js" defer></script>
  <script src="/TCC/public/Assets/js/rotas.js" defer></script>

</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()" class="active">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaPedidos()">Pedidos</button>
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
          <button class="btn" onclick="abrirCadTipo()">+ Novo Tipo</button>
          <button class="btn" onclick="abrirCadastrar()">+ Novo Produto</button>
        </div>
      </section>

      <section class="tabela">
        <table class="tabela-6">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>Preço</th>
              <th>Estoque</th>
              <th>Tipo</th>
              <th>Ações</th>
            </tr>

          </thead>

          <tbody>

            <?php foreach ($produtos as $produto): ?>
              <tr>
                <td><?= htmlspecialchars(($produto['codigo'])) ?></td>
                <td><?= htmlspecialchars(($produto['nome'])) ?></td>
                <td><?= htmlspecialchars(($produto['preco'])) ?></td>
                <td><?= htmlspecialchars(($produto['estoque'])) ?></td>
                <td>
                  <?php
                  $nomeCategoria = 'Não encontrado';
                  foreach ($categorias as $cat) {
                    if ($cat['id'] == $produto['categoria_id']) {
                      $nomeCategoria = $cat['nome'];
                      break;
                    }
                  }
                  echo htmlspecialchars($nomeCategoria);
                  ?>
                </td>
                <td>
                  <button onclick="verProduto()">

                  </button>
                </td>
                <td>
                  <button class="actions-btn" onclick="abrirEditar(
                    <?= $produto['codigo'] ?>,
                    <?= $produto['nome'] ?>,
                    <?= $produto['preco'] ?>,
                    <?= $produto['estoque'] ?>,
                    <?= $produto['categoria_id'] ?>
                    )">Editar
                  </button>

                  <button class="actions-btn" onclick="abrirExcluir(
                  '<?= htmlspecialchars(($produto['codigo'])) ?>',
                  '<?= htmlspecialchars(($produto['nome'])) ?>'
                  )">Excluir
                  </button>
                </td>
              </tr>
            <?php endforeach ?>

          </tbody>
        </table>

      </section>

    </main>

  </div>

  <div class="modal-overlay" id="modalCadTipo"><!-- Modal para cadastrar Tipo de Produto -->
    <div class="modal">
      <h2>Cadastrar Tipo De Produto</h2>
      <form action="/TCC/public/index.php?url=produtos" method="POST">
        <input type="hidden" name="acao" value="cadastrarTipo">

        <input type="text" id="cadastrarNomeTipo" name="nomeTipo" placeholder="Tipo de Produto" required>
        <input type="text" id="cadastrarDescricaoTipo" name="desc" placeholder="Digite a Descrição do Tipo do seu Produto" required>

        <div class="modal-buttons">
          <button type="submit">Cadastrar</button>
          <button type="button" onclick="fecharModal('modalCadTipo')">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="modalCadastrar"><!-- Modal para cadastrar produto -->
    <div class="modal">
      <h2>Cadastrar Produto</h2>
      <form action="/TCC/public/index.php?url=produtos" method="POST">
        <input type="hidden" name="acao" value="cadastrar">

        <input type="text" id="cadastrarCodigo" name="codigo" placeholder="Código" required>
        <input type="text" id="cadastrarNome" name="nome" placeholder="Nome" required>
        <input type="number" id="cadastrarPreco" name="preco" step="0.01" placeholder="Preço" required>
        <input type="number" id="cadastrarEstoque" name="estoque" placeholder="Estoque" required>
        <input type="text" id="cadastrarDescricao" name="descricao" placeholder="Descrição" required>

        <select name="tipo_produto" id="cadastrarTipo" required>
          <option value="">Selecione o tipo</option>
          <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
          <?php endforeach ?>
        </select>

        <div class="modal-buttons">
          <button type="submit">Cadastrar</button>
          <button type="button" onclick="fecharModal('modalCadastrar')">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="modalEditar"><!-- Modal para editar produto -->
    <div class="modal">
      <h2>Editar Produto</h2>
      <form action="/TCC/public/index.php?url=produtos" method="POST">
        <input type="hidden" name="acao" value="editar">
        <input type="hidden" name="codigo" id="editarCodigo">

        <input type="text" id="editarNome" name="nome" placeholder="Nome" required>
        <input type="number" id="editarPreco" name="preco" step="0.01" placeholder="Preço" required>
        <input type="number" id="editarEstoque" name="estoque" placeholder="Estoque" required>
        <input type="text" id="editarDescricao" name="descricao" placeholder="Descrição" required>

        <select name="tipo_produto" id="editarTipoProduto" required>
          <option value="">Selecione o tipo</option>
          <?php foreach ($categorias as $cat => $value): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
          <?php endforeach ?>
        </select>

        <div class="modal-buttons">
          <button type="submit">Salvar Alterações</button>
          <button type="button" onclick="fecharModal('modalEditar')">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="modalExcluir"><!-- Modal para confirmar exclusão -->
    <div class="modal">
      <h2>Confirmar Exclusão</h2>
        <form action="/TCC/public/index.php?url=produtos">
          <p>Tem certeza de que deseja excluir este produto?</p>
          <div class="modal-buttons">
            <button type="button" onclick="fecharModal('modalExcluir')">Cancelar</button>
            <a id="Excluir" href="#">
              <button type="button">Excluir</button>
            </a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>