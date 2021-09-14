<?php

namespace App\Model;

use App\Controller\Controller;
use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Perfil extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listar($id)
    {
        $perfil = parent::projetarExpecifico(
            "SELECT f.nome, c.nome AS cargo, n.nome AS nivel
            FROM funcionario f
            INNER JOIN cargo c
            ON f.cargo_id = c.id
            INNER JOIN nivel n
            ON f.nivel_id = n.id
            WHERE f.id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($perfil)) {
            return $perfil;
        }
        $msg = "Perfil não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "index");
        exit();
    }

    public function editar($id): array
    {
        $perfil = parent::projetarExpecifico(
            "SELECT id, nome, credencial, senha FROM funcionario
            WHERE id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($perfil)) {
            return $perfil;
        }
        $msg = "Perfil não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "index");
        exit();
    }

    public function atualizar($dados): void
    {
        $this->form_obrigatorio = array('credencial','senha','senhaAtual','senhaRepetida','btn_atualizar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
            $dados['id'] = $_SESSION['usuario_id'];
            array_push($this->form_valido,
            parent::valida_int($dados['id'],'id','*Id inválido',1),
            parent::valida_tamanho($dados['credencial'],'credencial','*Preencha corretamente esse campo, deve conter entre 8 a 20 caracteres!',20,8),
            parent::valida_tamanho($dados['senhaAtual'],'senhaAtual','*Senha inválida!',64,8),
            parent::valida_tamanho($dados['senha'],'senha','*Informe a nova senha, deve conter entre 8 a 64 caracteres!',64,8),
            parent::valida_tamanho($dados['senhaRepetida'],'senhaRepetida','*Repita a nova senha, deve conter entre 8 a 64 caracteres!',64,8));

            if(parent::formularioValido($this->form_valido))
            {
                $senhas = array(
                    'senha' => $dados['senha'],
                    'senhaAtual' => $dados['senhaAtual'],
                    'senhaRepetida' => $dados['senhaRepetida']
                );
                $this->form_valido = array();
                array_push($this->form_valido,
                $this->validaCredencial(array('credencial'=> $dados['credencial'])),
                $this->validaSenha($senhas)
                );
                
                if(parent::formularioValido($this->form_valido))
                {
                    unset(
                    $dados['btn_atualizar'],
                    $dados['senhaAtual'],
                    $dados['senhaRepetida']);

                    try {
                        $dados['senha'] = password_hash($dados['senha'],PASSWORD_DEFAULT);

                        parent::implementar("UPDATE funcionario SET id =:id, credencial =:credencial, senha =:senha WHERE id =:id",$dados);
                        header("Location:". URL .'sair/index');
                        exit();
    
                    } catch (PDOException $e) {
                
                        $_SESSION['form'] = $dados;
                        $msg = "Não foi possivel atualizar os dados pessoais, tente novamente!";
                        $_SESSION['msg'] = parent::alertaFalha($msg);
                        header( "Location:". URL . "perfil/editar");
                        exit();
                    }
                }
                else
                {
                    $_SESSION['form'] = $dados;
                    $msg = "Preencha corretamente todos os campos e tente novamente!";
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                    header("Location:". URL . "perfil/editar");
                    exit();
                }
               
                
            }

            else{
                $_SESSION['form'] = $dados;
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "perfil/editar");
                exit();
            }
        }
        else{
            $_SESSION['form'] = $dados;
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:". URL . "perfil/editar");
            exit();
        }
    }

    private function validaCredencial($dados): bool
    {
        $id['id'] = $_SESSION['usuario_id'];
        $usuario = $this->editar($id);
        
        if($dados['credencial'] != $usuario[0]['credencial'])
        {
            $usuario = parent::projetarExpecifico(
            'SELECT credencial FROM funcionario WHERE credencial = :credencial LIMIT 1',$dados);
        
            if(!empty($usuario))
            {
                $_SESSION['Erro_form']['credencial'] = 'Essa credencial já existe, informe outra!';
                return false;
            }
            else{
                return true;
            }
        }

        else{
            return true;
        }

    }
    private function validaSenha($dados) : bool
    {
        $id['id'] = $_SESSION['usuario_id'];
        $usuario = $this->editar($id);

        if(password_verify($dados['senhaAtual'],$usuario[0]['senha']))
        {
            if($dados['senhaRepetida'] == $dados['senha'])
            {
                return true;
            }
            else{
                $_SESSION['Erro_form']['senhaRepetida'] = 'Senha diferente, informe novamente!';
                return false;
            }
        }
        
        else{
            $_SESSION['Erro_form']['senhaAtual'] = 'Senha inválida, tente novamente';
            return false;
        }
        
    }
}
