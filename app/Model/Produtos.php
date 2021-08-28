<?php 
    namespace App\Model;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Produtos extends Model
    {
        private  array $form_obrigatorio;
        private int $form_obrigatorio_quantidade;
        private array $form_valido = array();
        public function listar(): array
        {
            $listar = parent::projetarTodos(
            "SELECT p.id, p.nome, p.preco AS preco, f.nome AS fornecedor, c.barra AS codigo, p.kilograma, e.quantidade AS estoque, p.dt_registro
            FROM produto p
            INNER JOIN fornecedor f
            ON p.fornecedor_id = f.id
            INNER JOIN codigo c
            ON p.codigo_id = c.id
            INNER JOIN estoque e
            ON p.id = e.produto_id");

            return $listar;
        }

        public function editar($id): array
        {
            $produto = parent::projetarExpecifico(
            "SELECT p.id, p.nome, p.preco, p.fornecedor_id, f.nome AS fornecedor, p.codigo_id, c.barra AS codigo, p.kilograma, p.dt_registro
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
        
        public function atualizar($dados): void
        {   
            $this->form_obrigatorio = array('id','nome','preco','fornecedor_id','codigo_id','kilograma','dt_registro','btn_atualizar');
            $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

            if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade)){
                array_push($this->form_valido,
                parent::valida_int(array($dados['id'],$dados['codigo_id'])),
                parent::valida_date(array($dados['dt_registro'])),
                parent::valida_float(array($dados['preco'],$dados['kilograma']))
                );

                if(parent::formularioValido($this->form_valido))
                {
                    $dados['dt_registro'] = date('Y-m-d H:i:s');
                    unset($dados['btn_atualizar']);

                    parent::implementar(
                    "UPDATE produto 
                    SET
                    nome =:nome,
                    preco = :preco,
                    fornecedor_id = :fornecedor_id,
                    codigo_id = :codigo_id,
                    kilograma = :kilograma,
                    dt_registro = :dt_registro
                    WHERE id = :id",
                    $dados);

                    $msg = "Produto atualizado com sucesso";
                    $_SESSION['msg'] = parent::alertaSucesso($msg);
                }
                else{
                    $msg = "Não foi possível atualizar o produto tente novamente";
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                    header("location:". URL . "produtos/editar/&id=". $dados['id']);
                    exit();
                }
            }

        }

        public function listarFornecedor(): array
        {
            $fornecedores = parent::projetarTodos("SELECT id, nome FROM fornecedor");
            return $fornecedores;
        }

        public function cadastrar($dados): void
        {
            $this->form_obrigatorio = array('nome','preco','fornecedor_id','kilograma','quantidade','btn_cadastrar');
            $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

            if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
            {
                array_push($this->form_valido,
                parent::valida_int(array($dados['fornecedor_id'],$dados['quantidade'])),
                parent::valida_float(array($dados['preco'],$dados['kilograma']))    
                );
                
                if(parent::formularioValido($this->form_valido))
                {
                    unset($dados['btn_cadastrar']);
                    $cadastrar = parent::projetarExpecifico(
                        "CALL cadastrar_codigo_produto_estoque(
                           :nome, :preco, :fornecedor_id, :kilograma, :quantidade
                        )",$dados,true
                    );
                   
                    switch ($cadastrar['Mensagem']) {
                        case 'Erro ao inserir na tabela de código':
                            $msg = 'Não foi possível cadastrar, erro no código do produto';
                            $resultado = false;
                            break;

                        case 'Erro ao inserir na tabela de produto':
                            $msg = 'Não foi possível cadastrar, erro nos detalhes do produto';
                            $resultado = false;
                            break;

                        case 'Erro ao inserir na tabela de estoque':
                            $msg = 'Não foi possível cadastrar, preencha corretamente a quantidade';
                            $resultado = false;
                            break;

                        case 'Cadastro efetuado com sucesso':
                            $msg = 'Cadastro efetuado com sucesso';
                            $resultado = true;
                            break;

                        case 'Preencha todos os campos e tente novamente!';
                            $msg = 'Preencha todos os campos e tente novamente!';
                            $resultado = false;
                            break;

                        default:
                            $msg = 'Falha ao cadastrar tente novamente mais tarde!';
                            $resultado = false;
                            break;
                    }
                    if($resultado){
                        $_SESSION['msg'] = parent::alertaSucesso($msg);
                    }
                    else{
                        $_SESSION['msg'] = parent::alertaFalha($msg);
                    }
                    
                }
                else{
                    $msg = "Não foi possível cadastrar o produto tente novamente!";
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                }
            }
        }
        
        public function excluir()
        {

        }
    }

    
?>