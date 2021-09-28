<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Home extends Model
{

    public function listar()
    {
        try{
            $home = parent::projetarTodos(
    "SELECT
	(SELECT count(funcionario.id) 
    FROM funcionario) AS funcionario,
    
    (SELECT count(funcionario.id) 
    FROM funcionario
    WHERE ativo = 1) AS funcionario_ativo,
    
	(SELECT count(fornecedor.id)
    FROM fornecedor) AS fornecedor,
    
    (SELECT f.nome
	FROM fornecedor f
	INNER JOIN produto p
	ON p.fornecedor_id = f.id
	INNER JOIN estoque e
	ON e.produto_id = p.id
	GROUP BY p.fornecedor_id           
	ORDER BY SUM(e.quantidade) DESC  
	LIMIT 1) AS maiorFornecedor,
    
	(SELECT SUM(e.quantidade) + SUM(c.quantidade)
	FROM fornecedor f
	INNER JOIN produto p
	ON p.fornecedor_id = f.id
	INNER JOIN estoque e
	ON e.produto_id = p.id
	INNER JOIN caixa c
	ON c.produto_id = p.id
	GROUP BY p.fornecedor_id           
	ORDER BY SUM(e.quantidade) DESC  
	LIMIT 1) AS fornecedor_qtd,
    
	(SELECT sum(estoque.quantidade) 
    FROM estoque) AS produto,
    
	(SELECT p.nome
	FROM caixa c
	INNER JOIN produto p
	ON c.produto_id = p.id
	GROUP BY c.produto_id           
	ORDER BY SUM(c.quantidade) DESC   
	LIMIT 1 ) AS maisVendido,
    
	(SELECT SUM(c.quantidade)
	FROM caixa c
	GROUP BY c.produto_id           
	ORDER BY SUM(c.quantidade) DESC   
	LIMIT 1 ) AS totalVendido,
    
    (SELECT sum(total) 
    FROM caixa_fechamento) AS caixa,
    
    (SELECT sum(total)
    FROM caixa_fechamento
    WHERE dt_registro  LIKE CONCAT(curdate(),'%')) AS caixa_hoje"
    );
    
            if (!empty($home)) {
                return $home;
            }
        }
        catch(PDOException $e){
            $msg = "Não foi possivel retornar detalhes, tente novamente";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("location:" . URL . "index");
            exit();
        }
    }
}