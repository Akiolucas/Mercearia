<?php 
    namespace App\Controller;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Perfil extends Controller
    {
        private $dados;
        private $id;
        public function index()
        {
            if(isset($_SESSION['usuario_id']) && filter_var($_SESSION['usuario_id'],FILTER_VALIDATE_INT))
            {
                $this->id['id'] = filter_var($_SESSION['usuario_id'],FILTER_VALIDATE_INT);
                $perfil = new \App\Model\Perfil();

                $this->dados = $perfil->listar($this->id);
                $pagina = new \Core\ConfigView("View/perfil/index",$this->dados);
                $pagina->renderizar();
               
            }
            else{
                $msg = "Perfil não encontrado";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "home/index");
                exit();
            }
        }

        public function editar()
        {
            if(isset($_SESSION['usuario_id']) && filter_var($_SESSION['usuario_id'],FILTER_VALIDATE_INT))
            {
                $this->id['id'] = filter_var($_SESSION['usuario_id'],FILTER_VALIDATE_INT);
                $perfil = new \App\Model\Perfil();

                $this->dados = $perfil->editar($this->id);
                $pagina = new \Core\ConfigView("View/perfil/editar",$this->dados);
                $pagina->renderizar();
               
            }
            else{
                $msg = "Perfil não encontrado";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "home/index");
                exit();
            }
        }

        public function atualizar()
        {
          
            $this->dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);
            if(isset($this->dados['btn_atualizar']) && !empty($this->dados['btn_atualizar'])){
                $atualizar = new \App\Model\Perfil();
                $atualizar->atualizar($this->dados);
            }
            header("Location:". URL . "perfil/index");
            exit();
            
        }

    }
