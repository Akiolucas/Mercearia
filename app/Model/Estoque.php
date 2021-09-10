<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Estoque extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listar(): array
    {
        $listar = parent::projetarTodos(
            "SELECT e.id, p.nome AS produto, e.quantidade 
            FROM estoque e
            INNER JOIN produto p
            ON p.id = e.id
            ORDER BY p.nome"
        );

        return $listar;
    }

    public function editar($id): array
    {
        $estoque = parent::projetarExpecifico(
            "SELECT e.id, e.produto_id, p.nome AS produto, e.quantidade 
            FROM estoque e
            INNER JOIN produto p
            ON e.produto_id = p.id
            WHERE e.id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($estoque)) {
            return $estoque;
        }
        $msg = "Produto no estoque não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "estoque/index");
        exit();
    }

    public function atualizar($dados): void
    {
        $this->form_obrigatorio = array('id','produto_id','quantidade','btn_atualizar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
            array_push(
            $this->form_valido,
            parent::valida_int($dados['id'],'id','*Id do estoque inválido',1),
            parent::valida_int($dados['produto_id'],'produto_id','*Id do produto inválido',1),
            parent::valida_int($dados['quantidade'],'quantidade','*Quantidade informada inválida',0));

            if(parent::formularioValido($this->form_valido))
            {
                unset($dados['btn_atualizar']);

                try {
                    parent::implementar("UPDATE estoque SET id =:id, produto_id =:produto_id, quantidade =:quantidade WHERE id =:id",$dados);
                    $msg = "Produto no estoque atualizado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
                  
                    $msg = "Não foi possivel atualizar o produto no estoque, tente novamente!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    header("Location:". URL . "estoque/editar/&id=". $dados['id']);
                    exit();
                }
                
            }

            else{
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "estoque/editar/&id=". $dados['id']);
                exit();
            }
        }
        else{
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "estoque/editar/&id=". $dados['id']);
            exit();
        }
    }
}
