<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Fornecedor extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listar(): array
    {
        $listar = parent::projetarTodos(
            "SELECT id, nome, cnpj, dt_registro FROM fornecedor ORDER BY dt_registro DESC"
        );

        return $listar;
    }

    public function editar($id): array
    {
        $fornecedor = parent::projetarExpecifico(
            "SELECT id, nome, cnpj FROM fornecedor
            WHERE id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($fornecedor)) {
            return $fornecedor;
        }
        $msg = "Fornecedor não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "fornecedor/index");
        exit();
    }

    public function cadastrar($dados): void
    {
        $this->form_obrigatorio = array('nome', 'cnpj', 'btn_cadastrar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)){
            array_push($this->form_valido, $this->validaCnpj($dados['cnpj']));

            if (parent::formularioValido($this->form_valido)) 
            {
                unset($dados['btn_cadastrar']);
                $dados['id'] = NULL;
                $dados['dt_registro'] = date('Y-m-d H:i:s');

                try {
                    parent::implementar("INSERT INTO fornecedor VALUES (:id, :nome, :cnpj, :dt_registro)", $dados);
                    $msg = "Fornecedor cadastrado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
                    $msg = "Não foi possível cadastrar o fornecedor!";
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                }
            }
            else {
                $msg = "Não foi possível cadastrar o fornecedor, verifique os dados e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
            }
        }
        else{
            $msg = "Preencha todos os campos corretamente e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
        }
    }

    private function validaCnpj($cnpj): bool
    {
        if (strlen($cnpj) != 18) {
            return false;
        }
        return true;
    }

    public function excluir($id): void
    {

       array_push($this->form_valido,parent::valida_int($id));

       if(parent::formularioValido($this->form_valido))
       {
           try {
               parent::implementar("DELETE FROM fornecedor WHERE id = :id",$id);

               $msg = "Fornecedor excluído com sucesso!";
               $_SESSION['msg'] = parent::alertaSucesso($msg);
               header("Location:". URL . "fornecedor/index");
               exit();
           } catch (PDOException $e) {

            $msg = "Não foi possivel excluir o fornecedor!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "fornecedor/index");
            exit();
           }
       }

       else{
        $msg = "Não foi possivel excluir o fornecedor, verifique os dados e tente novamente!";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("Location:". URL . "fornecedor/index");
        exit();
       }
    }

    public function atualizar($dados): void
    {
        $this->form_obrigatorio = array('id','nome','cnpj','btn_atualizar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
            array_push($this->form_valido,parent::valida_int(array($dados['id'])),$this->validaCnpj($dados['cnpj']));

            if(parent::formularioValido($this->form_valido))
            {
                unset($dados['btn_atualizar']);
                $dados['dt_registro'] = date('Y-m-d H:i:s');

                try {
                    parent::implementar("UPDATE fornecedor SET id =:id, nome =:nome, cnpj =:cnpj, dt_registro =:dt_registro WHERE id =:id",$dados);
                    $msg = "Fornecedor atualizado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {
            
                    $msg = "Não foi possivel atualizar o fornecedor, tente novamente!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    header("Location:". URL . "fornecedor/editar/&id=". $dados['id']);
                    exit();
                }
                
            }

            else{
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "fornecedor/editar/&id=". $dados['id']);
                exit();
            }
        }
        else{
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "fornecedor/editar/&id=". $dados['id']);
            exit();
        }
    }
}
