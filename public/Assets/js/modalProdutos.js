function abrirCadastrar() {
  document.getElementById('cadastrarCodigo').value = '';
  document.getElementById('cadastrarNome').value  = '';
  document.getElementById('cadastrarPreco').value = '';
  document.getElementById('cadastrarEstoque').value  = '';
  document.getElementById('cadastrarTipo').value = '';
  document.getElementById('cadastrarDescricao').value = '';

  document.getElementById('modalCadastrar').classList.add('ativo');
}

function abrirCadTipo() {
  document.getElementById('cadastrarNomeTipo').value = '';
  document.getElementById('cadastrarDescricaoTipo').value = '';
  document.getElementById('modalCadTipo').classList.add('ativo');
}

function abrirEditar(codigo, nome, preco, estoque, descricao, tipo) {
  document.getElementById('editarCodigo').value = codigo;
  document.getElementById('editarNome').value = nome;
  document.getElementById('editarPreco').value = preco;
  document.getElementById('editarEstoque').value = estoque;
  document.getElementById('editarDescricao').value = descricao;
  document.getElementById('editarTipoProduto').value = tipo;

  document.getElementById('modalEditar').classList.add('ativo');
}

function abrirExcluir(id) {
  document.getElementById('Excluir').href = 
    '/TCC/?url=produtos&excluir=' + id;

  document.getElementById('modalExcluir').classList.add('ativo');
}

