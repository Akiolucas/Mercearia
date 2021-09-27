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
    <title>Editar produto | Mercearia</title>
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
                $produto = $this->dados[0];
                ?>

                <div id="form-atualizar">
                    <h1 class="text-center mt-2">Produto</h1>
                    <form action="<?php echo URL; ?>produtos/atualizar" method="POST" id='form-atualizar-produto'>
                        <div class="form-row">
                            <div class="form-group col-12 col-sm-12">
                                <input type="hidden" name="id" value="<?php echo $produto['id'] ?>">
                                <label for="form_nome">Nome</label>
                                <input type="text" name="nome" class="form-control <?php echo isset($_SESSION['Erro_form']['nome']) ? 'is-invalid' : '' ?>" aria-describedby="serverNome" id="form-nome" value="<?php echo $produto['nome'] ?>">
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

                            <div class="form-group col-3 col-sm-6">
                                <label for="form-kilograma">Kg</label>
                                <input type="text" name="kilograma" id="form-kilograma" class="form-control <?php echo isset($_SESSION['Erro_form']['kilograma']) ? 'is-invalid' : '' ?>" value="<?php echo number_format($produto['kilograma'], 3, ',', '.') ?>">
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

                            <div class="form-group col-3 col-sm-6">
                                <label for="form-litro">Litro</label>
                                <input type="text" name="litro" id="form-litro" class="form-control <?php echo isset($_SESSION['Erro_form']['litro']) ? 'is-invalid' : '' ?>" value="<?php echo number_format($produto['litro'], 3, ',', '.') ?>">
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

                            <div class="form-group col-3 col-sm-6">
                                <label for="form_preco">Preço</label>
                                <input type="text" name="preco" id="form-preco" class="form-control <?php echo isset($_SESSION['Erro_form']['preco']) ? 'is-invalid' : '' ?>" aria-describedby="serverPreco" value="<?php echo number_format($produto['preco'], 2, ',', '.')?>">
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

                            <div class="form-group col-3 col-sm-6">
                                <label for="form_quantidade">Quantidade</label>
                                <input type="number" name="quantidade" id="form-quantidade" min="1" class="form-control <?php echo isset($_SESSION['Erro_form']['quantidade']) ? 'is-invalid' : '' ?>" aria-describedby="serverQuantidade" value="<?php echo $produto['quantidade'] ?>" min="0" step="1">
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
                        <div class="form-row">
                            <div class="form-group col-12 col-sm-8">

                                <label for="form_fornecedor">Fornecedor</label>
                                <select name="fornecedor_id" id="form-fornecedor_id" class="form-control <?php echo isset($_SESSION['Erro_form']['fornecedor_id']) ? 'is-invalid' : '' ?>" aria-describedby="serverFornecedor_id">
                                    <option value="<?php echo $produto['fornecedor_id'] ?>" id="option_padrao" selected><?php echo $produto['fornecedor'] ?></option>
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
                            <div class="form-group col-12 col-sm-4">
                                <label for="form-codigo">Código</label>
                                <input type="text" name="codigo" value="<?php echo $produto['codigo'] ?>" id="form-codigo" class="form-control" disabled>
                                <input type="hidden" name="codigo_id" value="<?php echo $produto['codigo_id'] ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <a href="<?php echo URL ?>produtos/index" class="form-control btn btn-danger">Cancelar</a>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="<?php echo URL; ?>app/Assets/js/mask.js"></script>
            <script src="<?php echo URL; ?>app/Assets/js/produtos-ajax.js"></script>
            <script>
                window.addEventListener("load", editarProdutos());
            </script>
            </body>

</html