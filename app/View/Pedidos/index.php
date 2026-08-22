<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css">
  <script src="<?= BASE_URL ?>/public/Assets/js/rotas.js"></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modais.js"></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modalPedidos.js"></script>
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaPedidos()" class="active">Pedidos</button>
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Gestão de Pedidos</h1>
      </header>

      <?php if (!empty($sucesso)): ?>
        <p class="msg-sucesso"><?= htmlspecialchars($sucesso) ?></p>
      <?php endif; ?>
      <?php if (!empty($erro)): ?>
        <p class="msg-erro"><?= htmlspecialchars($erro) ?></p>
      <?php endif; ?>

      <section class="search-header">
        <input type="text" placeholder="Buscar pedido..." class="search">

        <div class="buttons">
          <button class="btn">Buscar</button>
          <button class="btn" onclick="abrirCadastrar()">+ Novo Pedido</button>
        </div>
      </section>

      <section class="tabela">
        <table class="tabela-7">
          <thead>
            <tr>
              <th>Pedido</th>
              <th>Cliente</th>
              <th>Itens</th>
              <th>Total</th>
              <th>Data</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($pedidos as $pedido): ?>
              <tr>
                <td>#<?= htmlspecialchars($pedido['id']) ?></td>
                <td><?= htmlspecialchars($pedido['cliente_nome']) ?></td>
                <td><?= htmlspecialchars($pedido['itens_resumo'] ?? '—') ?></td>
                <td>R$ <?= htmlspecialchars(number_format((float)$pedido['total'], 2, ',', '.')) ?></td>
                <td><?= htmlspecialchars($pedido['atualizado_em']) ?></td>
                <td><span class="status status-<?= htmlspecialchars($pedido['status']) ?>">
                    <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $pedido['status']))) ?>
                  </span>
                </td>
                <td>
                  <?php if (!in_array($pedido['status'], ['concluido', 'cancelado'])): ?>
                    <button class="actions-btn" onclick="abrirConcluir(<?= (int)$pedido['id'] ?>, '<?= htmlspecialchars($pedido['cliente_nome']) ?>')">Concluir</button>
                    <button class="actions-btn" onclick="abrirCancelar(<?= (int)$pedido['id'] ?>, '<?= htmlspecialchars($pedido['cliente_nome']) ?>')">Cancelar</button>
                  <?php else: ?>
                    —
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>

    </main>

  </div>

  <!-- Modal Cadastrar Pedido -->
  <div class="modal-overlay" id="modalCadastrar">
    <div class="modal">
      <h2>Novo Pedido</h2>

      <form action="<?= BASE_URL ?>/?url=pedidos" method="POST">
        <input type="hidden" name="acao" value="cadastrar">

        <select name="cliente_id" required>
          <option value="">Selecione um cliente</option>
          <?php foreach ($clientes as $cliente): ?>
            <option value="<?= (int)$cliente['id'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
          <?php endforeach; ?>
        </select>

        <textarea name="observacoes" placeholder="Observações (opcional)"></textarea>

        <div id="itensContainer">
          
        </div>

        <button class="add-item" type="button" onclick="adicionarItem()">+ Adicionar item</button>

        <div class="modal-buttons">
          <button type="submit">Cadastrar Pedido</button>
          <button type="button" onclick="fecharModal('modalCadastrar')">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

 
  <template id="itemRowTemplate">
    <div class="item-row">
      <select name="produto_id[]" class="produto-select" required>
        <option value="">Selecione um produto</option>
        <?php foreach ($produtos as $produto): ?>
          <option value="<?= (int)$produto['id'] ?>" data-preco="<?= htmlspecialchars($produto['preco']) ?>">
            <?= htmlspecialchars($produto['nome']) ?> (estoque: <?= (int)$produto['estoque'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
      <input type="number" name="quantidade[]" placeholder="Qtd" min="1" value="1" required>
      <input type="number" name="preco_unit[]" placeholder="Preço unit." step="0.01" required>
      <button type="button" onclick="this.closest('.item-row').remove()">Remover</button>
    </div>
  </template>

  <!-- Modal: Confirmar Conclusão -->
  <div class="modal-overlay" id="modalConcluir">
    <div class="modal">
      <h2>Concluir Pedido</h2>
      <p>Confirmar conclusão do pedido de <strong id="concluirPedidoNome"></strong>?</p>
      <div class="modal-buttons">
        <button type="button" onclick="fecharModal('modalConcluir')">Cancelar</button>
        <a id="linkConcluir" href="#"><button type="button">Concluir</button></a>
      </div>
    </div>
  </div>

  <!-- Modal: Confirmar Cancelamento -->
  <div class="modal-overlay" id="modalCancelar">
    <div class="modal">
      <h2>Cancelar Pedido</h2>
      <p>Confirmar cancelamento do pedido de <strong id="cancelarPedidoNome"></strong>? O estoque dos itens será devolvido.</p>
      <div class="modal-buttons">
        <button type="button" onclick="fecharModal('modalCancelar')">Voltar</button>
        <a id="linkCancelar" href="#"><button type="button">Cancelar Pedido</button></a>
      </div>
    </div>
  </div>

</body>

</html>