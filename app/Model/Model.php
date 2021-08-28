<?php

namespace App\Model;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }
    use PDO;

class Model extends Conexao
{
    private $conn;
    private $query;
    private object $alerta;
    protected $mensagem;
    private $resultado;

    function __construct()
    {
        $this->conn = parent::conectar();
        $this->alerta = new \App\Model\Alerta();
    }

    final protected function alertaFalha($mensagem): string
    {
        $this->mensagem = $this->alerta->alertaFalha($mensagem);
        return $this->mensagem;
    }

    final protected function alertaSucesso($mensagem): string
    {
        $this->mensagem = $this->alerta->alertaSucesso($mensagem);
        return $this->mensagem;
    }

    final protected function projetarTodos($query): array
    {
        $this->query = $this->conn->prepare($query);
        $this->query->execute();

        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    final protected function projetarExpecifico($query,$parametros = array(), bool $unico = true)
    {
        $this->query = $this->conn->prepare($query);
        $this->parametros($this->query,$parametros);
        $this->query->execute();
        if($unico){
            $this->resultado = $this->query->fetch(PDO::FETCH_ASSOC);
        }
        else{
            $this->resultado = $this->query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $this->resultado;
    }
    
    final protected function implementar($query,$parametros = array()): void
    {
        $this->query = $this->conn->prepare($query);
        $this->parametros($this->query,$parametros);
        $this->query->execute();
    }

    final protected function existeCamposFormulario(array $dados, array $obrigatorio, int $tamanho): bool
    {   
        if(count($dados) != $tamanho){
            return false;
        }
        
        else{
            foreach($obrigatorio as $valor)
            {
                if(!array_key_exists($valor,$dados))
                {   
                    return false;
                    exit();
                }
            }    
        }
        
        foreach($dados as $item)
        {
            if(strlen($item) == 0)
            {
                return false;
                exit();
            }

            $vazio = trim($item);
            if($vazio == ""){
                return false;
                exit();
            }
        }
        return true;
    }
    
    final protected function formularioValido(array $validacao): bool
    {
        foreach($validacao as $boolean)
        {
            if(!$boolean){
                return false;
                exit();
            }
        }
        return true;
            
    }
    
    private function parametros($query,$parametros = array()): void
    {
        foreach($parametros as $parametro => $valor)
        {
            $this->valoresParam($query,$parametro,$valor);
        }
    }
    
    private function valoresParam($query,$parametro,$valor): void
    {
        $query->bindParam(":$parametro",$valor);  
    }

    final protected function valida_int(array $campos): bool
    {
        foreach($campos as $campo)
        {
            $campo = intval($campo);

            if($campo == 0 || $campo < 0){
                return false;
                exit();
            }

            else if(!is_int($campo))
            {
                return false;
                exit();
            }
        }
        return true;
    }
    final protected function valida_float(array $campos): bool
    {
        foreach($campos as $campo)
        {
            $campo = floatval($campo);
            
            if($campo == 0 || $campo < 0){
                return false;
                exit();
            }

            else if(!is_float($campo))
            {
                return false;
                exit();
            }
        }
        return true;
    }
    final protected  function valida_date(array $campos): bool
    {
        foreach($campos as $campo)
        {
            if(!date_create_from_format('Y-m-d H:i:s',$campo))
            {
                return false;
                exit();
            }
        }
        return true;
    }

}

?>