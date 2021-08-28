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
        private $id;

        public function index()
        {
            $this->listar();
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
                $this->id['id'] = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
                $produto = new \App\Model\Produtos();

                $this->dados = $produto->editar($this->id);
                $pagina = new \Core\ConfigView("View/produto/editar",$this->dados);
                $pagina->renderizar();
               
            }
            else{
                $msg = "Produto não encontrado";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "produtos/index");
                exit();
            }
        }
        public function atualizar()
        {
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
          
            if(isset($this->dados['btn_atualizar']) && !empty($this->dados['btn_atualizar'])){
                $atualizar = new \App\Model\Produtos();
                $atualizar->atualizar($this->dados);
            }
            header("Location:". URL . "produtos/index");
            exit();
            
        }
        public function fornecedorAjax()
        {
            $listar = new \App\Model\Produtos();
            $fornecedores = $listar->listarFornecedor();
        
            
            echo json_encode($fornecedores,JSON_UNESCAPED_UNICODE);
        }
        public function cadastrar()
        {
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    
            if(isset($this->dados['btn_cadastrar']) && !empty($this->dados['btn_cadastrar']))
            {
                $cadastrar = new \App\Model\Produtos();
                $cadastrar->cadastrar($this->dados);
            }
            header("Location:". URL . "produtos/index");
            exit();
        }
    }
?>