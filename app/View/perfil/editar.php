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
    <title>Dados pessoais| Mercearia</title>
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
                $perfil = $this->dados[0];
                ?>
                <div id="form-atualizar">
                    <h1 class="text-center mt-2">Dados pessoais</h1>
                    <form action="<?php echo URL; ?>perfil/atualizar" method="POST" id="form-atualizar-perfil">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="form-credencial">Credencial</label>
                                <input type="text" name="credencial" id="form-credencial" class="form-control <?php echo isset($_SESSION['Erro_form']['credencial']) ? 'is-invalid' : '' ?>" aria-describedby="serverCredencial" <?php echo isset($_SESSION['form']['senhaAtual']) ? 'value="' . $_SESSION['form']['credencial'] . '"' : 'value="' . $perfil['credencial'] . '"' ?>>
                                <?php
                                if (isset($_SESSION['Erro_form']['credencial'])) { ?>
                                    <div id='serverCredencial' class="invalid-feedback">
                                        <?php
                                        echo $_SESSION['Erro_form']['credencial'];
                                        unset($_SESSION['Erro_form']['credencial']);
                                        ?>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="form-senhaAtual">Senha Atual</label>
                                <input type="password" name="senhaAtual" id="form-senhaAtual" class="form-control <?php echo isset($_SESSION['Erro_form']['senhaAtual']) ? 'is-invalid' : '' ?>" aria-describedby="serverSenhaAtual" <?php echo isset($_SESSION['form']['senhaAtual']) ? 'value="' . $_SESSION['form']['senhaAtual'] . '"' : "" ?>>
                                <?php
                                if (isset($_SESSION['Erro_form']['senhaAtual'])) { ?>
                                    <div id='serverSenhaAtual' class="invalid-feedback">
                                        <?php
                                        echo $_SESSION['Erro_form']['senhaAtual'];
                                        unset($_SESSION['Erro_form']['senhaAtual']);
                                        ?>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="form-senha">Nova senha</label>
                                <input type="password" name="senha" id="form-senha" class="form-control <?php echo isset($_SESSION['Erro_form']['senha']) ? 'is-invalid' : '' ?>" aria-describedby="serverSenha" <?php echo isset($_SESSION['form']['senha']) ? 'value="' . $_SESSION['form']['senha'] . '"' : "" ?>>
                                <?php
                                if (isset($_SESSION['Erro_form']['senha'])) { ?>
                                    <div id='serverSenha' class="invalid-feedback">
                                        <?php
                                        echo $_SESSION['Erro_form']['senha'];
                                        unset($_SESSION['Erro_form']['senha']);
                                        ?>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="form-senhaRepetida">Repetir senha</label>
                                <input type="password" name="senhaRepetida" id="form-senhaRepetida" class="form-control <?php echo isset($_SESSION['Erro_form']['senhaRepetida']) ? 'is-invalid' : '' ?>" aria-describedby="serverSenhaRepetida" <?php echo isset($_SESSION['form']['senhaRepetida']) ? 'value="' . $_SESSION['form']['senhaRepetida'] . '"' : "" ?>>
                                <?php
                                if (isset($_SESSION['Erro_form']['senhaRepetida'])) { ?>
                                    <div id='serverSenhaRepetida' class="invalid-feedback">
                                        <?php
                                        echo $_SESSION['Erro_form']['senhaRepetida'];
                                        unset($_SESSION['Erro_form']['senhaRepetida']);
                                        ?>
                                    </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <a href="<?php echo URL ?>perfil/index" class="form-control btn btn-danger">Cancelar</a>
                            </div>
                            <div class="form-group col-6">
                                <input type="submit" value="Atualizar" name="btn_atualizar" class="form-control btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            <?php
            include_once "app/View/include/footer.php";
            ?>
            <script src="<?php echo URL; ?>app/Assets/js/eventos.js"></script>
            </body>

</html