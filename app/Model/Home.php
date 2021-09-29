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
	(SELECT COUNT(funcionario.id) 
    FROM funcionario) AS funcionario,
    
    (SELECT COUNT(funcionario.id) 
    FROM funcionario
    WHERE ativo = 1) AS funcionario_ativo,
    
    (SELECT c.nome
	FROM  funcionario f
	INNER JOIN cargo c
	ON f.cargo_id = c.id
	GROUP BY (f.cargo_id)
	ORDER BY COUNT(f.cargo_id) DESC LIMIT 1) AS cargo,
    
    (SELECT COUNT(f.cargo_id)
	FROM  funcionario f
	INNER JOIN cargo c
	ON f.cargo_id = c.id
	GROUP BY (f.cargo_id)
	ORDER BY COUNT(f.cargo_id) DESC LIMIT 1) AS cargo_qtd,
    
	(SELECT COUNT(fornecedor.id)
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
    
	(SELECT SUM(estoque.quantidade) 
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

	(SELECT e.quantidade
	FROM caixa c
	INNER JOIN estoque e
	ON c.produto_id = e.produto_id
	GROUP BY c.produto_id           
	ORDER BY SUM(c.quantidade) DESC   
	LIMIT 1 ) AS estoque,
    
    (SELECT SUM(total)
    FROM caixa_fechamento
    WHERE dt_registro  LIKE CONCAT(curdate(),'%')) AS caixa_hoje,
    
    (SELECT SUM(quantidade)
    FROM caixa
    WHERE dt_registro  LIKE CONCAT(curdate(),'%')) AS caixa_hoje_qtd,
    
	(SELECT SUM(quantidade) 
    FROM caixa) AS caixa_vendas,
    
    (SELECT SUM(total) 
    FROM caixa_fechamento) AS caixa"
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