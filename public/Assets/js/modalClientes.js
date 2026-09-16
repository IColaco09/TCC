function abrirCadastrar() {
  document.getElementById('cadastrarNome').value = '';
  document.getElementById('cadastrarCpf_cnpj').value = '';
  document.getElementById('cadastrarTelefone').value = '';
  document.getElementById('cadastrarEmail').value = '';
  document.getElementById('cadastrarEndereco').value = '';
  document.getElementById('cadastrarCidade').value = '';
  document.getElementById('cadastrarEstado').value = '';
  document.getElementById('cadastrarCep').value = '';

  document.getElementById('modalCadastrar').classList.add('ativo');
}

function abrirEditar(id, nome, email, cpf, telefone, endereco, cidade, estado, cep) {
  document.getElementById('editarId').value = id;
  document.getElementById('editarNome').value = nome;
  document.getElementById('editarCpf_cnpj').value = cpf;
  document.getElementById('editarTelefone').value = telefone;
  document.getElementById('editarEmail').value = email;
  document.getElementById('editarEndereco').value = endereco;
  document.getElementById('editarCidade').value = cidade;
  document.getElementById('editarEstado').value = estado;
  document.getElementById('editarCep').value = cep;

  document.getElementById('modalEditar').classList.add('ativo');
}

function abrirExcluir(id) {
  document.getElementById('Excluir').href = 
    '/TCC/?url=clientes&excluir=' + id;

  document.getElementById('modalExcluir').classList.add('ativo');
}