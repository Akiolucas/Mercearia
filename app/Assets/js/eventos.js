// adicionar classe de efeito para o botão do menu
$('#btn-menu').click( function () {
    $('#btn-menu').addClass("border-btn-menu");
  })
  
  //remover classe de efeito.
  $('#menuLateral').on('hidden.bs.collapse', function () {
    $('#btn-menu').removeClass("border-btn-menu");
  })