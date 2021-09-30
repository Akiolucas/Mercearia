<?php 
    namespace App\Model;
    use PDOException;

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
            "SELECT p.id, p.nome, p.preco, f.nome AS fornecedor, c.barra AS codigo, p.kilograma,p.litro, e.quantidade AS estoque, p.dt_registro
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
            "SELECT p.id, p.nome, p.preco, p.fornecedor_id, f.nome AS fornecedor, p.codigo_id, c.barra AS codigo, p.kilograma, p.litro, e.quantidade AS quantidade, p.dt_registro
            FROM produto p 
            INNER JOIN fornecedor f
            ON p.fornecedor_id = f.id
            INNER JOIN codigo c
            ON p.codigo_id = c.id
            INNER JOIN estoque e
            ON p.id = e.produto_id
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
            $this->form_obrigatorio = array('id','nome','preco','fornecedor_id','codigo_id','litro','kilograma','quantidade','btn_atualizar');
            $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

            if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
            {
                array_push($this->form_valido,
                parent::valida_int($dados['id'],'id','*Id inválido!',1),
                parent::valida_tamanho($dados['nome'],'nome','*Preencha este campo, limite 30 caracteres!',30,1),
                parent::valida_float($dados['preco'],'preco','*Informe o preço corretamente, mínimo R$ 0,10!',0.10),
                parent::valida_int($dados['fornecedor_id'],'fornecedor_id','*Id inválido!',1),
                parent::valida_int($dados['codigo_id'],'codigo_id','*Código_id inválido!',1),
                parent::valida_float($dados['litro'],'litro','*Informe o litro corretamente, mínimo 0,000 L',0.000),
                parent::valida_float($dados['kilograma'],'kilograma','*Informe o kilograma corretamente, mínimo 0,000 kg',0.000),
                parent::valida_int($dados['quantidade'],'quantidade','*Quantidade informada inválida!',0)
                );

                if(parent::formularioValido($this->form_valido))
                {
                    unset($dados['btn_atualizar']);
                    $dados['preco'] = parent::converteFloat($dados['preco']);
                    $dados['litro'] = parent::converteFloat($dados['litro']);
                    $dados['kilograma'] = parent::converteFloat($dados['kilograma']);

                    $atualizar = parent::projetarExpecifico(
                    "CALL atualizar_produto_estoque
                    (:id, :nome, :preco, :fornecedor_id, :codigo_id, :kilograma, :litro, :quantidade)",
                    $dados,true);

                    switch ($atualizar['Mensagem']) {
                        case 'Erro ao atualizar na tabela produto':
                            $msg = 'Erro ao atualizar o produto tente novamente';
                            $resultado = false;
                            break;

                        case 'Erro ao atualizar no estoque':
                            $msg = 'Erro ao atualizar quantidade no estoque';
                            $resultado = false;
                            break;

                        case 'Produto atualizado com sucesso':
                            $msg = 'Produto atualizado com sucesso';
                            $resultado = true;
                            break;

                        case 'Preencha todos os campos e tente novamente!';
                            $msg = 'Preencha todos os campos e tente novamente!';
                            $resultado = false;
                        break;

                        default:
                            $msg = 'Falha ao atualizar tente novamente mais tarde!';
                            $resultado = false;
                            break;
                    }

                    if($resultado)
                    {
                        $_SESSION['msg'] = parent::alertaSucesso($msg);
                    }
                    else{
                        $_SESSION['msg'] = parent::alertaFalha($msg);
                        header("location:". URL . "produtos/editar/&id=". $dados['id']);
                        exit();
                    }

                }
                else{
                    $msg = "Não foi possível atualizar o produto tente novamente";
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                    header("location:". URL . "produtos/editar/&id=". $dados['id']);
                    exit();
                }
            }
            else{
                $msg = "Preecha todos os campos corretamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("location:". URL . "produtos/editar/&id=". $dados['id']);
                exit();
            }

        }

        public function listarFornecedor(): array
        {
            $fornecedores = parent::projetarTodos("SELECT id, nome FROM fornecedor");
            return $fornecedores;
        }

        public function cadastrar($dados): void
        {
            $this->form_obrigatorio = array('nome','preco','fornecedor_id','kilograma','litro','quantidade','btn_cadastrar');
            $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

            if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
            {
                array_push($this->form_valido,
                parent::valida_tamanho($dados['nome'],'nome','*Preencha este campo, limite 30 caracteres!',30,1),
                parent::valida_float($dados['preco'],'preco','*Informe o preço corretamente, mínimo R$ 0,10!',0.10),
                parent::valida_int($dados['fornecedor_id'],'fornecedor_id','*Id inválido!',1),
                parent::valida_float($dados['litro'],'litro','*Informe o litro corretamente, mínimo 0,000 L',0.000),
                parent::valida_float($dados['kilograma'],'kilograma','*Informe o kilograma corretamente, mínimo 0,000 kg',0.000),
                parent::valida_int($dados['quantidade'],'quantidade','*Quantidade informada inválida!',1)
                );
                
                if(parent::formularioValido($this->form_valido))
                {
                    unset($dados['btn_cadastrar']);
                    $dados['preco'] = parent::converteFloat($dados['preco']);
                    $dados['litro'] = parent::converteFloat($dados['litro']);
                    $dados['kilograma'] = parent::converteFloat($dados['kilograma']);
                    
                    $cadastrar = parent::projetarExpecifico(
                        "CALL cadastrar_codigo_produto_estoque(
                           :nome, :preco, :fornecedor_id, :kilograma, :litro, :quantidade
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
                            $msg = 'Preencha todos os campos e tente novamente<>!';
                            $resultado = false;
                            break;

                        default:
                            $msg = 'Falha ao cadastrar tente novamente mais tarde!';
                            $resultado = false;
                            break;
                    }
                    if($resultado){
                        $_SESSION['msg'] = parent::alertaSucesso($msg);
                        unset($_SESSION['form']);
                    }
                    else{
                        $_SESSION['form'] = $dados;
                        $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                        $_SESSION['alerta'] = parent::alertaFalha($msg);
                    }
                    
                }
                else{
                    $_SESSION['form'] = $dados;
                    $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                    $msg = "Não foi possível cadastrar o produto tente novamente!";
                    $_SESSION['alerta'] = parent::alertaFalha($msg);
                }
            }
            else{
                $_SESSION['form'] = $dados;
                $_SESSION['script'] = "<script>$('#modalCadastrar').modal('show');</script>";
                $msg = "Preencha todos os campos e tente novamente!";
                $_SESSION['alerta'] = parent::alertaFalha($msg);
            }
        }
        
        public function excluir($id)
        {
            array_push($this->form_valido,parent::valida_int($id,'id','*Id inválido',1));

            if(parent::formularioValido($this->form_valido))
            {
                try {
                parent::implementar("DELETE FROM produto WHERE id = :id",$id);
                parent::implementar("DELETE FROM codigo WHERE id = :id",$id);
                $msg = "Produto excluído com sucesso!";
                $_SESSION['msg'] = parent::alertaSucesso($msg);
                header("location:" . URL . "produtos/index");
                exit();

                } catch (PDOException $e) {
                $msg = "Não foi possivel excluir o produto tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("location:" . URL . "produtos/index");
                exit();
                }
            }
            else{
                $msg = "Não foi possível excluir o produto, verifique os dados e tente novamente!";
                $_SESSION['msg'] = parent::alertaFalha($msg);
                header("Location:". URL . "produtos/index");
                exit();
            }
            
        }
    }

    
?>