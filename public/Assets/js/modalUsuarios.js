function abrirCadastrar() {
  document.getElementById('cadastrarNome').value  = '';
  document.getElementById('cadastrarEmail').value = '';
  document.getElementById('cadastrarTipo').value  = '';
  document.getElementById('modalCadastrar').classList.add('ativo');
}

function abrirEditar(id, nome, email, tipo) {
  document.getElementById('editarId').value    = id;
  document.getElementById('editarNome').value  = nome;
  document.getElementById('editarEmail').value = email;
  document.getElementById('editarTipo').value  = tipo;

  document.getElementById('modalEditar').classList.add('ativo');
}

function abrirExcluir(id, nome) {
  document.getElementById('excluirNome').textContent = nome;
  document.getElementById('excluirLink').href = 
    '/TCC/public/index.php?url=usuarios&excluir=' + id;

  document.getElementById('modalExcluir').classList.add('ativo');
}
