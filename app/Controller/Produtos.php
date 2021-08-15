<?php 
    namespace App\Controller;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Produtos extends Controller
    {
        private $dados;

        public function index()
        {
    
            $pagina = new \Core\ConfigView("View/produto/index",$this->dados);
            $pagina->renderizar();
           
        }
        public function listar()
        {
            $tabela = new \App\Model\Produtos();
            $dados = $tabela->listar();

            print json_encode($dados, JSON_UNESCAPED_UNICODE);
        }
    }
?>