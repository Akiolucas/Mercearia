<?php
    namespace App\Model;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }
     class Alerta
     {
        public function alertaFalha($texto = null):string
        {
            $elemento = '<div class="alert alertaErro alert-dismissible fade show" role="alert">'
                            . '<p class="text-center">' . $texto . '</p>'
                            .'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                          </button>
                        </div>';

            return $elemento;
        }
        public function alertaSucesso($texto = null):string
        {
            $elemento = '<div class="alert alertaSucesso alert-dismissible fade show" role="alert">'
                            . '<p class="text-center">' . $texto . '</p>'
                            .'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                          </button>
                        </div>';

            return $elemento;
        }
    
     }

?>