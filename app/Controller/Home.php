<?php 

namespace App\Controller;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Home extends Controller
{
    private $dados;
    public function index()
    {
        $detalhes = new \App\Model\Home();
        $this->dados = $detalhes->listar();
      
        $pagina = new \Core\ConfigView('View/home/index',$this->dados);
        $pagina->renderizar();
    }
}
    