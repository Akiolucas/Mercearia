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
    private array $pgPrivadas = array();
    private array $pgPublicas = array();
    private $removerPgMenu = array("Perfil", "Login", "PaginaInvalida");

    final public function acessoPaginas(array $id)
    {
        $this->paginas = parent::projetarExpecifico(
        "SELECT p.nome AS pagina
        FROM funcionario_pg_privada f
        INNER JOIN pg_privada p
        ON f.pg_privada_id = p.id 
        WHERE f.funcionario_id = :id",$id,false);
        
        
        /*tranformar o array bidimensional em um vetor e remove do menu lateral páginas expecificas*/
        foreach($this->paginas as $key => $value)
        {
            array_push($this->paginas,$value['pagina']);
            unset($this->paginas[$key]);       
        }
        foreach($this->removerPgMenu as $item)
        {
            if(in_array($item, $this->paginas))
            {   
                var_dump($item);
                unset($this->paginas[array_search($item,$this->paginas)]);
            }
        }
        sort($this->paginas);
        // fim 
        return $this->paginas;
    }
    private function listarPaginas()
    {
        $this->pgPrivadas = parent::projetarTodos("SELECT nome FROM pg_privada");
        $this->pgPublicas = parent::projetarTodos("SELECT nome FROM pg_publica");
        
    }

    public function permissaoPaginas(): array
    {
        $this->listarPaginas();
        $paginas = array(
            'publicas' => $this->pgPublicas,
            'privadas' => $this->pgPrivadas
        );
        return $paginas;
    }

}