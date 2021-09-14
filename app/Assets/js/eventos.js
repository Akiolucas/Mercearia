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
        let form_campos = [
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
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_validos[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
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
        let form_campos = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 70 caracteres'],
          ['form-ativo','*Selecione uma opção'],
          ['form-cargo','*Selecione uma opção'],
          ['form-nivel','*Selecione uma opção'],
          ['form-pg-privada-id','*Selecione pelo menos uma opção']
        ];
    
        for(var i = 0; i < f_a_validos.length; i ++)
        {
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_a_validos[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
          }
        }
       
        e.preventDefault();
      }
    });
    //fim da validação do formulário de atualizar funcionário

    //cargo cadastrar
    let f_cadastrar = $('#form-cadastrar-cargo');
    f_cadastrar.submit(function(e)
    {
      let f_nome = $('#form-nome').val();

       let f_valido =[
        validatamanho(f_nome,2,45)
      ];
      
      if(!form_valido(f_valido))
      {
        let form_campos = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 45 caracteres']
        ];
    
        for(var i = 0; i < f_valido.length; i ++)
        {
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_valido[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
          }
        }
       
        e.preventDefault();
      }
    });
    //fim da validação do formulário de cadastrar cargo

    //cargo atualizar
    
    let f_a_cadastrar = $('#form-atualizar-cargo');
    f_a_cadastrar.submit(function(e)
    {
      let f_nome = $('#form-nome').val();

       let f_valido =[
        validatamanho(f_nome,2,45)
      ];
      
      if(!form_valido(f_valido))
      {
        let form_campos = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 45 caracteres']
        ];
    
        for(var i = 0; i < f_valido.length; i ++)
        {
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_valido[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
          }
        }
       
        e.preventDefault();
      }
    });
    //fim da validação do formulário de atualizar cargo
    
    //estoque atualizar
    let f_estoque = $('#form-atualizar-estoque');
    f_estoque.submit(function(e)
    {
     
      let f_quantidade = $('#form-quantidade').val();

      let f_valido =[
        validaInt(0,f_quantidade)
      ];

      if(!form_valido(f_valido))
      {
        let form_campos = [
          ['form-quantidade','*Quantidade informada inválida']
        ];
    
        for(var i = 0; i < f_valido.length; i ++)
        {
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_valido[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
          }
        }
       
        e.preventDefault();
      }

    });
    //fim da validação do formulário de atualizar estoque

    // fornecedor cadastrar
    let f_fornecedor = $('#form-fornecedor');
    f_fornecedor.submit(function(e)
    {
    
      let f_nome = $('#form-nome').val();
      let f_cnpj = $('#form-cnpj').val();
      let f_valido =[
        validatamanho(f_nome,1,50),
        validatamanho(f_cnpj,18,18)
      ];

      if(!form_valido(f_valido))
      {
        let form_campos = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 50 caracteres'],
          ['form-cnpj','*Cnpj inválido']
        ];
    
        for(var i = 0; i < f_valido.length; i ++)
        {
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_valido[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
          }
        }
       
        e.preventDefault();
      }

    });
    // fim da validação do formulário de cadastro de fornecedor

    //fornecedor atualizar
    let f_a_fornecedor = $('#form-atualizar-fornecedor');
    f_a_fornecedor.submit(function(e)
    {
      let f_a_nome = $('#form-nome').val();
      let f_a_cnpj = $('#form-cnpj').val();
      
      let f_valido = [
        validatamanho(f_a_nome,1,50),
        validatamanho(f_a_cnpj,18,18)
      ];

      if(!form_valido(f_valido))
      {
        let form_campos = [
          ['form-nome','*Preencha este campo, limite máximo permitido é 50 caracteres'],
          ['form-cnpj','*Cnpj inválido']
        ];

        for(var i = 0; i < f_valido.length; i ++)
        {
          $('#'+form_campos[i][0]).removeClass('is-invalid');
          $('#d-'+form_campos[i][0]).remove();

          if(f_valido[i] == false)
          {
            var elemento = $('#'+form_campos[i]).addClass('is-invalid');
            
            elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
          }
        }

        e.preventDefault();
      }

      
    });
  // fim da validação do formulário de atualizar fornecedor
  
  // nivel cadastrar
  let f_nivel = $('#form-nivel');
  f_nivel.submit(function(e)
  {
  
    let f_nome = $('#form-nome').val();
    let f_valido =[
      validatamanho(f_nome,1,7)
    ];

    if(!form_valido(f_valido))
    {
      let form_campos = [
        ['form-nome','*Preencha este campo, limite máximo permitido é 7 caracteres']
      ];
  
      for(var i = 0; i < f_valido.length; i ++)
      {
        $('#'+form_campos[i][0]).removeClass('is-invalid');
        $('#d-'+form_campos[i][0]).remove();

        if(f_valido[i] == false)
        {
          var elemento = $('#'+form_campos[i]).addClass('is-invalid');
          
          elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
        }
      }
     
      e.preventDefault();
    }

  });
  // fim da validação do formulário de cadastro de nivel

  //nivel atualizar
  let f_a_nivel = $('#form-atualizar-nivel');
  f_a_nivel.submit(function(e)
  {
    let f_a_nome = $('#form-nome').val();
    
    let f_valido = [
      validatamanho(f_a_nome,1,7)
    ];

    if(!form_valido(f_valido))
    {
      let form_campos = [
        ['form-nome','*Preencha este campo, limite máximo permitido é 7 caracteres']
      ];

      for(var i = 0; i < f_valido.length; i ++)
      {
        $('#'+form_campos[i][0]).removeClass('is-invalid');
        $('#d-'+form_campos[i][0]).remove();

        if(f_valido[i] == false)
        {
          var elemento = $('#'+form_campos[i]).addClass('is-invalid');
          
          elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
        }
      }

      e.preventDefault();
    }

    
  });
