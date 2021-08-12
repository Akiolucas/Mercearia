<?php

namespace App\Model;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Paginas extends Model
{
    private $paginas;
    private $removerPgMenu = array("Perfil", "Login", "PaginaInvalida");

    final public function acessoPaginas(array $id)
    {
        $this->paginas = parent::projetarExpecifico(
        "SELECT p.nome AS pagina
        FROM funcionario_pg_privada f
        INNER JOIN pg_privada p
        ON f.pg_privada_id = p.id 
        WHERE f.funcionario_id = :id",$id,false);
        
        /*remove do menu lateral páginas expecificas, e tranformar o array bidimensional em um vetor*/
        foreach ($this->paginas as $key => $value){
            
            foreach($this->removerPgMenu as $item)
            {
                if(in_array($item,$value)){
                    unset($this->paginas[$key]);
                }
                else{
                    array_push($this->paginas,$value['pagina']);
                    unset($this->paginas[$key]);
                }
            }  
        }
        sort($this->paginas);
        // fim 

        return $this->paginas;
    }

}