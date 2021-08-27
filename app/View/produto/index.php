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
                <button type="button" class="btn btn-success m-button-table" data-toggle="modal" data-target="#modalCadastrar" onclick="indexProdutos()"><i class="fas fa-pen"></i> Cadastrar</button>
                <div class="table-responsive">
                    <table id="listar-produtos" class="table table-hover text-center">
                        <thead class="bg-info">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                                <th>Código</th>
                                <th>Kilograma</th>
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
                                    <td><?php echo number_format($item['kilograma'], 3, ',', '.') . " Kg"; ?></td>
                                    <td><?php echo $item['estoque']; ?></td>
                                    <td data-order="<?php echo date('Y/m/d', strtotime($item['dt_registro'])); ?>"><?php echo date('d/m/Y', strtotime($item['dt_registro'])); ?></td>
                                    <td>
                                        <a href="<?php echo URL; ?>produtos/editar/&id=<?php echo $item['id'] ?>" class="btn btn-warning col-mb-3"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URL; ?>produtos/excluir/&id=<?php echo $item['id'] ?>" class="btn btn-danger col-mb-3"><i class="fas fa-trash-alt"></i></a>
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
                            <div class="modal-header">
                                <h5 class="modal-title text-center w-100" id="cadastrarProduto">Produto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo URL; ?>/produto/cadastrar" method="POST">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="form-nome" class="col-form-label">Nome:</label>
                                        <input type="text" name="nome" id="form-nome" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-preco" class="col-form-label">Preço:</label>
                                        <input type="number" name="preco" id="form-preco" class="form-control" min="0.10" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-fornecedor" class="col-form-label">Fornecedor:</label>
                                        <select name="fornecedor_id" id="form-fornecedor" class="form-control" required>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-kilograma" class="col-form-label">Kilograma:</label>
                                        <input type="number" name="kilograma" id="form-kilograma" class="form-control" min='0.001' step="0.001" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-quantidade" class="col-form-label">Quantidade:</label>
                                        <input type="number" name="quantidade" id="form-quantidade" min="1" class="form-control" step="1" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" class="btn btn-success" name="btn_cadastar" value="Cadastrar">
                                </div>
                            </form>
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
            <script src="<?php echo URL; ?>app/Assets/js/produtos-ajax.js"></script>
            </body>

</html>