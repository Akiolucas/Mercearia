<?php
if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
    header("Location: http://localhost/mercearia/paginaInvalida/index");
    die("Erro: Página não encontrada!");
}
?>

<body>
    <header class= "sticky-top">
        <nav class="navbar navbar-light bg-info">
            <div class="container-fluid">
                <a class="mx-auto" href="<?php echo URL;?>">
                    <img src="<?php echo URL;?>app/Assets/image/logo/logo.png">
                </a>
                <button class="navbar-toggler d-md-none collapsed" id="btn-menu" type="button" data-toggle="collapse" data-target="#menuLateral" aria-controls="menuLateral" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>
    