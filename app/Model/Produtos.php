<?php 
    namespace App\Model;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Produtos extends Model
    {
        public function listar(): array
        {
            $listar = parent::projetarTodos(
            "SELECT p.nome, p.preco AS preço, f.nome AS fornecedor, c.barra AS código, p.kilograma, p.dt_registro
            FROM produto p
            INNER JOIN fornecedor f
            ON p.fornecedor_id = f.id
            INNER JOIN codigo c
            ON p.codigo_id = c.id");

            return $listar;
        }
    }

    
?>