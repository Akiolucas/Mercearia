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
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <title>Produtos | Mercearia</title>
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
                <h2 class="text-center mb-3">Tabela de Produtos</h2>
                <button type="button" class="btn btn-success m-button-table" data-toggle="modal" data-target="#modalCadastrar"><i class="fas fa-pen"></i> Cadastrar</button>
                <div class="table-responsive">
                    <table id="listar-produtos" class="table table-hover text-center tabela-personalizada">
                        <thead class="bg-info">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                                <th>Código</th>
                                <th>Kilograma</th>
                                <th>Litro</th>
                                <th>Estoque</th>
                                <th>Registro</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($this->dados as $coluna => $item) {
                            ?> <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo $item['nome']; ?></td>
                                    <td><?php echo "R$ " . number_format($item['preco'], 2, ",", "."); ?></td>
                                    <td><?php echo $item['fornecedor']; ?></td>
                                    <td><?php echo $item['codigo']; ?></td>
                                    <td data-order="<?php  echo $item["kilograma"]?>">
                                        <?php
                                            if (strpos($item['kilograma'],'.')){
                                                if(floatval($item['kilograma']) > 0 && floatval($item['kilograma']) < 1)
                                                {
                                                    echo ltrim(str_replace('0,','',number_format($item['kilograma'], 3, ',', '.')),'0') . " g"; 
                                                }
                                                else{
                                                    echo trim(number_format($item['kilograma'], 3, ',', '.'),'0') . " kg"; 
                                                   
                                                }     
                                            }
                                            else{            
                                                if($item['kilograma'] == "0")
                                                {
                                                    echo "<i class='fa fa-ban' aria-hidden='true'></i>";
                                                } 
                                                else{
                                                    echo $item['kilograma']. " kg";
                                                }                                  
                                               
                                            }
                                         ?>
                                    </td>
                                    <td data-order="<?php  echo $item["litro"]?>">
                                        <?php
                                            if (strpos($item['litro'],'.')){
                                                 if(floatval($item['litro']) > 0 && floatval($item['litro']) < 1)
                                                {
                                                    echo ltrim(str_replace('0,','',number_format($item['litro'], 3, ',', '.')),'0') . " ml"; 
                                                }
                                                else{
                                                    echo trim(number_format($item['litro'], 3, ',', '.'),'0') . " L"; 
                                                }                                   
                                            }
                                            else{
                                                if($item['litro'] == "0")
                                                {
                                                    echo "<i class='fa fa-ban' aria-hidden='true'></i>";
                                                }
                                                else{
                                                    echo $item['litro'] . " L";
                                                }                                            
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $item['estoque']; ?></td>
                                    <td data-order="<?php echo date('Y/m/d H:i:s', strtotime($item['dt_registro'])); ?>"><?php echo date('d/m/Y', strtotime($item['dt_registro'])); ?></td>
                                    <td>
                                        <a href="<?php echo URL; ?>produtos/editar/&id=<?php echo $item['id'] ?>" class="btn btn-warning col-mb-3"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URL; ?>produtos/excluir/&id=<?php echo $item['id'] ?>" class="btn btn-danger col-mb-3" id='link_excluir'><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot class="bg-info">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                                <th>Código</th>
                                <th>Kilograma</th>
                                <th>Litro</th>
                                <th>Estoque</th>
                                <th>Registro</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal fade" id="modalCadastrar" tabindex="-1" role="dialog" aria-labelledby="cadastrarProduto" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <?php
                            if (isset($_SESSION['alerta'])) {
                                echo $_SESSION['alerta'];
                                unset($_SESSION['alerta']);
                            }
                            ?>
                            <div class="modal-header">
                                <h5 class="modal-title text-center w-100" id="cadastrarProduto">Produto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo URL; ?>produtos/cadastrar" method="POST" id="form-produto">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="form-nome" class="col-form-label">Nome:</label>
                                        <input type="text" name="nome" id="form-nome" class="form-control <?php echo isset($_SESSION['Erro_form']['nome']) ? 'is-invalid' : '' ?>" aria-describedby="serverNome" <?php echo isset($_SESSION['form']['nome']) ? 'value="' . $_SESSION['form']['nome'] . '"' : "" ?>>
                                        <?php
                                        if (isset($_SESSION['Erro_form']['nome'])) { ?>
                                            <div id='serverNome' class="invalid-feedback">
                                                <?php
                                                echo $_SESSION['Erro_form']['nome'];
                                                unset($_SESSION['Erro_form']['nome']);
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-preco" class="col-form-label">Preço:</label>
                                        <input type="text" name="preco" id="form-preco" class="form-control <?php echo isset($_SESSION['Erro_form']['preco']) ? 'is-invalid' : '' ?>" aria-describedby="serverPreco" <?php echo isset($_SESSION['form']['preco']) ? 'value="' . $_SESSION['form']['preco'] . '"' : "" ?> placeholder="0,00">
                                        <?php
                                        if (isset($_SESSION['Erro_form']['preco'])) { ?>

                                            <div id='serverPreco' class="invalid-feedback">
                                                <?php
                                                echo $_SESSION['Erro_form']['preco'];
                                                unset($_SESSION['Erro_form']['preco']);
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-fornecedor" class="col-form-label">Fornecedor:</label>
                                        <select name="fornecedor_id" id="form-fornecedor_id" class="form-control <?php echo isset($_SESSION['Erro_form']['fornecedor_id']) ? 'is-invalid' : '' ?>" aria-describedby="serverFornecedor_id">
                                        </select>
                                        <?php if (isset($_SESSION['Erro_form']['fornecedor_id'])) { ?>

                                            <div id='serverFornecedor_id' class="invalid-feedback">
                                                <?php
                                                echo $_SESSION['Erro_form']['fornecedor_id'];
                                                unset($_SESSION['Erro_form']['fornecedor_id']);
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-kilograma" class="col-form-label">Kg:</label>
                                        <input type="text" name="kilograma" id="form-kilograma" class="form-control <?php echo isset($_SESSION['Erro_form']['kilograma']) ? 'is-invalid' : '' ?>" aria-describedby="serverKilograma" <?php echo isset($_SESSION['form']['kilograma']) ? 'value="' . $_SESSION['form']['kilograma'] . '"' : "" ?> placeholder="0,000"> 
                                        <?php if (isset($_SESSION['Erro_form']['kilograma'])) { ?>

                                            <div id='serverKilograma' class="invalid-feedback">
                                                <?php
                                                echo $_SESSION['Erro_form']['kilograma'];
                                                unset($_SESSION['Erro_form']['kilograma']);
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-litro" class="col-form-label">Litro:</label>
                                        <input type="text" name="litro" id="form-litro" class="form-control <?php echo isset($_SESSION['Erro_form']['litro']) ? 'is-invalid' : '' ?>" aria-describedby="serverKilograma" <?php echo isset($_SESSION['form']['litro']) ? 'value="' . $_SESSION['form']['litro'] . '"' : "" ?> placeholder="0,000"> 
                                        <?php if (isset($_SESSION['Erro_form']['litro'])) { ?>

                                            <div id='serverKilograma' class="invalid-feedback">
                                                <?php
                                                echo $_SESSION['Erro_form']['litro'];
                                                unset($_SESSION['Erro_form']['litro']);
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-quantidade" class="col-form-label">Quantidade:</label>
                                        <input type="number" name="quantidade" id="form-quantidade" min="1" class="form-control <?php echo isset($_SESSION['Erro_form']['quantidade']) ? 'is-invalid' : '' ?>" aria-describedby="serverQuantidade" step="1" <?php echo isset($_SESSION['form']['quantidade']) ? 'value="' . $_SESSION['form']['quantidade'] . '"' : "" ?>>
                                        <?php if (isset($_SESSION['Erro_form']['quantidade'])) { ?>

                                            <div id='serverQuantidade' class="invalid-feedback">
                                                <?php
                                                echo $_SESSION['Erro_form']['quantidade'];
                                                unset($_SESSION['Erro_form']['quantidade']);
                                                ?>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" class="btn btn-success" name="btn_cadastrar" value="Cadastrar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirm-delete" tabindex="-1" aria-labelledby="modalExcluirProduto" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalExcluirProduto">Excluir produto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Deseja realmente excluir esse produto?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                                <a class="btn btn-danger" id="excluir_ok">Excluir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include_once "app/View/include/footer.php";
            ?>
            
            <script src="<?php echo URL; ?>app/Assets/js/eventos.js"></script>
            <script src="<?php echo URL; ?>app/Assets/jquery/jquery.dataTables.min.js"></script>
            <script src="<?php echo URL; ?>app/Assets/js/dataTables.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="<?php echo URL; ?>app/Assets/js/mask.js"></script>
            <script src="<?php echo URL; ?>app/Assets/js/produtos-ajax.js"></script>
            <script>
                window.addEventListener("load", indexProdutos());
            </script>
            
            <?php
            if (isset($_SESSION['script'])) {
                echo $_SESSION['script'];
                unset($_SESSION['script']);
            }
            ?>
            </body>

</html>