<?php 

namespace App\Controller;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class PaginaInvalida
{
    private $dados;

    public function index()
    {
        $pagina = new \Core\ConfigView('View/erro/paginainvalida',$this->dados);
        $pagina->renderizar();
    }
}
