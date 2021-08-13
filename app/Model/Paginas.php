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
    private $pgPublicas = array();

    final public function acessoPaginas(array $id)
    {
        $this->paginas = parent::projetarExpecifico(
        "SELECT p.nome AS pagina
        FROM funcionario_pg_privada f
        INNER JOIN pg_privada p
        ON f.pg_privada_id = p.id 
        WHERE f.funcionario_id = :id",$id,false);
        
       $this->paginas = $this->tranformar_Array_em_vetor($this->paginas);
        return $this->paginas;
    }
    final public function listaPgPublicas(): array
    {
        $this->pgPublicas = parent::projetarTodos("SELECT nome AS pagina FROM pg_publica");
        $this->pgPublicas = $this->tranformar_Array_em_vetor($this->pgPublicas);
        return $this->pgPublicas;
    }

    private function tranformar_Array_em_vetor($paginas): array
    {
        foreach ($paginas as $key => $value){
            array_push($paginas,$value['pagina']);
            unset($paginas[$key]);
        }
        sort($paginas);
        return $paginas;
    }

}