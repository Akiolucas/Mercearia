<?php 
    namespace App\Controller;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Fornecedor extends Controller
    {
        private $dados;
        private $id;

        public function index()
        {
            $this->listar();
            $pagina = new \Core\ConfigView("View/fornecedor/index",$this->dados);
            $pagina->renderizar();
           
        }

        private function listar()
        {
            $tabela = new \App\Model\Fornecedor();
            $this->dados = $tabela->listar();
        }

        public function editar()
        {
            if(filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT))
            {
                $this->id['id'] = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
                $fornecedor = new \App\Model\Fornecedor();

                $this->dados = $fornecedor->editar($this->id);
                $pagina = new \Core\ConfigView("View/fornecedor/editar",$this->dados);
                $pagina->renderizar();
               
            }
            else{
                $msg = "Fornecedor não encontrado";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "fornecedor/index");
                exit();
            }
        }

        public function atualizar()
        {
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
          
            if(isset($this->dados['btn_atualizar']) && !empty($this->dados['btn_atualizar'])){
                $atualizar = new \App\Model\Fornecedor();
                $atualizar->atualizar($this->dados);
            }
            header("Location:". URL . "fornecedor/index");
            exit();
            
        }

        public function cadastrar()
        {
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    
            if(isset($this->dados['btn_cadastrar']) && !empty($this->dados['btn_cadastrar']))
            {
                $cadastrar = new \App\Model\Fornecedor();
                $cadastrar->cadastrar($this->dados);
            }
            header("Location:". URL . "fornecedor/index");
            exit();
        }

        public function excluir()
        {
            $this->id['id'] = filter_input(INPUT_GET ,'id',FILTER_VALIDATE_INT);

            if(!$this->id['id'] == false)
            {
                $excluir = new \App\Model\Fornecedor();
                $excluir->excluir($this->id);
            }
            else{
                $msg = "Não foi possivel excluir o fornecedor tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "fornecedor/index");
                exit();
            }
            
        }
    }
