$(document).ready(function(){

    let fornecedor_id = $("#option_padrao").val();

    $.post("http://localhost/mercearia/produtos/fornecedorAjax",function(result, status){
       let objeto = JSON.parse(result);
        let text = "";

        objeto.forEach(listar);

        $selected = $('#form_option').val();

       function listar(item, index)
       {
        if(item['id'] != fornecedor_id){
            text +="<option value=" + item['id'] + ">" + item['nome'] + "</option>"; 
        }
       }
       
       $("#form_fornecedor").append(text);

    })

});


