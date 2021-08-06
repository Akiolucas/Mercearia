<?php 

namespace App\Controller;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Sair extends Controller
{
    private $dados;

    public function index(): void
    {
        unset(
            $_SESSION['usuario_id'],
            $_SESSION['usuario_nome'],
            $_SESSION['usuario_cargo'],
            $_SESSION['msg']
        );
       $msg = parent::alertaFalha("deslogado com sucesso");
        $_SESSION['msg'] = $msg;
        
        header("location:". URL . "login/index");
        exit();
    }
}
    