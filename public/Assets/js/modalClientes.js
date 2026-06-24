function abrirCadastrar() {
  document.getElementById('cadastrarNome').value = '';
  document.getElementById('cadastrarEmail').value = '';
  document.getElementById('cadastrarTelefone').value = '';
  document.getElementById('cadastrarCpf_cnpj').value = '';
  document.getElementById('modalCadastrar').classList.add('ativo');
}

function abrirEditar(id, nome, email, cpf, telefone) {
  document.getElementById('editarId').value = id;
  document.getElementById('editarNome').value = nome;
  document.getElementById('editarEmail').value = email;
  document.getElementById('editarTelefone').value = telefone;
  document.getElementById('editarCpf_cnpj').value = cpf;
  document.getElementById('modalEditar').classList.add('ativo');
}

