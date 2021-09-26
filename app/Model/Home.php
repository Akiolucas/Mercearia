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
               (SELECT count(funcionario.id) FROM funcionario) AS funcionario,
               (SELECT count(fornecedor.id) FROM fornecedor) AS fornecedor,
               (SELECT sum(estoque.quantidade) FROM estoque) AS produto,
               (SELECT sum(caixa_fechamento.total) FROM caixa_fechamento) AS caixa"
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