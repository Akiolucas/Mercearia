<?php 

namespace App\Controller;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Login extends Controller
{
    private $dados;

    public function index()
    {
        $this->dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(!empty($this->dados['btnAcessar'])){
            $validar = new \App\Model\Login();

             $validar->login($this->dados);
            
             if($validar->getResultado())
             {
               $urlDestino = URL . "home/";
               header("Location: $urlDestino");
             }
             else{
                 $this->dados['form'] = $this->dados;
             }
         }
         
        $pagina = new \Core\ConfigView('View/login/index',$this->dados);
        $pagina->renderizar();
    }
}
    