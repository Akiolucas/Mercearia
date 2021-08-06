<?php 

namespace Core;
    if(!defined("MERCEARIA2021"))// verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class ConfigView
{
    private $dados;
    private string $rota;

    public function __construct($rota, $dados = null)
    {
        $this->rota = $rota;
        $this->dados = $dados;        
    }
    public function renderizar()
    {

        if(file_exists('app/' . $this->rota. '.php'))
        {
            include 'app/'. $this->rota . '.php';
        }
        else
        {
            // alerta informando erro ao carregar a pagina;
            echo "Erro ao carregar a página<br>";
            echo "Erro ao carregar a view:". $this->rota. "</br>";
            exit();
        }

    }
    
}

?>