// fim da validação do formulário de atualizar nivel

// página privada cadastrar
let f_paginaPrivada = $('#form-paginaPrivada');
f_paginaPrivada.submit(function(e)
{
  let f_nome = $('#form-nome').val();
  let f_valido =[
    validatamanho(f_nome,1,30)
  ];

  if(!form_valido(f_valido))
  {
    let form_campos = [
      ['form-nome','*Preencha este campo, limite máximo permitido é 30 caracteres']
    ];

    for(var i = 0; i < f_valido.length; i ++)
    {
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();

      if(f_valido[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
      }
    }
   
    e.preventDefault();
  }

});
// fim da validação do formulário de cadastro de página privada

//página privada atualizar
let f_a_paginaPrivada = $('#form-atualizar-paginaPrivada');
f_a_paginaPrivada.submit(function(e)
{
  let f_a_nome = $('#form-nome').val();
  
  let f_valido = [
    validatamanho(f_a_nome,1,7)
  ];

  if(!form_valido(f_valido))
  {
    let form_campos = [
      ['form-nome','*Preencha este campo, limite máximo permitido é 30 caracteres']
    ];

    for(var i = 0; i < f_valido.length; i ++)
    {
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();

      if(f_valido[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
      }
    }

    e.preventDefault();
  }

  
});
// fim da validação do formulário de atualizar página privada

// página pública cadastrar
let f_paginaPublica = $('#form-paginaPublica');
f_paginaPublica.submit(function(e)
{
  let f_nome = $('#form-nome').val();
  let f_valido =[
    validatamanho(f_nome,1,30)
  ];

  if(!form_valido(f_valido))
  {
    let form_campos = [
      ['form-nome','*Preencha este campo, limite máximo permitido é 30 caracteres']
    ];

    for(var i = 0; i < f_valido.length; i ++)
    {
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();

      if(f_valido[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
      }
    }
   
    e.preventDefault();
  }

});
// fim da validação do formulário de cadastro de página pública

//página privada atualizar
let f_a_paginaPublica = $('#form-atualizar-paginaPublica');
f_a_paginaPublica.submit(function(e)
{
  let f_a_nome = $('#form-nome').val();
  
  let f_valido = [
    validatamanho(f_a_nome,1,7)
  ];

  if(!form_valido(f_valido))
  {
    let form_campos = [
      ['form-nome','*Preencha este campo, limite máximo permitido é 30 caracteres']
    ];

    for(var i = 0; i < f_valido.length; i ++)
    {
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();

      if(f_valido[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+">" +form_campos[i][1] + "</div>");
      }
    }

    e.preventDefault();
  }

  
});
// fim da validação do formulário de atualizar página pública

// página produto cadastrar
let f_produto = $('#form-produto');
f_produto.submit(function(e)
{
  let f_nome = $('#form-nome').val();
  let f_preco = $('#form-preco').val();
  let f_fornecedor_id = $('#form-fornecedor_id').val();
  let f_form_kilograma = $('#form-kilograma').val();
  let f_quantidade = $('#form-quantidade').val();

  let f_validos =[
    validatamanho(f_nome,1,30),
    validaFloat(f_preco,0.10),
    validaInt(1,f_fornecedor_id),
    validaFloat(f_form_kilograma,0.001),
    validaInt(1,f_quantidade)
  ];
  
  if(!form_valido(f_validos))
  {
    let form_campos = [
      ['form-nome','*Preencha este campo, limite máximo permitido é 30 caracteres'],
      ['form-preco',"* Informe o preço, mínimo 0,10 Reais"],
      ['form-fornecedor_id','*Selecione uma opção'],
      ['form-kilograma','*Informe o Kg, mínimo 0,001 kg'],
      ['form-quantidade','*Informe a quantidade, mínimo 1']
    ];
    
    for(var i = 0; i < f_validos.length; i ++)
    {
      
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();
      
      if(f_validos[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+"><p>" +form_campos[i][1] + "</p></div>");
      }
    }
    e.preventDefault();
  }

});
// fim da validação do formulário de cadastro de produto

//produto atualizar

let f_a_produto = $('#form-atualizar-produto');
f_a_produto.submit(function(e)
{
  let f_nome = $('#form-nome').val();
  let f_preco = $('#form-preco').val();
  let f_fornecedor_id = $('#form-fornecedor_id').val();
  let f_form_kilograma = $('#form-kilograma').val();
  let f_quantidade = $('#form-quantidade').val();

  let f_validos =[
    validatamanho(f_nome,1,30),
    validaFloat(f_preco,0.10),
    validaInt(1,f_fornecedor_id),
    validaFloat(f_form_kilograma,0.001),
    validaInt(0,f_quantidade)
  ];
 
  
  if(!form_valido(f_validos))
  {
    let form_campos = [
      ['form-nome','*Preencha este campo, limite máximo permitido é 30 caracteres'],
      ['form-preco',"* Informe o preço, mínimo 0,10 Reais"],
      ['form-fornecedor_id','*Selecione uma opção'],
      ['form-kilograma','*Informe o Kg, mínimo 0,001 kg'],
      ['form-quantidade','*Informe a quantidade, mínimo 0']
    ];
    
    for(var i = 0; i < f_validos.length; i ++)
    {
      
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();
      
      if(f_validos[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+"><p>" +form_campos[i][1] + "</p></div>");
      }
    }
    e.preventDefault();
  }

});
// fim da validação do formulário de atualizar produto

//perfil atualizar dados

let f_a_perfil = $('#form-atualizar-perfil');
f_a_perfil.submit(function(e)
{
  let f_credencial = $('#form-credencial').val();
  let f_senhaAtual = $('#form-senhaAtual').val();
  let f_senha = $('#form-senha').val();
  let f_senhaRepetida = $('#form-senhaRepetida').val();

  let f_validos =[
    validatamanho(f_credencial,8,20),
    validatamanho(f_senhaAtual,8,64),
    validatamanho(f_senha,8,64),
    validaSenhaRepetida(f_senha,f_senhaRepetida,8,64)
  ];
  
  if(!form_valido(f_validos))
  {
  
    let form_campos = [
      ['form-credencial','*Preencha este campo, credencial deve conter entre 8 a 20 caracteres'],
      ['form-senhaAtual',"*Senha inválida"],
      ['form-senha','*Informe a nova senha, deve conter entre 8 a 64 caracteres'],
      ['form-senhaRepetida','*Senha diferente, informe a nova senha e tente novamente'],
    ];
    
    for(var i = 0; i < f_validos.length; i ++)
    {
      
      $('#'+form_campos[i][0]).removeClass('is-invalid');
      $('#d-'+form_campos[i][0]).remove();
      
      if(f_validos[i] == false)
      {
        var elemento = $('#'+form_campos[i]).addClass('is-invalid');
        
        elemento.after("<div class='invalid-feedback' id=d-"+ form_campos[i][0]+"><p>" +form_campos[i][1] + "</p></div>");
      }
    }
    e.preventDefault();
  }

});
  //fim da atualização do perfil do usuário.

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

  function validaFloat(variavel,minimo)
  {
    variavel = variavel.replace('.','');
    variavel = variavel.replace(',','.');

    parseFloat(variavel);

    if(isNaN(variavel)){
      return false;
    }

    else if(variavel < minimo){
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
  function validaSenhaRepetida(senha,senhaRepetida,minimo,maximo)
  {
    if(senhaRepetida.length < minimo || senhaRepetida.length > maximo || senhaRepetida != senha)
    {
      return false;
    }
    return true;
  }
})