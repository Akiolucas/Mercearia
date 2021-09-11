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
    <title>Páginas privadas | Mercearia</title>
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
                <h2 class="text-center mb-3">Tabela de Páginas privadas</h2>
                <button type="button" class="btn btn-success m-button-table" data-toggle="modal" data-target="#modalCadastrar"><i class="fas fa-pen"></i> Cadastrar</button>
                <div class="table-responsive">
                    <table id="listar-paginas-privadas" class="table table-hover text-center tabela-personalizada">
                        <thead class="bg-info">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
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
                                    <td data-order="<?php echo date('Y/m/d H:i:s', strtotime($item['dt_registro'])); ?>"><?php echo date('d/m/Y', strtotime($item['dt_registro'])); ?></td>
                                    <td>
                                        <a href="<?php echo URL; ?>pagina_privada/editar/&id=<?php echo $item['id'] ?>" class="btn btn-warning col-mb-3"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URL; ?>pagina_privada/excluir/&id=<?php echo $item['id'] ?>" class="btn btn-danger col-mb-3" id='link_excluir'><i class="fas fa-trash-alt"></i></a>
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
                                <th>Registro</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal fade" id="modalCadastrar" tabindex="-1" role="dialog" aria-labelledby="cadastrarPg_privada" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <?php
                            if (isset($_SESSION['alerta'])) {
                                echo $_SESSION['alerta'];
                                unset($_SESSION['alerta']);
                            }
                            ?>
                            <div class="modal-header">
                                <h5 class="modal-title text-center w-100" id="cadastrarPg_privada"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo URL; ?>pagina_privada/cadastrar" method="POST" id="form-paginaPrivada">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="form-nome" class="col-form-label">Nome:</label>
                                        <input type="text" name="nome" id="form-nome" class="form-control <?php echo isset($_SESSION['Erro_form']['nome']) ? 'is-invalid' : '' ?>" aria-describedby="serverNome" <?php echo isset($_SESSION['form']['nome']) ? 'value =' . $_SESSION['form']['nome'] : "" ?>>
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" class="btn btn-success" name="btn_cadastrar" value="Cadastrar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirm-delete" tabindex="-1" aria-labelledby="modalExcluirPg_privada" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalExcluirPg_privada">Excluir Página privada</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Deseja realmente excluir essa página privada?</p>
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
            <?php
            if (isset($_SESSION['script'])) {
                echo $_SESSION['script'];
                unset($_SESSION['script']);
            }
            ?>
            </body>

</html>