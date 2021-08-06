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
    <link href="<?php echo URL; ?>app/Assets/bootstrap/css/signin.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/fontawesome/css/all.css" rel="stylesheet">
    <link href="<?php echo URL; ?>app/Assets/image/logo/favicon.ico" rel="shortcut icon">
    <title>Login | Mercearia</title>
</head>
<body class="text-center">
<div class="container-fluid">
  <div class="row principal">
    <div class="col vh-100">
        <form class="form-signin" method="POST">
        <img class="mb-4" id="logo" src="<?php echo URL;?>app/Assets/image/logo/logo.png" alt="logo">
    <h1 class="h3 mb-3 font-weight-normal">Mercearia</h1>
<?php
    if (isset($_SESSION['msg'])) {
      echo  $_SESSION['msg'];
      unset($_SESSION['msg']);
    }

    if (isset($this->dados["form"])) {
      $valorForm = $this->dados["form"];
    }
?>
            <label for="inputCredencial" class="sr-only">Credencial</label>
            <input type="text" name="credencial" id="inputCredencial" class="form-control" value="<?php echo isset($valorForm['credencial']) ? $valorForm['credencial'] : ""; ?>" placeholder="Credencial" required autofocus>
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required>
            <input name="btnAcessar" type="submit" class="btn btn-lg btn-primary btn-block" value="acessar"/>
            <div class="mt-3 mb-3">
            <p><a href="#"> Esqueceu a senha?</a></p>
            </div>
        </form>
<?php
    include_once "app/View/include/footer.php";
?>
</body>
</html>

