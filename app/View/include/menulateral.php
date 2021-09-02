<?php
if (!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
{
  header("Location: http://localhost/mercearia/paginaInvalida/index");
  die("Erro: Página não encontrada!");
}
?>
<nav id="menuLateral" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
<?php
if (isset($_SESSION['usuario_paginas']))
{
?>
      <li class="nav-item active">
        <a class="nav-link text-center" href="<?php echo URL;?>perfil">
          <i class="fas fa-user-circle fa-7x"></i>
          <p class="my-1"><?php echo $_SESSION['usuario_nome'];?></p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-center" href="<?php echo URL; ?>sair" id="link-sair">
          Sair <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
<?php
  
  foreach ($_SESSION['usuario_paginas'] as $key => $pagina) 
  {
    if($pagina != "Perfil")
    {
?>
      <li class="nav-item">
        <a class="nav-link" href="<?php 
        
        switch ($pagina) {
          case 'Pagina_privada':
            echo URL . 'pagina_privada';
            ?>">
            <?php
            echo 'Páginas Privadas';
            break;

          case 'Pagina_publica':
            echo URL . 'pagina_publica';
            ?>">
            <?php
            echo 'Páginas Públicas';
            break;
          
          case 'Pagina_funcionario':
            echo URL . 'pagina_funcionario';
            ?>"> 
            <?php
            echo 'Páginas de acesso';
            break;
          
          case 'Nivel':
            echo URL . 'nivel';
            ?>">
            <?php
            echo 'Nível de acesso';
            break;
          
          default:
            echo URL. strtolower($pagina); ?>">
            <?php echo $pagina; 

            break;
        }?>
        
        </a>
      </li>
<?php
    }
  } 
} 
?>
    </ul>
  </div>
</nav>
