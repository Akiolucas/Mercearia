 function dadosCadastro()
{
    $.post("http://localhost/mercearia/funcionario/funcionarioAjax",function(result){
    try{
        let objeto = JSON.parse(result);
        let text = "";

        function listar(item)
        {
            text +="<option value=" + item['id'] + ">" + item['nome'] + "</option>"; 
        }
        function checkmultiplo(item)
        {
            text += "<div class='form-check'><input type = 'checkbox' id = 'pagina"+item['id']+"' name = 'pg_privada_id[]' value = '"+item['id']+"'class='form-check-input'";
            if(item['nome'] == 'Home'){text+='checked'};
            text+="><label for = 'pagina"+item['id']+"'class='form-check-label'>"+item['nome']+"</label></div>";
        }

       
        objeto['cargo'].forEach(listar);
        $("#form-cargo").append(text);

        text = "";
        objeto['nivel'].forEach(listar);
        $("#form-nivel").append(text);

        text = "";
        objeto['pagina'].forEach(checkmultiplo);
        $("#form-pg-privada-id").append(text);

    }
    catch(err){ 
        // encaminhar para a página home exibindo um alerta sobre o erro
        window.location.replace("http://localhost/mercearia/home");
    }
    })
    
} 

function dadosAtualizar()
{
    let cargo = $("#option_padrao_cargo").val();
    let nivel = $("#option_padrao_nivel").val();

    $.post("http://localhost/mercearia/funcionario/funcionarioDetalhesAjax",function(result){
    try{
        let objeto = JSON.parse(result);
        let text = "";

        console.log(objeto);

        let campo = cargo;

        function listar(item)
        {
            if(item['id'] != campo){
                text +="<option value=" + item['id'] + ">" + item['nome'] + "</option>"; 
            }
        }

        objeto['cargo'].forEach(listar);
        $("#form_cargo_id").append(text);

        text = "";
        campo = nivel;
        objeto['nivel'].forEach(listar);
        $("#form_nivel").append(text);

    }
    catch(err){ 
        // encaminhar para a página home exibindo um alerta sobre o erro
        window.location.replace("http://localhost/mercearia/home");
    }
    })
    
} 


