<?php

namespace App\Model;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Login extends Model
{
    private array $obrigatorio = ['credencial', 'senha', 'btnAcessar'];
    private $usuario;
    private array $credencial;
    private bool $formularioValido;
    private bool $resultado = false;

    public function login($dadosFormulario) : void
    {
        $this->credencial['credencial'] = $dadosFormulario['credencial'];

        $this->formularioValido = parent::existeCamposFormulario($dadosFormulario,$this->obrigatorio);
        
        if($this->formularioValido)
        { 
            
            $this->usuario = parent::projetarExpecifico(
                "SELECT f.id, f.nome, c.nome AS cargo , f.credencial, f.senha
                FROM funcionario f 
                INNER JOIN cargo c
                ON f.cargo_id = c.id
                WHERE credencial = :credencial LIMIT 1", $this->credencial);

            if($this->usuario)
            {
                $this->validaUsuario($dadosFormulario['senha'], $this->usuario['senha']);
            }
        } 
    }

    public function getResultado()
    {
       return $this->resultado;
    }

    private function validaUsuario($senha, $senhabd)
    {
        if(password_verify($senha, $senhabd))
        {
            $_SESSION['usuario_id'] = $this->usuario['id'];
            $_SESSION['usuario_nome'] = $this->usuario['nome'];
            $_SESSION['usuario_cargo'] = $this->usuario['cargo'];
            $msg = parent::alertaSucesso("Bem vindo " . $_SESSION['usuario_nome']);
            $_SESSION['msg'] = $msg;
            $this->resultado = true;
        }
    }

}

?>