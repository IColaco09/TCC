<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/Assets/img/logo.png?v=1">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css">
  <script src="<?= BASE_URL ?>/public/Assets/js/rotas.js"></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modais.js"></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modalClientes.js"></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modalVer.js" defer></script>
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()" class="active">Clientes</button>
        <button onclick="rotaPedidos()">Pedidos</button>
        <button onclick="rotaUsuarios()">Usuários</button>
      </nav>

      <button class="logout" onclick="rotaSair()">Sair</button>
    </aside>

    <main class="content">

      <header class="topbar">
        <h1>Gestão de Clientes</h1>
      </header>

      <?php [$msgSucesso, $msgErro] = pegarMensagens(); ?>

      <?php if ($msgSucesso): ?>
          <div class="mensagem mensagem-sucesso"><?= htmlspecialchars($msgSucesso) ?></div>
      <?php endif; ?>

      <?php if ($msgErro): ?>
          <div class="mensagem mensagem-erro"><?= htmlspecialchars($msgErro) ?></div>
      <?php endif; ?>

      <section class="search-header">
        <input type="text" placeholder="Buscar cliente..." class="search">

        <div class="buttons">
          <button class="btn">Buscar</button>
          <button class="btn" onclick="abrirCadastrar()">+ Novo Cliente</button>
        </div>
      </section>

      <section class="tabela">

        <table class="tabela-com-ver tabela-5">
          <thead>
            <tr>
              <th>Nome</th>
              <th>CPF/CNPJ</th>
              <th>Telefone</th>
              <th>Email</th>
              <th>Ações</th> <!-- add mais coisa se necessário-->
            </tr>

          </thead>
          <tbody>
            <?php foreach ($clientes as $cliente): ?><!-- Puxa $usuarios da Controller e modifica o nome para $usuario -->
              <tr>
                <td><?= htmlspecialchars(($cliente['nome'])) ?></td> <!-- Exibe o nome do cliente -->
                <td><?= htmlspecialchars(($cliente['cpf_cnpj'])) ?></td> <!-- Exibe o CPF/CNPJ do cliente -->
                <td><?= htmlspecialchars(($cliente['telefone'])) ?></td> <!-- Exibe o telefone do cliente -->
                <td><?= htmlspecialchars(($cliente['email'])) ?></td> <!-- Exibe o email do cliente -->
                <td>
                  <button type="button" class="actions-btn" onclick="abrirVer(this)" data-ver="cliente"
                    data-registro="<?= htmlspecialchars(json_encode($cliente, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE), ENT_QUOTES, 'UTF-8') ?>">Ver</button>
                  <button class="actions-btn" onclick="abrirEditar(<?= $cliente['id'] ?>,
                                                '<?= htmlspecialchars($cliente['nome']) ?>',
                                                '<?= htmlspecialchars($cliente['cpf_cnpj']) ?>',
                                                '<?= htmlspecialchars($cliente['telefone']) ?>',
                                                '<?= htmlspecialchars($cliente['email']) ?>',
                                                '<?= htmlspecialchars($cliente['endereco']) ?>',
                                                '<?= htmlspecialchars($cliente['cidade']) ?>',
                                                '<?= htmlspecialchars($cliente['estado']) ?>',
                                                '<?= htmlspecialchars($cliente['cep']) ?>'
                                                )">Editar
                  </button>
                <button class="actions-btn" onclick="abrirExcluir(<?= $cliente['id'] ?>,
                                                '<?= htmlspecialchars($cliente['nome']) ?>'
                                                )">Excluir
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </section>

    </main>

  </div>

  <div class="modal-overlay" id="modalCadastrar"><!-- Modal para cadastrar cliente -->
    <div class="modal">
      <h2>Cadastrar Cliente</h2>

      <form action="<?= BASE_URL ?>/?url=clientes" method="POST">
        <input type="hidden" name="acao" value="cadastrar">

        <input type="text" name="nome" id="cadastrarNome" placeholder="Nome" required>
        <input type="text" name="cpf_cnpj" id="cadastrarCpf_cnpj" placeholder="CPF/CNPJ" required>
        <input type="text" name="telefone" id="cadastrarTelefone" placeholder="Telefone" required>
        <input type="text" name="email" id="cadastrarEmail" placeholder="Email" required>
        <input type="text" name="endereco" id="cadastrarEndereco" placeholder="Endereço" required>
        <input type="text" name="cidade" id="cadastrarCidade" placeholder="Cidade" required>
        <input type="text" name="estado" id="cadastrarEstado" placeholder="Estado" required>
        <input type="text" name="cep" id="cadastrarCep" placeholder="CEP" required>
        <div class="modal-buttons">
          <button type="submit">Cadastrar</button>
          <button type="button" onclick="fecharModal('modalCadastrar')">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="modalEditar"><!-- Modal para editar cliente -->
    <div class="modal">
      <h2>Editar Cliente</h2>
  
    <form action="<?= BASE_URL ?>/?url=clientes" method="POST">
      <input type="hidden" name="acao" value="editar">
      <input type="hidden" name="id" id="editarId">

      <input type="text" name="nome" id="editarNome" placeholder="Nome" required>
      <input type="text" name="cpf_cnpj" id="editarCpf_cnpj" placeholder="CPF/CNPJ" required>
      <input type="text" name="telefone" id="editarTelefone" placeholder="Telefone" required>
      <input type="text" name="email" id="editarEmail" placeholder="Email" required>
      <input type="text" name="endereco" id="editarEndereco" placeholder="Endereço" required>
      <input type="text" name="cidade" id="editarCidade" placeholder="Cidade" required>
      <input type="text" name="estado" id="editarEstado" placeholder="Estado" required>
      <input type="text" name="cep" id="editarCep" placeholder="CEP" required>
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
        <form action="<?= BASE_URL ?>/?url=clientes" method="POST">
          <p>Tem certeza de que deseja excluir este cliente?</p>
          <div class="modal-buttons">
            <button type="button" onclick="fecharModal('modalExcluir')">Cancelar</button>
            <a id="Excluir" href="#">
              <button type="button">Excluir</button>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal somente leitura para ver detalhes -->
  <div class="modal-overlay" id="modalVer" onclick="if (event.target === this) fecharVer()" onkeydown="tecladoVer(event)">
    <div class="modal modal-ver" role="dialog" aria-modal="true" aria-labelledby="verTitulo" tabindex="-1">
      <h2 id="verTitulo">Detalhes</h2>
      <dl id="verCampos" class="ver-campos"></dl>
      <section id="verItens" hidden>
        <h3>Itens do pedido</h3>
        <dl id="verListaItens" class="ver-campos"></dl>
      </section>
      <div class="modal-buttons">
        <button type="button" id="fecharVer" onclick="fecharVer()">Fechar</button>
      </div>
    </div>
  </div>
</body>

</html>