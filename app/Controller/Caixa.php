<?php 
    namespace App\Controller;

    if(!defined("MERCEARIA2021")) // verificar se a constante criada no index, foi definida!
    {   
        header("Location: http://localhost/mercearia/paginaInvalida/index");
        die("Erro: Página não encontrada!");
    }

    class Caixa extends Controller
    {
        private $dados = array();

        public function index()
        {
            if(isset($_SESSION['caixa']))
            {
                $id['id'] = array_key_first($_SESSION['caixa']);
                $produto = new \App\Model\Caixa();
                $this->dados = $produto->produtoAjax($id);
                $pagina = new \Core\ConfigView("View/caixa/index",$this->dados['lista']);
            }
            else{
                $pagina = new \Core\ConfigView("View/caixa/index",$this->dados);
            }
            
            $pagina->renderizar();
           
        }
        public function pedido()
        {
            $dados = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $cadastro = new \App\Model\Caixa();
            $cadastro->cadastrar($dados);
        }

        public function listaProdutosAjax()
        {
            $pesquisa['pesquisa'] = '%'.filter_input(INPUT_POST,'pesquisa',FILTER_SANITIZE_STRING).'%';
            $listar = new \App\Model\Caixa();
            $dados = $listar->listaProdutosAjax($pesquisa);

            echo json_encode($dados,JSON_UNESCAPED_UNICODE);
        }
        public function produtoAjax()
        {
            $id['id'] = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);

            if(isset($_SESSION['caixa'][$id['id']]))
            {
                $_SESSION['caixa'][$id['id']] +=1; 
            }

            $produto = new \App\Model\Caixa();
            $dados = $produto->produtoAjax($id);

            echo json_encode($dados,JSON_UNESCAPED_UNICODE);
        }
        public function remover()
        {
            if(filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT))
            {
                $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
                
                if(isset($_SESSION['caixa'][$id]))
                {
                    unset($_SESSION['caixa'][$id]);
                }
                header("Location:".URL. "caixa");
                exit();
            }
            
        }
        public function quantidade()
        {
            $dados = filter_input_array(INPUT_POST,FILTER_VALIDATE_INT);

            if(isset($dados['id']) && !empty($dados['id']) && $dados['id'] > 0 &&
                isset($dados['quantidade']) && !empty($dados['quantidade']) && $dados['quantidade'] > 0)
            {
                $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
                $quantidade = filter_input(INPUT_POST,'quantidade',FILTER_VALIDATE_INT);

                $_SESSION['caixa'][$id] = intval($quantidade,10);
                $array['id'] = $id;
                $produto = new \App\Model\Caixa();
                $dados = $produto->produtoAjax($array);

                echo json_encode($dados,JSON_UNESCAPED_UNICODE);
            }
 
        }
        public function cancelarTudo()
        {
            unset($_SESSION['caixa']);
            header("Location:".URL. "caixa");
            exit();
        }
    }
