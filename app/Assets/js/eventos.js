$(document).ready(function(){

  // adicionar classe de efeito para o botão do menu
  $('#btn-menu').click( function () {
    $('#btn-menu').addClass("border-btn-menu");
  })
  
  //remover classe de efeito.
  $('#menuLateral').on('hidden.bs.collapse', function () {
    $('#btn-menu').removeClass("border-btn-menu");
  })

  $('td #link_excluir').click(function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    $('#confirm-delete').modal({show:true});
    $('#excluir_ok').attr('href',href);
  });

  //formulários

    //funcionário
    let f_funcionario = $('#form-funcionario');
    f_funcionario.submit(function(e)
    {

      let f_nome = $('#form-nome').val();
      let f_ativo = $('#form-ativo').val();
      let f_cargo = $('#form-cargo').val();
      let f_nivel = $('#form-nivel').val();
      let f_credencial = $('#form-credencial').val();
      let f_senha = $('#form-senha').val();
      let f_pg_privada = [];
      $("input[name='pg_privada_id[]']:checked").each(function()
      {
        f_pg_privada.push(parseInt($(this).val()));
      });

      let f_validos =[
        validatamanho(f_nome,0,70),
        validaBool(f_ativo),
        validaInt(1,f_cargo),
        validaInt(1,f_nivel),
        validatamanho(f_credencial,8,20),
        validatamanho(f_senha,8,64),
        validaOpcoes(f_pg_privada)
      ];

      if(form_valido(f_validos))
      {
        alert('form valido');
        e.preventDefault();
      }
      else{
        alert('form invalido');
        e.preventDefault();
      }
    });
    //fim da validação do formulário de cadastro de funcionário.

  // funções de validação
  function validaOpcoes(array)
  {
    for(var i=0;i < array.length; i ++)
    { 
      if(!validaInt(1,array[i]))
      {
        return false;
      }
    }
    return true;  
  }

  function validatamanho(variavel,minimo, maximo)
  { 
    if(variavel.length == 0 || variavel.length < minimo || variavel.length > maximo){
     
      return false;
    }
    return true;
  }

  function validaInt(minimo,valor)
  {
    parseInt(valor,10);

    if(isNaN(valor)){
      return false;
    }

    else if (valor < minimo)
    {
      return false;
    }
    return true;
  }
  function validaBool(variavel)
  {
    parseInt(variavel);

    if(isNaN(variavel)){
      return false;
    }

    else if(variavel < 0 || variavel > 1){
      return false;
    }
    return true;
  }

  function form_valido(dados)
  {
    for(var i = 0; i < dados.length; i++)
    {
      if(!dados[i]){
        
       return false;
      }
    }
    return true;
  }
})