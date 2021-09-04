<?php

namespace App\Model;

use PDOException;

if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Funcionario extends Model
{
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();
    private int $funcionario_id;
    private array $funcionario_paginas;

    public function listar(): array
    {
        $listar = parent::projetarTodos(
            "SELECT f.id, f.nome, c.nome AS cargo, f.ativo, n.nome AS acesso, f.dt_registro
             FROM funcionario f
             INNER JOIN cargo c
             ON f.cargo_id = c.id
             INNER JOIN nivel n
             ON f.nivel_id = n.id"
        );

        return $listar;
    }

    public function editar($id): array
    {
        $funcionario = parent::projetarExpecifico(
           "SELECT f.id, f.nome, f.cargo_id, c.nome AS cargo, f.nivel_id, n.nome AS nivel, f.ativo
            FROM funcionario f
            INNER JOIN cargo c
            ON f.cargo_id = c.id
            INNER JOIN nivel n
            ON f.nivel_id = n.id
            WHERE f.id = :id LIMIT 1",
            $id,
            false
        );

        if (!empty($funcionario)) {
            return $funcionario;
        }
        $msg = "Funcionário não encontrado";
        $_SESSION['msg'] = parent::alertaFalha($msg);
        header("location:" . URL . "funcionario/index");
        exit();
    }

    public function cadastrar($dados): void
    {

        $this->form_obrigatorio = array('nome', 'ativo', 'cargo_id', 'nivel_id', 'credencial', 'senha', 'pg_privada_id', 'btn_cadastrar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)) {
            $this->form_valido = array(
                parent::valida_tamanho(array($dados['nome'], $dados['credencial'], $dados['senha']), array(70, 20, 12)),
                parent::valida_bool(array($dados['ativo'])),
                parent::valida_int(array($dados['cargo_id'], $dados['nivel_id'])),
                parent::valida_int($dados['pg_privada_id'])
            );

            if (parent::formularioValido($this->form_valido)) {
                unset($dados['btn_cadastrar']);
                $dados['id'] = NULL;
                $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
                $dados['dt_registro'] = date('Y-m-d H:i:s');
                $this->funcionario_paginas = $dados['pg_privada_id'];
                unset($dados['pg_privada_id']);

                $this->conn->beginTransaction();
                try{

                    parent::implementar(
                        "INSERT INTO funcionario 
                        VALUES (:id, :nome, :cargo_id, :nivel_id, :credencial, :senha, :ativo, :dt_registro)", $dados);

                    $this->funcionario_id = intval($this->conn->lastInsertId());

                    foreach ($this->funcionario_paginas as $pagina) {
                        $id_funcionario_pagina = array(
                            'funcionario_id' => $this->funcionario_id,
                            'pg_privada_id' => $pagina,
                            'dt_registro' => date('Y-m-d H:i:s')
                        );

                        parent::implementar("INSERT INTO funcionario_pg_privada VALUES (:funcionario_id, :pg_privada_id, :dt_registro)", $id_funcionario_pagina);
                    };

                    $msg = "Funcionário cadastrado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    $this->conn->commit();
                }
                catch(PDOException $e){
                    $this->conn->rollBack();
                    $msg = "Não foi possível cadastrar o funcionário!";
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                }
                
            } else {
                $msg = "Não foi possível cadastrar o funcionário, verifique os dados e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
            }
        } else {
            $msg = "Preencha todos os campos corretamente e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
        }
    }

    public function excluir($id): void
    {
        array_push($this->form_valido, parent::valida_int($id));

        if (parent::formularioValido($this->form_valido)) {
            try {
                parent::implementar("DELETE FROM funcionario WHERE id = :id", $id);

                $msg = "Funcionário excluído com sucesso!";
                $_SESSION['msg'] = parent::alertaSucesso($msg);
                header("Location:" . URL . "funcionario/index");
                exit();
            } catch (PDOException $e) {

                $msg = "Não foi possivel excluir o funcionário!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:" . URL . "funcionario/index");
                exit();
            }
        } else {
            $msg = "Não foi possivel excluir o funcionário, verifique os dados e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:" . URL . "funcionario/index");
            exit();
        }
    }

    public function atualizar($dados): void
    {
        $this->form_obrigatorio = array('id', 'nome','cargo_id','nivel_id','ativo','btn_atualizar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)) {
            array_push($this->form_valido, 
            parent::valida_int(array($dados['id'],$dados['cargo_id'],$dados['nivel_id']),
            parent::valida_tamanho(array($dados['nome']), array(70))),
            parent::valida_bool(array($dados['ativo'])));
            
            if (parent::formularioValido($this->form_valido)) {
                unset($dados['btn_atualizar']);
                $dados['dt_registro'] = date('Y-m-d H:i:s');
                try {
                    parent::implementar(
                    "UPDATE funcionario SET
                    id =:id, nome =:nome, cargo_id = :cargo_id, nivel_id = :nivel_id, ativo = :ativo, dt_registro = :dt_registro
                    WHERE id =:id", $dados);

                    $msg = "Funcionário atualizado com sucesso!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);

                } catch (PDOException $e) {

                    $msg = "Não foi possivel atualizar o funcionário, tente novamente!";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                    header("Location:" . URL . "funcionario/editar/&id=" . $dados['id']);
                    exit();
                }
            } else {
                $msg = "Preencha corretamente todos os campos e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:" . URL . "funcionario/editar/&id=" . $dados['id']);
                exit();
            }
        } else {
            $msg = "Não foi possivel atualizar, verifique todos os campos e tente novamente!";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("Location:" . URL . "funcionario/editar/&id=" . $dados['id']);
            exit();
        }
    }

    public function listarDadosAjax()
    {
        try {
            $dados['cargo'] = parent::projetarTodos("SELECT id, nome FROM cargo");
            $dados['nivel'] = parent::projetarTodos("SELECT id, nome FROM nivel");
            $dados['pagina'] = parent::projetarTodos("SELECT id, nome FROM pg_privada");
            return $dados;
        } catch (PDOException $e) {
            $msg = "Não foi possivel carregar os dados dos funcionários, caso o problema persistir entre em contato com o desenvolvedor";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            exit();
        }
    }

    public function listarDetalhesAjax()
    {
        try {
            $dados['cargo'] = parent::projetarTodos("SELECT id, nome FROM cargo");
            $dados['nivel'] = parent::projetarTodos("SELECT id, nome FROM nivel");
            return $dados;
        } catch (PDOException $e) {
            $msg = "Não foi possivel carregar os dados dos funcionários, caso o problema persistir entre em contato com o desenvolvedor";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            exit();
        }
    }
}
