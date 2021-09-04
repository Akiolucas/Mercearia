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
    <title>Editar funcionário | Mercearia</title>
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
                $funcionario = $this->dados[0];
                ?>

                <div id="form-atualizar">
                    <h1 class="text-center mt-2">Funcionário</h1>
                    <form action="<?php echo URL; ?>funcionario/atualizar" method="POST">
                        <div class="form-row">
                            <div class="form-group col-8">
                                <input type="hidden" name="id" value="<?php echo $funcionario['id'] ?>">
                                <label for="form_nome">Nome</label>
                                <input type="text" name="nome" class="form-control" id="form_nome" value="<?php echo $funcionario['nome'] ?>">
                            </div>

                            <div class="form-group col-4">
                                <label for="form_ativo">Ativo</label>
                                <select name="ativo" class="form-control" id="form_ativo">                        
                                     <option value="1"<?php echo $funcionario['ativo'] == 1?"selected":""?>>Sim</option>
                                     <option value="0"<?php echo $funcionario['ativo'] == 0?"selected":""?>>Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-8">
                                <label for="form_cargo">Cargo</label>
                                <select name="cargo_id" class="form-control" id="form_cargo_id">
                                    <option value="<?php echo $funcionario['cargo_id'] ?>" id="option_padrao_cargo" selected><?php echo $funcionario['cargo'] ?></option>
                                </select>
                            </div>

                            <div class="form-group col-4">
                                <label for="form_nivel">Nível</label>
                                <select name="nivel_id" class="form-control" id="form_nivel">
                                    <option value="<?php echo $funcionario['nivel_id'] ?>" id="option_padrao_nivel" selected><?php echo $funcionario['nivel'] ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <a href="<?php echo URL ?>funcionario/index" class="form-control btn btn-danger">Cancelar</a>
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
            <script src="<?php echo URL; ?>app/Assets/js/funcionario-ajax.js"></script>
            <script>
                window.addEventListener("load", dadosAtualizar());
            </script>
            </body>

</html