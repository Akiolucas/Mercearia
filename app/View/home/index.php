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
    <script src="<?php echo URL;?>app/Assets/js/cssBootstrap.js"></script>
    <link href="<?php echo URL; ?>app/Assets/css/mercearia.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/fontawesome/css/all.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/image/logo/favicon.ico" rel="shortcut icon">
    <title>Home | Mercearia</title>
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
                if(isset($_SESSION['usuario_cargo']) && $_SESSION['usuario_cargo'] == 'Administrador')
                {
                    $detalhes = $this->dados[0];
                ?>
                <div class="row m-0">
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Funcionários</h5><hr>
                                <p class="card-text"><b>Cargo com maior quantidade:</b></p>
                                <p class="card-text"><?php echo $detalhes['cargo'];?></p>
                                <p class="card-text d-none card-funcionario"><b>Quantidade:</b> <?php echo number_format($detalhes['cargo_qtd'],0,',','.');?></p><hr class="d-none card-funcionario">
                                <p class="card-text d-none card-funcionario"><b>Total de funcionários:</b> <?php echo number_format($detalhes['funcionario'],0,',','.');?></p>
                                <p class="card-text d-none card-funcionario"><b>Ativos:</b> <?php echo number_format($detalhes['funcionario_ativo'],0,',','.');?></p>
                                <a href="#" class="btn btn-info d-block" id="detalhes-funcionario">Detalhes</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Fornecedores</h5><hr>
                                <p class="card-text"><b>Maior fornecedor:</b></p>
                                <p class="card-text"><?php echo $detalhes['maiorFornecedor'];?></p>
                                <p class="card-text d-none card-fornecedor"><b>Total comprado:</b></p>
                                <p class="card-text d-none card-fornecedor"><?php echo number_format($detalhes['fornecedor_qtd'],0,',','.') . ' produtos';?></p><hr class="d-none card-fornecedor"></p>
                                <p class="card-text d-none card-fornecedor"><b>N° de fornecedores:</b> <?php echo number_format($detalhes['fornecedor'],0,',','.');?></p>
                                <a href="#" class="btn btn-info d-block" id="detalhes-fornecedor">Detalhes</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Produtos</h5><hr>
                                <p class="card-text"><b>Produto mais vendido:</b></p>
                                <p class="card-text"> <?php echo $detalhes['maisVendido'];?></p>
                                <p class="card-text d-none card-produto"><b>Total vendido:</b> <?php echo number_format($detalhes['totalVendido'],0,',','.');?></p>
                                <p class="card-text d-none card-produto"><b>Estoque:</b> <?php echo number_format($detalhes['estoque'],0,',','.');?></p><hr class='card-produto d-none'>
                                <p class="card-text d-none card-produto"><b>Total de produtos:</b> <?php echo number_format($detalhes['produto'],0,',','.');?></p>
                                <a href="#" class="btn btn-info d-block" id="detalhes-produtos">Detalhes</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Caixa</h5><hr>
                                <p class="card-text"><b>Quantidade de vendas hoje</b></p>
                                <p class="card-text"><b>Quantidade:</b> <?php echo number_format($detalhes['caixa_hoje_qtd'],0,',','.');?></p>
                                <p class="card-text d-none card-caixa"><b>Total:</b> <?php echo 'R$ ' .number_format($detalhes['caixa_hoje'],2,',','.');?></p><hr class='card-caixa d-none'>
                                <p class="card-text d-none card-caixa"><b>Total de vendas:</b> <?php echo number_format($detalhes['caixa_vendas'],0,',','.');?></p>
                                <p class="card-text d-none card-caixa"><b>Valor total:</b> <?php echo 'R$ '.number_format($detalhes['caixa'],2,',','.');?></p>
                                <a href="#" class="btn btn-info d-block" id="detalhes-caixa">Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php };?>

            </main>
            <?php
            include_once "app/View/include/footer.php";
            ?>
            <script src="<?php echo URL; ?>app/Assets/js/eventos.js"></script>
            </body>

</html>