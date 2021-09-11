<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Nivel extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listar(): array
    {   
        $listar = parent::projetarTodos("SELECT id, nome FROM nivel");
        return $listar;
    }

    public function editar($id): array
    {
        $nivel = parent::projetarExpecifico(
            "SELECT id, nome FROM nivel
            WHERE id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($nivel)) {
            return $nivel;
        }
        $msg = "Nível não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "nivel/index");
        exit();
    }

    public function cadastrar($dados): void
    {
        $this->form_obrigatorio = array('nome', 'btn_cadastrar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)){

            $this->form_valido = array(parent::valida_tamanho($dados['nome'],'nome','*Informe um nome, limite 7 caracteres',7,1));

            if (parent::formularioValido($this->form_valido)) 
            {
                unset($dados['btn_cadastrar']);
                $dados['id'] = NULL;

                try {
                    parent::implementar("INSERT INTO nivel VALUES (:id, :nome)", $dados);
                    $msg = "Nível cadastrado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    unset($_SESSION['form']);

                } catch (PDOException $e) {
                    $_SESSION['form'] = $dados;
                    $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                    $msg = "Não foi possível cadastrar o nível, verifique os dados e tente novamente!";
                    $_SESSION['alerta'] = parent::alertaFalha($msg);
                }
            }
            else {
                $_SESSION['form'] = $dados;
                $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                $msg = "Não foi possível cadastrar o nível, verifique os dados e tente novamente!";
                $_SESSION['alerta'] = parent::alertaFalha($msg);
            }
        }
        else{
            $_SESSION['form'] = $dados;
            $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
            $msg = "Não foi possível cadastrar o nível, verifique os dados e tente novamente!";
            $_SESSION['alerta'] = parent::alertaFalha($msg);
        }
    }

    public function excluir($id): void
    {

       array_push($this->form_valido,parent::valida_int($id,'id','*Id inválido',1));

       if(parent::formularioValido($this->form_valido))
       {
           try {
               parent::implementar("DELETE FROM nivel WHERE id = :id",$id);

               $msg = "Nível excluído com sucesso!";
               $_SESSION['msg'] = parent::alertaSucesso($msg);
               header("Location:". URL . "nivel/index");
               exit();
           } catch (PDOException $e) {

            $msg = "Não foi possivel excluir o nível!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "nivel/index");
            exit();
           }
       }

       else{
        $msg = "Não foi possivel excluir o nível, verifique os dados e tente novamente!";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("Location:". URL . "nivel/index");
        exit();
       }
    }

    public function atualizar($dados): void
    {
        $this->form_obrigatorio = array('id','nome','btn_atualizar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
            array_push($this->form_valido,
            parent::valida_int($dados['id'],'id','*Id inválido',1),
            parent::valida_tamanho($dados['nome'],'nome','*Informe um nome, limite 7 caracteres',7,1));

            if(parent::formularioValido($this->form_valido))
            {
                unset($dados['btn_atualizar']);
                try {
                    parent::implementar("UPDATE nivel SET id =:id, nome =:nome WHERE id =:id",$dados);
                    $msg = "Nível atualizado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
            
                    $msg = "Não foi possivel atualizar o nível, tente novamente!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    header("Location:". URL . "nivel/editar/&id=". $dados['id']);
                    exit();
                }
                
            }

            else{
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "nivel/editar/&id=". $dados['id']);
                exit();
            }
        }
        else{
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "nivel/editar/&id=". $dados['id']);
            exit();
        }
    }
}
