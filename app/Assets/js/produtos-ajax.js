$(document).ready(function(){

    let fornecedor = $("#option_padrao").val();

    $.post("http://localhost/mercearia/produtos/fornecedorAjax",function(result, status){
       let objeto = JSON.parse(result);
        let text = "";

        objeto.forEach(listar);

        $selected = $('#form_option').val();

       function listar(item, index)
       {
        if(item['nome'] == fornecedor){
            $('#option_padrao').val(item['id']);
        }
        else{
            text +="<option value=" + item['id'] + ">" + item['nome'] + "</option>"; 
        }
       }
       
       $("#form_fornecedor").append(text);

    })

});


