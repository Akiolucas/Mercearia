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
    <link href="<?php echo URL; ?>app/Assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/fontawesome/css/all.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/image/logo/favicon.ico" rel="shortcut icon">
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
                <h2 class="text-center mb-3">Tabela Produtos</h2>
                <div class="table-responsive">
                    <table id="listar-produtos" class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                                <th>Código</th>
                                <th>kilograma</th>
                                <th>Registro</th>
                               
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                                <th>Código</th>
                                <th>kilograma</th>
                                <th>Registro</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </main>
            <?php
            include_once "app/View/include/footer.php";
            ?>
            <script src="<?php echo URL; ?>app/Assets/js/eventos.js"></script>
            <script src="<?php echo URL;?>app/Assets/jquery/jquery.dataTables.min.js"></script>
            <script src="<?php echo URL;?>app/Assets/js/dataTables.js"></script>
            </body>

</html>