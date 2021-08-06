<?php 

namespace Core;
    if(!defined("MERCEARIA2021"))// verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Endereco
    {
        public function urlPublica(): void
        {
            define('URL',"http://localhost/mercearia/");
        }
    }