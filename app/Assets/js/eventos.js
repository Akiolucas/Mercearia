// adicionar classe de efeito para o botão do menu
$('#btn-menu').click( function () {
    $('#btn-menu').addClass("border-btn-menu");
  })
  
  //remover classe de efeito.
  $('#menuLateral').on('hidden.bs.collapse', function () {
    $('#btn-menu').removeClass("border-btn-menu");
  })

  $('td #link_excluir_p').click(function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    $('#confirm-delete').modal({show:true});
    $('#excluir_ok').attr('href',href);
  });


