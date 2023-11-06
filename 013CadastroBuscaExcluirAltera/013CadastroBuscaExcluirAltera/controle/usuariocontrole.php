<?php
session_start();
session_unset();//removendo as sessões anteriores

include_once '../modelo/usuario.class.php';
include_once '../util/validacao.class.php';
include_once '../dao/usuariodao.class.php';
include_once '../util/controlelogin.class.php';


if( isset($_GET['op'])) {
    switch($_GET['op']) {

        case 'cadastrar':
            //Cadastro com validação - testando se existem
            if( isset($_POST['txtlogin']) &&
                isset($_POST['txtsenha']) &&
                isset($_POST['seltipo']) ) {

                    //Recebendo os Dados
                    $login = $_POST['txtlogin'];
                    $senha = $_POST['txtsenha'];
                    $tipo = $_POST['seltipo'];

                    //fazendo a validação
                    $erros = array();

                    if(!Validacao::testarLogin($_POST['txtlogin']) ){
                        $erros[] = 'Login inválido!';
                    }

                    if(!Validacao::testarSenha($_POST['txtsenha']) ){
                        $erros[] = 'Senha inválida!';
                    }

                    if(!Validacao::testarTipo($_POST['seltipo']) ){
                        $erros[] = 'Tipo inválido!';
                    }

                    if( count($erros) == 0){
                        $u = new Usuario();
                        $u->login = $_POST['txtlogin'];
                        $u->senha = $_POST['txtsenha'];
                        $u->tipo = $_POST['seltipo'];

                        /*Enviar o objeto $u para o banco de dados */
                        $uDAO = new UsuarioDAO();
                        $uDAO->cadastrarUsuario($u);

                        $_SESSION['usuario']=serialize($u);

                        header("location:../visao/guiresposta.php");
                    }else{
                        $_SESSION['erros'] = serialize($erros);
                        header("location:../visao/guierro.php");
                    }//fecha o if do count
            }else{
            echo 'DEU PROBLEMA!';
            }//fecha o isset

        break; //fecha case cadastrar

        case 'consultar':
           
            $uDAO = new UsuarioDAO();
            $array = array();
            $array = $uDAO->buscarUsuario();

            $_SESSION['usuario']=serialize($array);
            header("location:../visao/guiconsulta.php"); 
            
        break; //fecha case consultar

        case 'deletar':
            if( isset($_REQUEST['idUsuario']) ){
                $uDAO = new UsuarioDAO();
                $uDAO->deletarUsuario($_REQUEST['idUsuario']);
                header("location:../controle/usuariocontrole.php?op=consultar");
            }else{
                echo 'idUsuario não existe!';
            }
        break;//fecha case deletar

        case 'logar':
            if( isset($_POST['txtlogin']) &&
                isset($_POST['txtsenha']) ){
                    
                    $cont = 0;
                    if(!Validacao::testarLogin($_POST['txtlogin']) ){
                        $cont++;
                    }

                    if(!Validacao::testarSenha($_POST['txtsenha']) ){
                        $cont++;
                    }

                    if($cont == 0){
                        $login = Validacao::retirarEspacos($_POST['txtlogin']);
                        $login = Validacao::escaparAspas($login);

                        $senha = Validacao::retirarEspacos($_POST['txtsenha']);
                        $senha = Validacao::escaparAspas($senha);

                        //Montando o objeto
                        $usuario = new Usuario();
                        $usuario->login = $login;
                        $usuario->senha = $senha;
                        //Logar
                        ControleLogin::logar($usuario);
                        
                    }else{
                        $_SESSION['msg'] = "Login ou senha inválidos!";
                        header("location:../visao/guiresposta.php");
                    }//fim do else do if cont == 0
                }else{
                    echo 'Não existe txtlogin e/ou txtsenha!';
                }//fecha o else do isset
        break;

        case 'deslogar':
            ControleLogin::deslogar();
        break;
        
        case 'buscar':
            if( isset($_POST['txtfiltro']) &&
                isset($_POST['rdfiltro']) ){

                    $erros = array();
                    if(!Validacao::validarFiltro($_POST['txtfiltro']) ){
                        $erros[] = 'Dado inválido!';
                    }

                    if(count($erros) == 0){
                        $uDAO = new UsuarioDAO();
                        $usuario = array();
                    

                    if($_POST['rdfiltro'] == 'idusuario'){
                        $query = "where idUsuario = ".$_POST['txtfiltro'];
                    }else if($_POST['rdfiltro'] == 'login'){
                        $query = "where login = \"".$_POST['txtfiltro'].'"';
                    }else if($_POST['rdfiltro'] == 'parteslogin'){
                        $query = "where login like \"%".$_POST['txtfiltro'].'%"';
                    }else{
                        $query = "where tipo = \"".$_POST['txtfiltro'].'"';
                    }//fecha o else do if $_POST

                    $usuario = $uDAO->buscar($query);

                    $_SESSION['usuario']=serialize($usuario);
                    header("location:../visao/guiconsulta.php");

                    }else{
                        $_SESSION['erros'] = serialize($erros);
                        header("location:../visao/guierro.php");
                    }//fecha o else
                }else{
                    echo 'Variáveis não existem!';
                }
        break;

        case 'alterar':
            if(isset($_GET['idUsuario']) ){
                $query = 'where idusuario = '.$_GET['idUsuario'];

                $uDAO = new UsuarioDAO();
                $usuarios = array();
                $usuarios = $uDAO->buscar($query);

                $_SESSION['usuario'] = serialize($usuarios);
                header("location:../visao/guialterar.php");
            }else{
                echo 'Não existem variáveis!';
            }
        break;

        case 'confirmalterar':
            if( isset($_POST['txtidusuario']) &&
                isset($_POST['txtlogin']) &&
                isset($_POST['txtsenha']) &&
                isset($_POST['seltipo']) ){

                    $idUsuario = $_POST['txtidusuario'];
                    $login = $_POST['txtlogin'];
                    $senha = $_POST['txtsenha'];
                    $tipo = $_POST['seltipo'];

                   $erros = array();

                    if(!Validacao::testarLogin($_POST['txtlogin']) ){
                        $erros[] = 'Login inválido!';
                    }

                    if(!Validacao::testarSenha($_POST['txtsenha']) ){
                        $erros[] = 'Senha inválida!';
                    }

                    if(!Validacao::testarTipo($_POST['seltipo']) ){
                        $erros[] = 'Tipo inválido!';
                    }

                    if( count($erros) == 0){
                        $u = new Usuario();
                        $u->idusuario = $idUsuario;
                        $u->login = $login;
                        $u->senha = $senha;
                        $u->tipo = $tipo;

                        /*Enviar o objeto $u para o banco de dados */
                        $uDAO = new UsuarioDAO();
                        $uDAO->alterarUsuario($u);

                        $_SESSION['u']=serialize($u);

                        header("location:../controle/usuariocontrole.php?op=consultar");

                    }else{
                      $_SESSION['erros'] = serialize($erros);
                      header("location:../visao/guierro.php");
                    }
            }
        break;

        default: echo 'Erro no switch';
        break;
    }//fecha o switch
}else{
    echo 'Variável op não existe!';
}//fecha o else isset op
?>