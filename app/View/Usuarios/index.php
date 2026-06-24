<?php
$perfis = [
  PERFIL_ADMIN => 'Administrador',
  PERFIL_GERENTE => 'Gerente',
  PERFIL_USER => 'Usuario',
];

?>

<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css">
  <script src="<?= BASE_URL ?>/public/Assets/js/rotas.js"></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modais.js" defer></script>
  <script src="<?= BASE_URL ?>/public/Assets/js/modalUsuarios.js" defer></script>
</head>

<body>

  <div class="home">

    <aside class="sidebar">
      <h2 class="name">NextCore</h2>

      <nav>
        <button onclick="rotaHome()">Início</button>
        <button onclick="rotaProdutos()">Produtos</button>
        <button onclick="rotaClientes()">Clientes</button>
        <button onclick="rotaVendas()">Vendas</button>
        <button onclick="rotaPedidos()">Pedidos</button>
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
          <button class="btn" onclick="abrirCadastrar()">+ Novo Usuário</button>
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
            <?php foreach ($usuarios as $usuario): ?><!-- Puxa $usuarios da Controller e modifica o nome para $usuario -->
              <tr>
                <td><?= htmlspecialchars(($usuario['nome'])) ?></td> <!-- Exibe o nome do usuário -->
                <td><?= htmlspecialchars(($usuario['email'])) ?></td> <!-- Exibe o email do usuário -->
                <td><?= $perfis[$usuario['tipo_usuario']] ?? 'Perfil não encontrado' ?></td> <!-- Exibe o perfil do usuário usando o array de perfis -->
                <td><?= $usuario['ativo'] ? 'Ativo' : 'Inativo' ?></td> <!-- Exibe o status do usuário -->
                <td><button class="actions-btn" onclick="abrirEditar(<?= $usuario['id'] ?>,
                                                '<?= htmlspecialchars($usuario['nome']) ?>',
                                                '<?= htmlspecialchars($usuario['email']) ?>',
                                                <?= $usuario['tipo_usuario'] ?>,
                                                <?= $usuario['ativo'] ?> 
                                                )">Editar
                  </button>

                  <button class="actions-btn" onclick="abrirExcluir(
                    <?= $usuario['id'] ?>,
                    '<?= htmlspecialchars($usuario['nome']) ?>'
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

  <div class="modal-overlay" id="modalCadastrar"><!-- Modal para cadastrar usuário -->
    <div class="modal">
      <h2>Cadastrar Usuário</h2>
      <form method="POST" action="/public/index.php?url=usuarios">
        <input type="hidden" name="acao" value="cadastrar">

        <input type="text" name="nome" id="cadastrarNome" placeholder="Nome" required>
        <input type="email" name="email" id="cadastrarEmail" placeholder="E-mail" required>
        <input type="password" name="senha" id="cadastrarSenha" placeholder="Senha" required>

        <select name="tipo_usuario" id="cadastrarTipo" required>
          <option value="">Selecione o Tipo de Usuário</option>
          <option value="1">Admin</option>
          <option value="2">Gerente</option>
          <option value="3">Usuário</option>
        </select>

        <div class="modal-buttons">
          <button type="button" onclick="fecharModal('modalCadastrar')">Cancelar</button>
          <button type="submit">Cadastrar</button>
        </div>

      </form>
    </div>
  </div>

  <div class="modal-overlay" id="modalEditar"><!-- Modal para editar usuário -->
    <div class="modal">
      <h2>Editar Usuário</h2>
      <form method="POST" action="/public/index.php?url=usuarios">
        <input type="hidden" name="acao" value="editar">
        <input type="hidden" name="id" id="editarId">

        <input type="text" name="nome" id="editarNome" placeholder="Nome">
        <input type="email" name="email" id="editarEmail" placeholder="E-mail">
        <input type="password" name="senha" placeholder="Nova senha (opcional)">

        <select name="ativo" id="editarAtivo">
          <option value="1">Ativo</option>
          <option value="0">Inativo</option>
        </select>

        <select name="tipo_usuario" id="editarTipo">
          <option value="1">Admin</option>
          <option value="2">Gerente</option>
          <option value="3">Usuário</option>
        </select>

        <div class="modal-buttons">
          <button type="button" onclick="fecharModal('modalEditar')">Cancelar</button>
          <button type="submit">Salvar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="modalExcluir"><!-- Modal para excluir usuário -->
    <div class="modal">
      <h2>Excluir Usuario</h2>
      <p>Tem certeza de que deseja excluir <b id="excluirNome"></b>?</p>

      <div class="modal-buttons">
        <button type="button" onclick="fecharModal('modalExcluir')">Cancelar</button>
        <a id="excluirLink" href="#">
          <button type="button">Excluir</button>
        </a>
      </div>
    </div>
  </div>

</body>

</html>1