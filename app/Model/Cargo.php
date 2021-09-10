<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Cargo extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listar(): array
    {   
        $listar = parent::projetarTodos("SELECT id, nome FROM cargo");
        return $listar;
    }

    public function editar($id): array
    {
        $cargo = parent::projetarExpecifico(
            "SELECT id, nome FROM cargo
            WHERE id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($cargo)) {
            return $cargo;
        }
        $msg = "Cargo não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "cargo/index");
        exit();
    }

    public function cadastrar($dados): void
    {
        $this->form_obrigatorio = array('nome', 'btn_cadastrar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)){

            $this->form_valido = array(parent::valida_tamanho($dados['nome'],'nome','*Informe um cargo, limite 45 caracteres',45,0));
            if (parent::formularioValido($this->form_valido)) 
            {
                unset($dados['btn_cadastrar']);
                $dados['id'] = NULL;

                try {
                    parent::implementar("INSERT INTO cargo VALUES (:id, :nome)", $dados);
                    $msg = "Cargo cadastrado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
                    $_SESSION['form'] = $dados;
                    $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                    $msg = "Não foi possível cadastrar o cargo!";
                    $_SESSION['alerta'] = parent::alertaFalha($msg);
                }
            }
            else {
                $_SESSION['form'] = $dados;
                $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                $msg = "Não foi possível cadastrar o cargo, verifique os dados e tente novamente!";
                $_SESSION['alerta'] = parent::alertaFalha($msg);
                
            }
        }
        else{
            $_SESSION['form'] = $dados;
            $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
            $msg = "Preencha todos os campos corretamente e tente novamente!";
            $_SESSION['alerta'] = parent::alertaFalha($msg);
        }
    }

    public function excluir($id): void
    {

       array_push($this->form_valido,parent::valida_int($id,'id','*Id do cargo inválido',1));

       if(parent::formularioValido($this->form_valido))
       {
           try {
               parent::implementar("DELETE FROM cargo WHERE id = :id",$id);

               $msg = "Cargo excluído com sucesso!";
               $_SESSION['msg'] = parent::alertaSucesso($msg);
               header("Location:". URL . "cargo/index");
               exit();
           } catch (PDOException $e) {

            $msg = "Não foi possivel excluir o cargo!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "cargo/index");
            exit();
           }
       }

       else{
        $msg = "Não foi possivel excluir o cargo, verifique os dados e tente novamente!";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("Location:". URL . "cargo/index");
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
            parent::valida_int($dados['id'],'id','*Id do cargo inválido',1),
            parent::valida_tamanho($dados['nome'],'nome','*Informe o nome do cargo corretamente, limite 45 caracteres',45,2));
        
            if(parent::formularioValido($this->form_valido))
            {
                unset($dados['btn_atualizar']);
                try {
                    parent::implementar("UPDATE cargo SET id =:id, nome =:nome WHERE id =:id",$dados);
                    $msg = "Cargo atualizado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
            
                    $msg = "Não foi possivel atualizar o cargo, tente novamente!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    header("Location:". URL . "cargo/editar/&id=". $dados['id']);
                    exit();
                }
                
            }

            else{
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "cargo/editar/&id=". $dados['id']);
                exit();
            }
        }
        else{
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "cargo/editar/&id=". $dados['id']);
            exit();
        }
    }
}
