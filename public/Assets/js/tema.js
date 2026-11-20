(function () {
  var tema = 'dark';
  try { tema = localStorage.getItem('tema') || 'dark'; } catch (e) {}
  document.documentElement.setAttribute('data-theme', tema);
})();

function atualizarBotaoTema() {
  var botao = document.getElementById('btnTema');
  if (!botao) return;
  var claro = document.documentElement.getAttribute('data-theme') === 'light';
  botao.textContent = claro ? 'Modo escuro' : 'Modo claro';
}

function alternarTema() {
  var claro = document.documentElement.getAttribute('data-theme') === 'light';
  var novo = claro ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', novo);
  try { localStorage.setItem('tema', novo); } catch (e) {}
  atualizarBotaoTema();
}

document.addEventListener('DOMContentLoaded', atualizarBotaoTema);