function abrirCadastrar() {
  document.querySelector('#modalCadastrar select[name="cliente_id"]').value = '';
  document.querySelector('#modalCadastrar textarea[name="observacoes"]').value = '';

  const container = document.getElementById('itensContainer');
  container.innerHTML = ''; // reseta linhas de item de uma abertura anterior
  adicionarItem(); // começa com 1 linha limpa

  document.getElementById('modalCadastrar').classList.add('ativo');
}

function adicionarItem() {
  const template = document.getElementById('itemRowTemplate');
  const clone = template.content.cloneNode(true);
  const select = clone.querySelector('.produto-select');

  select.addEventListener('change', function () {
    const preco = this.selectedOptions[0]?.dataset.preco || '';
    this.closest('.item-row').querySelector('input[name="preco_unit[]"]').value = preco;
  });

  document.getElementById('itensContainer').appendChild(clone);
}

function abrirConcluir(id, cliente) {
  document.getElementById('concluirPedidoNome').textContent = cliente;
  document.getElementById('linkConcluir').href = '/TCC/?url=pedidos&concluir=' + id;
  document.getElementById('modalConcluir').classList.add('ativo');
}

function abrirCancelar(id, cliente) {
  document.getElementById('cancelarPedidoNome').textContent = cliente;
  document.getElementById('linkCancelar').href = '/TCC/?url=pedidos&cancelar=' + id;
  document.getElementById('modalCancelar').classList.add('ativo');
}