<?php
session_start();
define("MERCEARIA2021", true); //altere o nome dessa constante para um nome mais difícil. 

require './vendor/autoload.php';
$url = new Core\ConfigController();
$url->carregar();

?>