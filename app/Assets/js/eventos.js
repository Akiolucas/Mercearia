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

      if(!form_valido(f_validos))
      {
        let form_nome = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 70 caracteres'],
          ['form-ativo','*Selecione uma opção'],
          ['form-cargo','*Selecione uma opção'],
          ['form-nivel','*Selecione uma opção'],
          ['form-credencial','*A credencial deve conter entre 8 a 20 caracteres'],
          ['form-senha','*A senha deve conter entre 8 a 64 caracteres'],
          ['form-pg-privada-id','*Selecione pelo menos uma opção']
        ];
    
        for(var i = 0; i < f_validos.length; i ++)
        {
          $('#'+form_nome[i][0]).removeClass('is-invalid');
          $('#d-'+form_nome[i][0]).remove();

          if(f_validos[i] == false)
          {
            var elemento = $('#'+form_nome[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_nome[i][0]+">" +form_nome[i][1] + "</div>");
          }
        }
        e.preventDefault();
      }
    });
    //fim da validação do formulário de cadastro de funcionário.

    // funcionário atualizar

    let f_a_funcionario = $('#form-atualizar-funcionario');
    f_a_funcionario.submit(function(e)
    {
     
      let f_a_nome = $('#form-nome').val();
      let f_a_ativo = $('#form-ativo').val();
      let f_a_cargo = $('#form-cargo').val();
      let f_a_nivel = $('#form-nivel').val();
      let f_a_pg_privada = [];
      $("input[name='pg_privada_id[]']:checked").each(function()
      {
        f_a_pg_privada.push(parseInt($(this).val()));
      });

      let f_a_validos =[
        validatamanho(f_a_nome,0,70),
        validaBool(f_a_ativo),
        validaInt(1,f_a_cargo),
        validaInt(1,f_a_nivel),
        validaOpcoes(f_a_pg_privada)
      ];
      
      if(!form_valido(f_a_validos))
      {
        let form_nome = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 70 caracteres'],
          ['form-ativo','*Selecione uma opção'],
          ['form-cargo','*Selecione uma opção'],
          ['form-nivel','*Selecione uma opção'],
          ['form-pg-privada-id','*Selecione pelo menos uma opção']
        ];
    
        for(var i = 0; i < f_a_validos.length; i ++)
        {
          $('#'+form_nome[i][0]).removeClass('is-invalid');
          $('#d-'+form_nome[i][0]).remove();

          if(f_a_validos[i] == false)
          {
            var elemento = $('#'+form_nome[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_nome[i][0]+">" +form_nome[i][1] + "</div>");
          }
        }
       
        e.preventDefault();
      }
    });
  // funções de validação
  function validaOpcoes(array)
  {
    if(array.length <= 0)
    {
      return false;
    }

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