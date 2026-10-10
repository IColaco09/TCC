function abrirCadastrar() {
  document.getElementById('cadastrarNome').value  = '';
  document.getElementById('cadastrarEmail').value = '';
  document.getElementById('cadastrarTipo').value  = '';
  document.getElementById('modalCadastrar').classList.add('ativo');
}

function abrirEditar(id, nome, email, tipo, ativo) {
  document.getElementById('editarId').value = id;
  document.getElementById('editarNome').value = nome;
  document.getElementById('editarEmail').value = email;
  document.getElementById('editarTipo').value = tipo;
  document.getElementById('editarAtivo').value = ativo;

  document.getElementById('modalEditar').classList.add('ativo');
}

function abrirExcluir(id, nome) {
  document.getElementById('excluirId').value = id;
  document.getElementById('excluirNome').textContent = nome;

  document.getElementById('modalExcluir').classList.add('ativo');
}
