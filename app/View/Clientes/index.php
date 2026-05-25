<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/TCC/public/Assets/css/style.css">
  <script src="/TCC/public/Assets/js/rotas.js"></script>
  <script src="/TCC/public/Assets/js/modais.js"></script>
  <script src="/TCC/public/Assets/js/modalClientes.js"></script>
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()" class="active">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaRelatorios()">Pedidos</button>
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
          <button class="btn" onclick="abrirCadastrar()">+ Novo Cliente</button>
        </div>
      </section>

      <section class="tabela">

        <table class="tabela-4">
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
                <td><button onclick="abrirEditar(<?= $cliente['id'] ?>,
                                                '<?= htmlspecialchars($cliente['nome']) ?>',
                                                '<?= htmlspecialchars($cliente['cpf_cnpj']) ?>',
                                                '<?= htmlspecialchars($cliente['telefone']) ?>',
                                                '<?= htmlspecialchars($cliente['email']) ?>'
                                                )">Editar
                  </button>
                </td>
                <td><button onclick="abrirExcluir(<?= $cliente['id'] ?>,
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

      <form action="/TCC/public/index.php?url=clientes" method="POST">
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
    </div>
    <form action="/TCC/public/index.php?url=clientes" method="POST">
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

  <div class="modal-overlay" id="modalExcluir"><!-- Modal para excluir cliente -->
    <div class="modal">
      <h2>Excluir Cliente</h2>
      <p>Tem certeza que deseja excluir este cliente?</p>
      <form action="/TCC/public/index.php?url=clientes" method="POST">
        <input type="hidden" name="acao" value="excluir">
        <input type="hidden" name="id" id="excluirId">
        <button type="submit">Sim, Excluir</button>
        <button type="button" onclick="fecharModal('modalExcluir')">Cancelar</button>
      </form>
    </div>
  </div>
</body>

</html>