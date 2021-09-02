<?php 
    namespace App\Controller;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Pagina_privada extends Controller
    {
        private $dados;
        private $id;

        public function index()
        {
            $this->listar();
            $pagina = new \Core\ConfigView("View/pagina_privada/index",$this->dados);
            $pagina->renderizar();
           
        }

        private function listar()
        {
            $tabela = new \App\Model\Pagina_privada();
            $this->dados = $tabela->listar();
        }

        public function editar()
        {
            if(filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT))
            {
                $this->id['id'] = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
                $pg_privada = new \App\Model\Pagina_privada();

                $this->dados = $pg_privada->editar($this->id);
                $pagina = new \Core\ConfigView("View/pagina_privada/editar",$this->dados);
                $pagina->renderizar();
               
            }
            else{
                $msg = "Página privada não encontrada";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "pagina_privada/index");
                exit();
            }
        }

        public function atualizar()
        {
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
          
            if(isset($this->dados['btn_atualizar']) && !empty($this->dados['btn_atualizar'])){
                $atualizar = new \App\Model\Pagina_privada();
                $atualizar->atualizar($this->dados);
            }
            header("Location:". URL . "pagina_privada/index");
            exit();
            
        }

        public function cadastrar()
        {
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
    
            if(isset($this->dados['btn_cadastrar']) && !empty($this->dados['btn_cadastrar']))
            {
                $cadastrar = new \App\Model\Pagina_privada();
                $cadastrar->cadastrar($this->dados);
            }
            header("Location:". URL . "pagina_privada/index");
            exit();
        }

        public function excluir()
        {
            $this->id['id'] = filter_input(INPUT_GET ,'id',FILTER_VALIDATE_INT);

            if(!$this->id['id'] == false)
            {
                $excluir = new \App\Model\Pagina_privada();
                $excluir->excluir($this->id);
            }
            else{
                $msg = "Não foi possivel excluir a página privada tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "pagina_privada/index");
                exit();
            }
            
        }
    }
