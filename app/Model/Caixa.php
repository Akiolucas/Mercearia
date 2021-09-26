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
    private string $novoCliente = 'sim';
    private array $ultimo_cliente;

    public function cadastrar($dados){
       
        $this->form_obrigatorio = array(
            'produto_id','quantidade','total','subTotal','pagamento',
            'valor','troco','btn_cadastrar'
        );
        
        $this->form_obrigatorio_quantidade = count($this->form_obrigatorio);
        if(parent::existeCamposFormulario($dados,$this->form_obrigatorio,$this->form_obrigatorio_quantidade))
        {
             // remover formatação da moeda
             $dados['total'] = $this->removerFormatoDinheiro($dados['total']);
             $dados['valor'] = $this->removerFormatoDinheiro($dados['valor']);
             $dados['troco'] = $this->removerFormatoDinheiro($dados['troco']);
             
             foreach($dados['subTotal'] as $key => $value)
             {
                $dados['subTotal'][$key] = $this->removerFormatoDinheiro($value);
             }
             // fim
            //chama uma função que faz a validação de cada valor no array informado;
            $this->arrayFormValido('int',$dados['produto_id'],'produto_id','*Id inválido',1);
            $this->arrayFormValido('int',$dados['quantidade'],'quantidade','*Quantidade inválida',1);
            $this->arrayFormValido('float',$dados['subTotal'],'subTotal','subTotal inválido',1);
            //fim

            array_push($this->form_valido,
            parent::valida_float($dados['total'],'total','*Total informado inválido',0),
            parent::valida_float($dados['troco'],'troco','*Troco informado inválido',0));

            var_dump($this->form_valido,$dados);
            exit();
            if(parent::formularioValido($this->form_valido))
            { 
                // pegar valores dos produtos com base no id, informado
                $valores = [];
                foreach($dados['produto_id'] as $value)
                {
                    array_push($valores,parent::projetarExpecifico('SELECT preco FROM produto WHERE id= :id LIMIT 1',array('id'=>$value)));
                }
                
                // calcular valores 

                $total = 0;
                foreach($valores as $key => $value)
                {
                    $total += floatval($valores[$key]['preco']) * intval($dados['quantidade'][$key]);  
                }

                $dados['total'] = floatval($dados['total']);
                $total = floatval($total);
                if($dados['total'] === $total)
                {
                    // adicionar no banco de dados os produtos!
                    try{
                        $this->conn->beginTransaction();

                        $data = date('Y-m-d H:i:s');
                        
                        foreach($dados['produto_id'] as $key => $value)
                        {
                            $this->ultimo_cliente = parent::projetarTodos('SELECT cliente FROM caixa ORDER BY id DESC LIMIT 1');
                            
                            if($this->novoCliente == 'sim')
                            {
                                if(empty($this->ultimo_cliente))
                                {
                                    $this->ultimo_cliente[0]['cliente'] = 1;
                                }   
                                else{
                                    $this->ultimo_cliente[0]['cliente'] += 1;
                                }
                            }
                                try{
                                    parent::implementar(
                                        "INSERT INTO caixa (id, cliente, produto_id, quantidade, subTotal, dt_registro)
                                            VALUES(:id, :cliente, :produto_id, :quantidade, :subTotal, :dt_registro)",
                                    array(
                                        'id' => null,
                                        'cliente' => $this->ultimo_cliente[0]['cliente'],
                                        'produto_id' => $dados['produto_id'][$key],
                                        'quantidade' => $dados['quantidade'][$key],
                                        'subTotal' => $dados['subTotal'][$key],
                                        'dt_registro' => $data
                                    ));
                                }
                                catch(PDOException $e){
                                    throw new PDOException('Não foi possivel cadastrar compra!');
                                }

                            $this->novoCliente = 'não';
                                try {
                                    $quantidade = parent::projetarExpecifico(
                                        'SELECT quantidade FROM estoque WHERE produto_id = :produto_id',
                                        array('produto_id' => $value));

                                } catch (PDOException $e) {
                                    throw new PDOException('Produto não encontrado!');
                                }

                            if(intval($quantidade['quantidade']) < intval($dados['quantidade'][$key]))
                            {
                                $_SESSION['form-quantidade'][$key] = '*Estoque ' .$quantidade['quantidade'].' unidades';
                                throw new PDOException('Quantidade informada superior ao do estoque!');
                                
                            }
                            else
                            {
                                try {
                                    $subtracao = intval($quantidade['quantidade']) - intval($dados['quantidade'][$key]);
                                    parent::implementar("UPDATE estoque SET quantidade = :quantidade
                                    WHERE produto_id = :produto_id",
                                    array(
                                        'quantidade' => $subtracao,
                                    'produto_id' =>$value
                                    ));

                                } catch (PDOException $e) {
                                    throw new PDOException('Não foi possivel dar baixa no estoque');
                                } 
                            }
                        }
                        // caixa fechamento
                        try {
                           parent::implementar('INSERT INTO caixa_fechamento(id, cliente_id, total, pagamento, valor, troco, dt_registro)
                                VALUES(:id, :cliente_id, :total, :pagamento, :valor, :troco, :dt_registro)',
                                array(
                                    'id' => null,
                                    'cliente_id' => $this->ultimo_cliente[0]['cliente'],
                                    'total' => $dados['total'],
                                    'pagamento' => $dados['pagamento'],
                                    'valor' => $dados['valor'], 
                                    'troco' => $dados['troco'],
                                    'dt_registro' => $data
                                ));

                        } catch (PDOException $e) {
                            throw new PDOException('Não foi possivel finalizar a compra, tente novamente!');
                        }

                        $this->conn->commit();
                        unset($dados,$_SESSION['caixa']);
                        $msg = "Compra concluída com sucesso!";
                        $_SESSION['msg'] = parent::alertaSucesso($msg);

                    }
                    catch(PDOException $e){
                        $this->conn->rollBack();
                        $msg=  $e->getMessage();
                        $_SESSION['msg'] = parent::alertaFalha($msg);

                    }
                }
                else{
                    $_SESSION['Erro_form']['total'] = '*Ups, total divergente, tente novamente!';
                    $msg=  '*Ups, total divergente, tente novamente!';
                    $_SESSION['msg'] = parent::alertaFalha($msg);
                }
            }
            else
            {
                $msg = 'Preecha corretamente todos os campos e tente novamente!';
                $_SESSION['msg'] = parent::alertaFalha($msg);
            }
        }
        else
        {
            $msg = 'Verifique todos os campos e tente novamente';
            $_SESSION['msg'] = parent::alertaFalha($msg);
        }
    }

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

                            $dados['dados'].= '<tr><td><input type="text" name="produto_id[]" id="form-id" class="f-caixa" value="'.$produto['id'].'" readonly></td>';
                            $dados['dados'].='<td>'.$produto['nome'].'</td>';
                            $dados['dados'].='<td>'.$produto['codigo'].'</td>';
                            $dados['dados'].='<td>R$ '.number_format($produto['preco'],2,",",'.').'</td>';
                            $dados['dados'].='<td><input type="text" id="form-quantidade" class="f-caixa"  value="'.$qtd.'" name="quantidade[]" data-value="'.$produto['id'].'"></td>';
                            $dados['dados'].='<td><input type="text" name="subTotal[]" id="form-subTotal" class="f-caixa" value="'."R$ " . number_format($produto["subTotal"], 2, ',', '.').'"readonly></td>';
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
                $dados['total'] = "R$ " .number_format($total,2,",",'.');   
                $dados['dados'].= '</tbody><tfoot class="bg-info">';
                $dados['dados'].= '<tr><th colspan="5">Total</th>';
                $dados['dados'].='<th colspan="2"><input type="text" name="total" id="form-total" class="f-caixa" value="'.'R$ '. number_format($total,2,',','.').'" readonly></th></tr>';
                $dados['dados'].='<tr>';
                $dados['dados'].='<th colspan="3">Forma de pagamento</th><th colspan="2">';
                $dados['dados'].='<select name="pagamento" id="form-pagamento" class="form-control is-invalid">';
                $dados['dados'].='<option value="">--Selecione--</option>';
                $dados['dados'].='<option value="Dinheiro">Dinheiro</option>';
                $dados['dados'].='<option value="Crédito">Crédito</option>';
                $dados['dados'].='<option value="Débito">Débito</option>';
                $dados['dados'].='</select></th>';
                $dados['dados'].='<th colspan="2"><input type="text" name="valor" class="form-control" id="form-valor" aria-describedby="d-form-valor"></th></tr>';
                $dados['dados'].='<tr><th colspan="5">Troco</th>';
                $dados['dados'].='<th colspan="2"><input type="text" name="troco" class="form-control" id="form-troco" readonly></th></tr></tfoot>'; 

                                                    
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
    private function removerFormatoDinheiro($dinheiro):string
    {
        $dinheiro = preg_replace("/[^0-9\,]/","",$dinheiro);
        $dinheiro = str_replace('R$','',$dinheiro);
        $dinheiro = str_replace('.','',$dinheiro);
        $dinheiro = str_replace(',','.',$dinheiro);

        return $dinheiro;
    }
    // faz a validação de acordo com o tipo informado, e preenche o array form_valido;
    private function arrayFormValido(string $tipoValidacao,array $array,string  $campo,string $mensagem,$minimo = 0,$maximo = 0)
    {
        switch ($tipoValidacao) {
            case 'int':
                foreach($array as $key => $value)
                {   
                    array_push($this->form_valido,parent::valida_int($value,$campo.'['.$key.']',$mensagem,$minimo));      
                }
                break;
            case 'float':
                foreach($array as $key => $value)
                {   
                    array_push($this->form_valido,parent::valida_float($value,$campo.'['.$key.']',$mensagem,$minimo));  
                }
                break;
            case 'tamanho':
                foreach($array as $key => $value)
                {   
                    array_push($this->form_valido,parent::valida_tamanho($value,$campo.'['.$key.']',$mensagem,$maximo,$minimo));
                }
                break;
            case 'bool':
                foreach($array as $key => $value)
                {   
                    array_push($this->form_valido,parent::valida_bool($value,$campo.'['.$key.']',$mensagem));
                }
                break;
            
            case 'date':
                foreach($array as $key => $value)
                {   
                    array_push($this->form_valido,parent::valida_date($value,$campo.'['.$key.']',$mensagem));
                }
                break;
                
            default:
                break;
        }
    }

}