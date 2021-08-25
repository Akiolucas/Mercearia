<?php 
    namespace App\Model;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Produtos extends Model
    {
        private $form_obrigatorio = array('id','nome','preco','fornecedor_id','codigo_id','kilograma','dt_registro','btn_atualizar');
        private array $form_valido;
        public function listar(): array
        {
            $listar = parent::projetarTodos(
            "SELECT p.id, p.nome, p.preco AS preço, f.nome AS fornecedor, c.barra AS código, p.kilograma, p.dt_registro
            FROM produto p
            INNER JOIN fornecedor f
            ON p.fornecedor_id = f.id
            INNER JOIN codigo c
            ON p.codigo_id = c.id");

            return $listar;
        }

        public function editar($id): array
        {
            $produto = parent::projetarExpecifico(
            "SELECT p.id, p.nome, p.preco AS preço, f.nome AS fornecedor, c.barra AS código, p.kilograma, p.dt_registro
            FROM produto p
            INNER JOIN fornecedor f
            ON p.fornecedor_id = f.id
            INNER JOIN codigo c
            ON p.codigo_id = c.id
            WHERE p.id = :id LIMIT 1",$id,false);

            if(!empty($produto)){
                return $produto;
            }
            $msg = "Produto não encontrado";
            $_SESSION['msg'] = parent::alertaFalha($msg);
            header("location:". URL . "produtos/index");
            exit();
        }
        public function atualizar($dados)
        {
            if(parent::existeCamposFormulario($dados,$this->form_obrigatorio)){
                array_push($this->form_valido,
                parent::valida_int(array($dados['id'],$dados['codigo_id'])),
                parent::valida_date(array($dados['dt_registro'])),
                parent::valida_float(array($dados['preco'],$dados['kilograma']))
                );
                var_dump($this->form_valido);
                exit();
            }

        }
        public function listarFornecedor()
        {
            $fornecedores = parent::projetarTodos("SELECT id, nome FROM fornecedor");
            return $fornecedores;
        }
        
        public function excluir()
        {

        }
    }

    
?>