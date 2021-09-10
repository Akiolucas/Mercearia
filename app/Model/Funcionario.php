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

            $paginas_privadas = array();
            foreach($dados['pg_privada_id'] as $item)
            {   
                array_push($paginas_privadas,parent::valida_int($item,'pg_privada_id','*Selecione pelo menos uma opção',0));
            }

            if(parent::formularioValido($paginas_privadas))
            {
                $this->form_valido = array(
                    parent::valida_tamanho($dados['nome'],'nome','*O limite máximo permitido é 70 caracteres',70,0),
                    parent::valida_tamanho($dados['credencial'],'credencial','*A credencial deve conter entre 8 a 20 caracteres',20,8),
                    parent::valida_tamanho($dados['senha'],'senha','*A senha deve conter entre 8 a 64 caracteres',64,8),
                    parent::valida_bool($dados['ativo'],'ativo','*Selecione uma opção'),
                    parent::valida_int($dados['cargo_id'],'cargo_id','*Selecione uma opção',0),
                    parent::valida_int($dados['nivel_id'],'nivel_id','*Selecione uma opção',0)
                );
                if (parent::formularioValido($this->form_valido))
                {
                
                    $this->conn->beginTransaction();
                    try{
                        unset($dados['btn_cadastrar']);
                        $dados['id'] = NULL;
                        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
                        $dados['dt_registro'] = date('Y-m-d H:i:s');
                        $this->funcionario_paginas = $dados['pg_privada_id'];
                        unset($dados['pg_privada_id']);

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
                        unset($dados['senha']);
                        $_SESSION['form'] = $dados;
                        $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                        $msg = "Não foi possível cadastrar o funcionário!";
                        $_SESSION['alerta'] = parent::alertaFalha($msg);
                    }                   
                }
                else {
                    $_SESSION['form'] = $dados;
                    $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                    $msg = "Não foi possível cadastrar o funcionário, verifique os dados e tente novamente!";
                    $_SESSION['alerta'] = parent::alertaFalha($msg);
                }
            }
            else{
                $_SESSION['form'] = $dados;
                $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                $msg = "Preencha todos os campos corretamente e tente novamente!";
                $_SESSION['alerta'] = parent::alertaFalha($msg);
            }       
        } else {
            $_SESSION['form'] = $dados;
            $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
            $msg = "Preencha todos os campos corretamente e tente novamente!";
            $_SESSION['alerta'] = parent::alertaFalha($msg);
        }
    }

    public function excluir($id): void
    {
        array_push($this->form_valido, parent::valida_int($id,'funcionario_id','funcionário não encontrado',0));

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
        $this->form_obrigatorio = array('id', 'nome','cargo_id','nivel_id','ativo','pg_privada_id','btn_atualizar');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if (parent::existeCamposFormulario($dados, $this->form_obrigatorio, $this->form_obrigatorio_quantidade)) 
        {
            $paginas_privadas = array();
            foreach($dados['pg_privada_id'] as $item)
            {   
                array_push($paginas_privadas,parent::valida_int($item,'pg_privada_id','*Selecione pelo menos uma opção',0));
            }
            if(parent::formularioValido($paginas_privadas))
            {
                array_push($this->form_valido, 
                    parent::valida_int($dados['id'],'id','*id inválido',0),
                    parent::valida_int($dados['cargo_id'],'cargo_id','*selecione uma opção',0),
                    parent::valida_int($dados['nivel_id'],'nivel_id','*selecione uma opção',0),
                    parent::valida_tamanho($dados['nome'],'nome','*O limite máximo permitido é 70 caracteres',70,0),
                    parent::valida_bool($dados['ativo'],'ativo','*selecione uma opção')
                );
                
                if (parent::formularioValido($this->form_valido)) {

                    $this->conn->beginTransaction();
                    try {
                        unset($dados['btn_atualizar']);
                        $dados['dt_registro'] = date('Y-m-d H:i:s');
                        $this->funcionario_paginas = $dados['pg_privada_id'];
                        unset($dados['pg_privada_id']);

                        parent::implementar(
                        "UPDATE funcionario SET
                        id =:id, nome =:nome, cargo_id = :cargo_id, nivel_id = :nivel_id, ativo = :ativo, dt_registro = :dt_registro
                        WHERE id =:id", $dados);

                        $id_funcionario_pagina['funcionario_id'] = $dados['id'];

                        parent::implementar(
                        "DELETE FROM funcionario_pg_privada 
                        WHERE (funcionario_id = :funcionario_id)",
                        $id_funcionario_pagina);
                
                        foreach ($this->funcionario_paginas as $pagina) {

                            $id_funcionario_pagina['pg_privada_id'] = $pagina;
                            $id_funcionario_pagina['dt_registro'] = date('Y-m-d H:i:s');

                            parent::implementar(
                            "INSERT INTO funcionario_pg_privada (funcionario_id, pg_privada_id, dt_registro)
                            VALUES (:funcionario_id, :pg_privada_id, :dt_registro)",$id_funcionario_pagina);
                        
                        }
                     
                        $msg = "Funcionário atualizado com sucesso!";
                        $_SESSION['msg'] = parent::alertaSucesso($msg);
                        $this->conn->commit();

                    } catch (PDOException $e) {

                        $this->conn->rollBack();
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
            }
            else{
                $msg = "Não foi possivel atualizar, verifique as páginas de acesso!";
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

    public function listarDetalhesAjax($funcionario_id)
    {
        try {
            $id['id'] = $funcionario_id;
            $dados['cargo'] = parent::projetarTodos("SELECT id, nome FROM cargo");
            $dados['nivel'] = parent::projetarTodos("SELECT id, nome FROM nivel");
            $dados['f_paginas'] = parent::projetarExpecifico(
            "SELECT pg_privada_id AS f_paginas_id
            FROM funcionario_pg_privada
            WHERE funcionario_id = :id",$id,false);
            $dados['paginas'] = parent::projetarTodos("SELECT id, nome FROM pg_privada");

            return $dados;
        } catch (PDOException $e) {
            $msg = "Não foi possivel carregar os dados do funcionário, caso o problema persistir entre em contato com o desenvolvedor";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            exit();
        }
    }
}
