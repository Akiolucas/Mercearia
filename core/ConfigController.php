<?php 

namespace Core;
    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

class ConfigController
{
    private $url;
    private array $urlDividida;
    private string $urlMetodo;
    private string $urlController;

    public function __construct()
    {
        if(!empty(filter_input(INPUT_GET,"url",FILTER_SANITIZE_URL)))
        {
            $this->url = filter_input(INPUT_GET,"url",FILTER_SANITIZE_URL);
            $this->urlDividida = explode('/',$this->url,);
            
            $this->urlController = $this->urlDividida[0];

            if(isset($this->urlDividida[1]) && !empty($this->urlDividida[1]))
            {
                $this->urlMetodo = $this->urlDividida[1];
            }
            else{
                $this->urlMetodo = "index";
            }
        }
        else{
            
            $this->urlController = "home";
            $this->urlMetodo = "index";
        }
    }
    public function carregar()
    {
        $site = new \Core\Endereco();
        $site->urlPublica();
        
        $paramArquivo = "./app/Controller/" . ucfirst($this->urlController) . ".php";
        $paramClasse = ucfirst($this->urlController);
        $paramMetodo = $this->urlMetodo;

        if (!$this->paginaExiste($paramArquivo, $paramClasse, $paramMetodo)) 
        {
            $this->urlController = "PaginaInvalida";
            $this->urlMetodo = "index";
        }
        $this->urlController = ucwords($this->urlController);
        $classe = "\\App\\Controller\\" . $this->urlController;
        $metodo = $this->urlMetodo;
        $pagina = new $classe();
        $pagina->$metodo();
        
    }

    private function paginaExiste($paramArquivo, $paramClasse, $paramMetodo): bool
    {
        $classe = "\\App\\Controller\\" . $paramClasse;
        $metodo = $paramMetodo;

        if (!file_exists($paramArquivo)) {
            return false;
        }
         else if (!class_exists($classe)) {
            return false;
        }

        $objeto = new $classe();

        if (!method_exists($objeto, $metodo)) {
            return false;
        }

        return true;
    }

    
}

?>