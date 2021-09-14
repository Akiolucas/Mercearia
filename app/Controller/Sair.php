<?php 

namespace App\Controller;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Sair extends Controller
{

    public function index(): void
    {
        $logout = new \App\Model\Sair();
        $logout->logout();
        
        $msg = "deslogado com sucesso";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        
        header("location:". URL . "login/index");
        exit();
    }
}
    