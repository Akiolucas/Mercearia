<?php
namespace App\Model;

use PDOException;
if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}

class Caixa extends Model
{   
    private  array $form_obrigatorio;
    private int $form_obrigatorio_quantidade;
    private array $form_valido = array();

    public function listaProdutosAjax($dados): array
    {
        $this->form_obrigatorio = array('pesquisa');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        $retorno = array();
        $retorno['qtd']= 0;

        if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
            array_push($this->form_valido,
            parent::valida_tamanho($dados['pesquisa'],'pesquisa','*Preencha corretamente esse campo, limite 30 caracteres',30,2));
            if(parent::formularioValido($this->form_valido))
            {
                try{
                    $produtos = parent::projetarExpecifico(
                    "SELECT p.id, p.nome, p.preco, c.barra AS codigo 
                    FROM produto p
                    INNER JOIN codigo c
                    ON p.codigo_id = c.id
                    WHERE p.id LIKE :pesquisa  OR p.nome LIKE :pesquisa OR c.barra LIKE :pesquisa LIMIT 3",$dados,false);
            
                    $retorno = array();
                    $retorno['qtd'] = count($produtos);
                    $retorno['dados']= "";
                    
                    $retorno['dados'].="<div>";
                    if($produtos != false && $produtos != 0)
                    {
                        foreach($produtos as $produto)
                        {
                            $retorno['dados'].= '<div><a href="#" id="'.$produto['id'].'" class="lista-p-caixa">'.$produto['nome'].'</a></div>';
                        }
                        $retorno['dados'].="</div>";
                        return $retorno;
                    }
                    $retorno['dados'].="</div>";
                    return $retorno;
                }
                catch(PDOException $e)
                {
                    return $retorno;
                }

            }
            else{
                return $retorno;
            }
        }
        else{
            return $retorno;
        }

    }
    public function produtoAjax($id): array
    {
        $dados = array();
        $dados['dados'] = "";
        $dados['lista']= array();
        $total= 0;

        $this->form_obrigatorio = array('id');
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);

        if(parent::existeCamposFormulario($id,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
            array_push($this->form_valido,parent::valida_int($id['id'],'id','*Id inválido',1));
            if(parent::formularioValido($this->form_valido))
            {

                if(!isset($_SESSION['caixa'][$id['id']]))
                {
                    $_SESSION['caixa'][$id['id']] = 1;
                }
                $dados['dados'].='<thead><tr><th>Id</th><th>Nome</th><th>Código</th><th>Preço</th><th>Quantidade</th><th>Subtotal</th><th>Excluir</th>';
                $dados['dados'].='</tr></thead><tbody>';

                foreach($_SESSION['caixa'] as $idProduto => $qtd)
                {
                    try{
                        $produto_id['id'] = $idProduto;
                        $produto = parent::projetarExpecifico(
                        "SELECT p.id, p.nome, p.preco, c.barra AS codigo 
                        FROM produto p
                        INNER JOIN codigo c
                        ON p.codigo_id = c.id
                        WHERE p.id = :id LIMIT 1",$produto_id,true);
                   
                        if($produto != false && $produto != "")
                        {
                            $subTotal = (floatval($produto['preco']) * $qtd);
                            $total+= $subTotal;
                            $produto['quantidade'] = $qtd;
                            $produto['subTotal'] = $subTotal;
                            array_push($dados['lista'],$produto);

                            $dados['dados'].= '<tr><td><input type="text" name="form-id" id="form-id" class="f-caixa" value="'.$produto['id'].'" readonly></td>';
                            $dados['dados'].='<td><input type="text" name="form-nome" id="form-nome" class="f-caixa" value="'.$produto['nome'].'" readonly></td>';
                            $dados['dados'].='<td><input type="text" name="form-codigo" id="form-codigo" class="f-caixa" value="'.$produto['codigo'].'" readonly</td>';
                            $dados['dados'].='<td><input type="text" name="form-preco" id="form-preco" class="f-caixa" value="R$ '.number_format($produto['preco'],2,",",'.').'" readonly</td>';
                            $dados['dados'].='<td><input type="text" id="form-quantidade" class="f-caixa"  value="'.$qtd.'" name="form-quantidade" data-value="'.$produto['id'].'"></td>';
                            $dados['dados'].="<td>"."R$ " .number_format($subTotal,2,",",'.')."</td>";
                            $dados['dados'].="<td> <a href='".URL."caixa/remover?id=".$idProduto."' class='btn btn-danger col-mb-3' id='removerItemCaixa' data-name='".$produto['nome']."'><i class='fas fa-trash-alt'></i></a></td></tr>";
                        }
                        else{
                            $dados['dados'].='<tr><td colspan="7" id="Erro21" data-erroid="'.$idProduto.'" class="text-center">Produto não encontrado: ID '.$idProduto.'!</td></tr>';
                            unset($_SESSION['caixa'][$idProduto]);
                        }
                    }
                    catch(PDOException $e){
                        $dados['dados'].='<tr><td colspan="7" id="Erro21" data-erroid="'.$idProduto.'"  class="text-center">Produto não encontrado: ID '.$idProduto.'!</td></tr>';
                        unset($_SESSION['caixa'][$idProduto]);
                    }
                }
                $dados['total'] = "R$ " .number_format($subTotal,2,",",'.');   
                $dados['dados'].= '</tbody><tfoot class="bg-info">';
                $dados['dados'].= '<tr><th colspan="5">Total</th>';
                $dados['dados'].='<th colspan="2"><input type="text" name="form-total" id="form-total" class="f-caixa" value="'.'R$ '. number_format($total,2,',','.').'" readonly></th></tr>';
                $dados['dados'].='<tr>';
                $dados['dados'].='<th colspan="3">Forma de pagamento</th><th colspan="2">';
                $dados['dados'].='<select name="form-pagamento" id="form-pagamento" class="form-control is-invalid">';
                $dados['dados'].='<option value="">--Selecione--</option>';
                $dados['dados'].='<option value="Dinheiro">Dinheiro</option>';
                $dados['dados'].='<option value="Crédito">Crédito</option>';
                $dados['dados'].='<option value="Débito">Débito</option>';
                $dados['dados'].='</select></th>';
                $dados['dados'].='<th colspan="2"><input type="text" name="form-dinheiro-cliente" class="form-control" id="form-dinheiro-cliente" aria-describedby="d-form-dinheiro-cliente"></th></tr>';
                $dados['dados'].='<tr><th colspan="5">Troco</th>';
                $dados['dados'].='<th colspan="2"><input type="text" name="form-troco" class="form-control" id="form-troco"></th></tr></tfoot>'; 

                                                    
                return $dados;
               
            }
            else{
                return $dados;
            }
        }
        else{
            return $dados;
        }
    }
}