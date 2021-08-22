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
        private function listar()
        {
            $tabela = new \App\Model\Produtos();
            $this->dados = $tabela->listar();
        }
        public function editar()
        {
            if(filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT))
            {
                echo "valido";
            }
            else{
                $msg = "Produto não encontrado";
                $_SESSION['msg'] = parent::alertaFalha($msg);

                header("Location:". URL . "produtos");
                exit();
            }
            $dados = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
            var_dump($dados);
            exit();
        }
    }
?>