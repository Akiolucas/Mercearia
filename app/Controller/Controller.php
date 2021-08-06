<?php 

namespace App\Controller;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Controller
{

    private object $alerta;
    private string $mensagem;

    function __construct()
    {
        $this->alerta = new \App\Model\Alerta();
    }
    protected function alertaFalha($mensagem): string
    {
        $this->mensagem = $this->alerta->alertaFalha($mensagem);
        return $this->mensagem;
    }

    protected function alertaSucesso($mensagem): string
    {
        $this->mensagem = $this->alerta->alertaSucesso($mensagem);
        return $this->mensagem;
    }

}
?>