<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Pagina_privada extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listar(): array
    {   
        $listar = parent::projetarTodos("SELECT id, nome, dt_registro FROM pg_privada");
        return $listar;
    }

    public function editar($id): array
    {
        $pg_privada = parent::projetarExpecifico(
            "SELECT id, nome FROM pg_privada
            WHERE id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($pg_privada)) {
            return $pg_privada;
        }
        $msg = "Página privada não encontrada!";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "pagina_privada/index");
        exit();
    }

    public function cadastrar($dados): void
    {
        $this->form_obrigatorio = array('nome', 'btn_cadastrar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)){

            array_push($this->form_valido,parent::valida_tamanho($dados['nome'],'nome','*Preencha este campo, limite 30 caracteres',30,1));

            if (parent::formularioValido($this->form_valido)) 
            {
                unset($dados['btn_cadastrar']);
                $dados['id'] = NULL;
                $dados['dt_registro'] = date('Y-m-d H:i:s');

                try {
                    parent::implementar("INSERT INTO pg_privada VALUES (:id, :nome, :dt_registro)", $dados);
                    $msg = "Página privada cadastrada com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    unset($_SESSION['form']);

                } catch (PDOException $e) {
                    
                    $_SESSION['form'] = $dados;
                    $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                    $msg = "Não foi possível cadastrar a página privada!";
                    $_SESSION['alerta'] = parent::alertaFalha($msg);
                }
            }
            else {
                $_SESSION['form'] = $dados;
                $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                $msg = "Não foi possível cadastrar a página privada, verifique os dados e tente novamente!";
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

       array_push($this->form_valido,parent::valida_int($id,'id','*Id inválido',1));

       if(parent::formularioValido($this->form_valido))
       {
           try {
               parent::implementar("DELETE FROM pg_privada WHERE id = :id",$id);

               $msg = "Página privada excluída com sucesso!";
               $_SESSION['msg'] = parent::alertaSucesso($msg);
               header("Location:". URL . "pagina_privada/index");
               exit();

           } catch (PDOException $e) {

            $msg = "Não foi possivel excluir a página privada!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "pagina_privada/index");
            exit();
           }
       }

       else{
        $msg = "Não foi possivel excluir a página privada, verifique os dados e tente novamente!";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("Location:". URL . "pagina_privada/index");
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
            parent::valida_tamanho($dados['nome'],'nome','*Preencha este campo, limite 30 caracteres',30,1));

            if(parent::formularioValido($this->form_valido))
            {
                unset($dados['btn_atualizar']);
                $dados['dt_registro'] = date('Y-m-d H:i:s');

                try {
                    parent::implementar("UPDATE pg_privada SET id =:id, nome =:nome, dt_registro =:dt_registro WHERE id =:id",$dados);
                    $msg = "Página privada atualizada com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
            
                    $msg = "Não foi possivel atualizar a página privada, tente novamente!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    header("Location:". URL . "pagina_privada/editar/&id=". $dados['id']);
                    exit();
                }
                
            }

            else{
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "pagina_privada/editar/&id=". $dados['id']);
                exit();
            }
        }
        else{
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "pagina_privada/editar/&id=". $dados['id']);
            exit();
        }
    }
}
