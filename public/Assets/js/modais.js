function fecharModal(id) {
  document.getElementById(id).classList.remove('ativo');
}

document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', function(e) {
    if (e.target === this) fecharModal(this.id);
  });
});