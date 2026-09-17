let botaoVer;

function formatarMoeda(valor) {
  if (valor == null || valor === '') return 'Não informado';
  return Number(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// Cria um rótulo e um texto, sem campos de formulário.
function mostrarCampo(rotulo, valor, destino = 'verCampos') {
  const grupo = document.createElement('div');
  const titulo = document.createElement('dt');
  const texto = document.createElement('dd');

  titulo.textContent = rotulo;
  texto.textContent = valor == null || valor === '' ? 'Não informado' : valor;
  grupo.append(titulo, texto);
  document.getElementById(destino).append(grupo);
}

function abrirVer(botao) {
  const dados = JSON.parse(botao.dataset.registro);
  const tipo = botao.dataset.ver;
  botaoVer = botao;

  document.getElementById('verCampos').replaceChildren();
  document.getElementById('verListaItens').replaceChildren();
  document.getElementById('verItens').hidden = tipo !== 'pedido';

  if (tipo === 'produto') {
    document.getElementById('verTitulo').textContent = 'Detalhes do Produto';
    mostrarCampo('Código', dados.codigo);
    mostrarCampo('Nome', dados.nome);
    mostrarCampo('Preço', formatarMoeda(dados.preco));
    mostrarCampo('Estoque', dados.estoque);
    mostrarCampo('Descrição', dados.descricao);
    mostrarCampo('Tipo', dados.tipo_nome);
  }

  if (tipo === 'cliente') {
    document.getElementById('verTitulo').textContent = 'Detalhes do Cliente';
    mostrarCampo('Nome', dados.nome);
    mostrarCampo('CPF/CNPJ', dados.cpf_cnpj);
    mostrarCampo('Telefone', dados.telefone);
    mostrarCampo('Email', dados.email);
    mostrarCampo('Endereço', dados.endereco);
    mostrarCampo('Cidade', dados.cidade);
    mostrarCampo('Estado', dados.estado);
    mostrarCampo('CEP', dados.cep);
  }

  if (tipo === 'pedido') {
    document.getElementById('verTitulo').textContent = 'Detalhes do Pedido';
    const status = { aberto: 'Aberto', em_andamento: 'Em andamento', concluido: 'Concluído', cancelado: 'Cancelado' };
    let data = dados.atualizado_em;
    if (data) {
      const partes = data.replace('T', ' ').split(' ');
      data = partes[0].split('-').reverse().join('/') + (partes[1] ? ' ' + partes[1] : '');
    }
    mostrarCampo('Número do pedido', dados.id);
    mostrarCampo('Cliente', dados.cliente_nome);
    mostrarCampo('Status', status[dados.status] || dados.status);
    mostrarCampo('Última atualização', data);
    mostrarCampo('Usuário responsável (ID)', dados.usuario_id);
    mostrarCampo('Observações', dados.observacoes);
    mostrarCampo('Total', formatarMoeda(dados.total));

    const itens = dados.itens || [];
    for (let i = 0; i < itens.length; i++) {
      const item = itens[i];
      mostrarCampo('Item ' + (i + 1), item.nome || 'Produto #' + item.produto_id, 'verListaItens');
      mostrarCampo('Código do produto', item.codigo, 'verListaItens');
      mostrarCampo('Quantidade', item.quantidade, 'verListaItens');
      mostrarCampo('Preço unitário', formatarMoeda(item.preco_unit), 'verListaItens');
      mostrarCampo('Subtotal', formatarMoeda(item.subtotal ?? item.quantidade * item.preco_unit), 'verListaItens');
    }
    if (itens.length === 0) {
      document.getElementById('verListaItens').textContent = 'Nenhum item registrado.';
    }
  }

  document.getElementById('modalVer').classList.add('ativo');
  document.getElementById('fecharVer').focus();
}

function fecharVer() {
  fecharModal('modalVer');
  if (botaoVer) botaoVer.focus();
}

function tecladoVer(evento) {
  if (evento.key === 'Escape') fecharVer();
  if (evento.key === 'Tab') {
    evento.preventDefault();
    document.getElementById('fecharVer').focus();
  }
}
