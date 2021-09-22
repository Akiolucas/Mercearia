<?php
if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="<?php echo URL; ?>app/Assets/js/cssBootstrap.js"></script>
    <link href="<?php echo URL; ?>app/Assets/css/mercearia.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/fontawesome/css/all.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/image/logo/favicon.ico" rel="shortcut icon">
    <title>Caixa | Mercearia</title>
</head>
<?php

include_once "app/View/include/header.php";

?>
<div class="container-fluid">
    <div class="row">
        <?php
        include_once "app/View/include/menulateral.php";
        ?>
        <div class="col-md-9 ml-auto col-lg-10 principal">
            <main role="main" class="m-2">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>

                <div id="table-caixa">
                    <h1 class='text-center'>Caixa</h1>
                    <div class="form-row">
                        <div class="form-group col mb-0">
                            <input type="search" name="pesquisa" id="form-pesquisa" class="form-control" placeholder="digite nome ou código do produto">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12" id="resultado-busca"></div>
                    </div>
                    <div class="table-responsive-caixa largura-table-caixa">
                        <table id="produtos-selecionados" class="table table-hover">
                            <thead  class="bg-info">
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Subtotal</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($this->dados) > 0)
                                {
                                    $total= 0;
                                    foreach($this->dados as $item):
                                        $total+= floatval($item['subTotal']);
                                    ?>
                                  <tr>
                                      <td><input type="text" name="form-id" id="form-id" class='f-caixa' value="<?php echo $item['id']?>" readonly></td>
                                      <td><input type="text" name="form-nome" id="form-nome" class='f-caixa' value="<?php echo $item['nome']?>" readonly></td>
                                      <td><input type="text" name="form-codigo" id="form-codigo" class='f-caixa' value="<?php echo $item['codigo']?>" readonly></td>
                                      <td><input type="text" name="form-preco" id="form-preco" class='f-caixa' value="<?php echo "R$ ". number_format($item['preco'],2,',','.')?>" readonly></td>
                                      <td><input type='text' id='form-quantidade'class='f-caixa'  value='<?php echo $item['quantidade']?>' name='form-quantidade' data-value='<?php echo $item['id']?>'></td>
                                      <td><?php echo "R$ ". number_format($item['subTotal'],2,',','.')?></td>
                                      <td> <a href='<?php echo URL;?>caixa/remover?id=<?php echo $item['id'];?>' class='btn btn-danger col-mb-3' id='removerItemCaixa' data-name='<?php echo $item['nome'] ?>'><i class='fas fa-trash-alt'></i></a></td>
                                  </tr>  
                                <?php
                                    endforeach;
                                ?>
                                </tbody>
                                <tfoot class='bg-info'>
                                    <tr>
                                        <th colspan='5'>Total</th>
                                        <th colspan='2'><input type="text" name="form-total" id="form-total" class='f-caixa' value="<?php echo 'R$ '. number_format($total,2,',','.')?>" readonly></th>
                                    </tr>
                                    <tr>
                                        <th colspan='3'>Forma de pagamento</th>
                                        <th colspan='2'>
                                            <select name="form-pagamento" id="form-pagamento" class="form-control is-invalid">
                                                <option value="">-------- Selecione --------</option>
                                                <option value="Dinheiro">Dinheiro</option>
                                                <option value="Crédito">Crédito</option>
                                                <option value="Débito">Débito</option>
                                            </select>
                                        </th>
                                        <th colspan='2'><input type="text" name="form-dinheiro-cliente" class='form-control' id="form-dinheiro-cliente" aria-describedby="d-form-dinheiro-cliente"></th>
                                    </tr>
                                    <tr>
                                        <th colspan='5'>Troco</th>
                                        <th colspan='2'><input type="text" name="form-troco" class='form-control' id="form-troco" readonly></th>
                                    </tr>
                                </tfoot>
                                <?php  
                                }  
                                else{
                                ?>
                                <tr>
                                     <td colspan="7"class="text-center">Nenhum produto adicionado</td>
                                </tr> 
                                </tbody>                               
                                <?php
                                }
                                ?>
                        </table>
                    </div>


                    <form action="<?php echo URL; ?>caixa/pedido" method="POST" id="form-caixa">
                        <div class="form-row largura-table-caixa">
                            <div class="form-group col-6 pl-0">
                                <a href="<?php echo URL ?>caixa/cancelarTudo" id='cancelarCompra' class="form-control btn btn-danger">Cancelar tudo</a>
                            </div>
                            <div class="form-group col-6 pr-0">
                                <input type="submit" value="Finalizar" id='btn_cadastrar' name="btn_cadastrar" class="form-control btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            <?php
            include_once "app/View/include/footer.php";
            ?>
            <script src="<?php echo URL; ?>app/Assets/js/eventos.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="<?php echo URL; ?>app/Assets/js/caixa-ajax.js"></script>
            </body>

</html