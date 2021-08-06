<?php 
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
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
    <link href="<?php echo URL; ?>app/Assets/css/paginainvalida.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/fontawesome/css/all.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/image/logo/favicon.ico" rel="shortcut icon">
    <title>Erro 404 | Mercearia</title>
</head>
<body>
<?php
include_once "app/View/include/header.php";
?>
<div class="container-fluid">
  <div class="row">
<?php 
include_once "app/View/include/menulateral.php";
?>
 <div class="col-md-9 ml-sm-auto col-lg-10 principal">
    <main role="main">
<?php
if(isset($_SESSION['msg']))
{
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>  
        <div class="alertaPagina">
            <h1>Desculpe! página não existe ou foi removida</h1>
            <h5> Verifique se você digitou correntamente o endereço.</h5>
            <a href="<?php echo isset($_SESSION['usuario_nome'])?URL.'home/' :URL.'home/'?>"><button>Ir para página inicial</button></a>
        </div>    
    </main>
    <?php
    include_once "app/View/include/footer.php";
?>
<script src="<?php echo URL;?>app/Assets/js/eventos.js"></script>
  </body>
</html>
</body>
</html>
