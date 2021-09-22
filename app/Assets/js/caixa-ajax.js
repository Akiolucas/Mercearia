$(document).ready(function()
{
    // pesquisa de produtos
    $('#form-pesquisa').keyup(function(){

        let  pesquisa =  $(this).val();
         if( pesquisa.trim() != "" && pesquisa.length >= 2)
         {
             produtoDetalhes(pesquisa);
         }
         else{
             $("#resultado-busca").html('');
         }
     });
 
     //  listar produtos no estoque correspondente com a pesquisa!

    function produtoDetalhes(pesquisa)
    {
        $.ajax({
            method:'post',
            url:'http://localhost/mercearia/caixa/listaProdutosAjax',
            data:{pesquisa:pesquisa},
            dataType: 'json',
            success: function(retorno){

                if(retorno.qtd == 0)
                {
                    $('#resultado-busca').html('<div><a href="#" class="lista-p-caixa text-center">Produto não encontrado</a></div>')
                }
                else{
                    $('#resultado-busca').html(retorno.dados);
                    $('#form-total').val(retorno.total);
                }

            },
            error:(function(){
                if(confirm('Ops, não foi possível carregar todos os dados, tente novamente caso o erro persistir entre em contato com o desenvolvedor!'))
                {
                    document.location.reload();
                }
            })
        })
    }

    // adicionar produto a tabela, exibindo detalhes.
    $('body').on('click','#resultado-busca a',function(){
        let id = $(this).attr('id');
        $.ajax({
            method: 'post',
            url:'http://localhost/mercearia/caixa/produtoAjax',
            data:{id:id},
            dataType:'json',
            success: function(retorno){
                $('#produtos-selecionados').html(retorno.dados);
                if($('#Erro21').length){
                    let cod = $('#Erro21').data('erroid');
                    alert("Produto não encontrado ID "+ cod + "! Será removido da lista");

                    setTimeout(function(){ 
                        $('#Erro21').remove();   
                    }, 3000);   
                }
            }
        });
    });
  
    // atualizar valores, conforme a quantidade do produto informada!

    $('body').on('focus','#produtos-selecionados #form-quantidade',function(){

        let qtdAnterior = $(this).val();
        $('#form-quantidade').mask('00000000',{reverse:true});

        $(this).change(function(){

            let id= $(this).data('value');
            let quantidade = $(this).val();

            if(quantidade <= 0)
            {
                if(confirm('Deseja remover esse produto?'))
                {
                    $.ajax({
                        method:'get',
                        url:'http://localhost/mercearia/caixa/remover',
                        data:{id:id},
                        beforeSend: function () {
                            $("#produtos-selecionados").html('<tr><td colspan="7" id="loading">Carregando <div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
                        },  
                        success:function(){
                            document.location.reload();
                        }
                    });
                }
                else{
                    quantidade = qtdAnterior;
                }
            }

            $.ajax({
                method:'post',
                url:'http://localhost/mercearia/caixa/quantidade',
                data:{quantidade:quantidade, id:id},
                dataType:'json',
                success: function(retorno){
                    $('table#produtos-selecionados').html(retorno.dados);
                    $('#form-total').val(retorno.total);

                    if($('#Erro21').length){
                        let cod = $('#Erro21').data('erroid');
                        alert("Produto não encontrado ID "+ cod + "! Será removido da lista");

                        setTimeout(function(){ 
                            $('#Erro21').remove();   
                        }, 3000);   
                    }
                }
            });
        });
    });
 
    // Remover produto da lista

    $('body').on('click','#removerItemCaixa',function(e){
        let nome = $(this).data('name');

        if(!confirm('Deseja remover o produto: ' + nome +', da lista?'))
        {
            e.preventDefault();
        }
    });

    $('body').on('change','#form-pagamento',function(){
    let valor = $(this).val();
    let valorCompra = $('#form-total').val();
    $('#form-dinheiro-cliente').val('');
    $('#d-form-dinheiro-cliente').remove();

        switch (valor) {
            case 'Dinheiro':
                $('#form-dinheiro-cliente').prop('readonly',false);
                $('#form-pagamento').removeClass('is-invalid');
                $('#form-troco').val('');
                let pagamento = $('#form-dinheiro-cliente').val();
                $('#form-dinheiro-cliente').mask('000.000.000,00',{reverse:true});

                if(pagamento == "")
                {
                    $('#form-dinheiro-cliente').addClass('is-invalid');
                    $('#form-dinheiro-cliente').attr('placeholder','* Informe o valor');
                }
                break;

            case 'Crédito':
                $('#form-dinheiro-cliente').prop('readonly',true);
                $('#form-pagamento').removeClass('is-invalid');
                $('#form-dinheiro-cliente').removeClass('is-invalid');
                $('#form-dinheiro-cliente').val(valorCompra);
                $('#form-troco').val('R$ 0,00');
                break;
            
            case 'Débito':
                $('#form-dinheiro-cliente').prop('readonly',true);
                $('#form-pagamento').removeClass('is-invalid');
                $('#form-dinheiro-cliente').removeClass('is-invalid');
                $('#form-dinheiro-cliente').val(valorCompra);
                $('#form-troco').val('R$ 0,00');
                break;
            
            default:
                $('#form-dinheiro-cliente').prop('readonly',);
                $('#form-pagamento').addClass('is-invalid');
                $('#form-dinheiro-cliente').addClass('is-invalid');
                $('#form-troco').val('');
                $('#btn_cadastrar').click(function(e){e.preventDefault()});
                break;
        }
    });
}); 
