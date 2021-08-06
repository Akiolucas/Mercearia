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
      <li class="nav-item">
        <a class="nav-link active" href="#">
          Página 1
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          Página 2
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          Página 3
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          Página 4
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          Página 5
        </a>
      </li>
    </ul>
  </div>
</nav>
