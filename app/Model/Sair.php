<?php
    namespace App\Model;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }
     class Sair
     {
         public function logout()
         {
            unset(
                $_SESSION['usuario_id'],
                $_SESSION['usuario_nome'],
                $_SESSION['usuario_cargo'],
                $_SESSION['usuario_paginas'],
                $_SESSION['msg']
            );
         }
     }
?>