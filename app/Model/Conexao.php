<?php 
namespace App\Model;

use PDO;
use PDOException;

if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class Conexao
{
   private $bdType = "mysql";
   private $host = "localhost";
   private $user = "root";
   private $password = "root";
   private $port = 3306;
   private $bdname = "mercearia";

   protected function conectar()
   {
       try{
            $con = new PDO($this->bdType.':host='.$this->host.';port='.$this->port.';dbname='.$this->bdname, $this->user, $this->password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
       }
       catch(PDOException $e)
       {
           $alerta = new \App\Model\Alerta();
           $msg= $alerta->alertaFalha("Não foi possivel realizar uma conexão com o site, tente novamente!");

           $_SESSION['msg'] = $msg;
            header("Location:". URL . "paginaInvalida/index");
            exit();
       }
   }
   
}
    