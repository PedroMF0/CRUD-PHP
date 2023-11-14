<?php
session_start();

include_once '../modelo/agenda.class.php';
include_once '../util/validacao.class.php';
include_once '../dao/agendadao.class.php';
include_once '../util/controlelogin.class.php';
include_once '../dao/funcdao.class.php';
include_once '../modelo/funcionario.class.php';

if( isset($_GET['op']) ){
    switch($_GET['op']){

        case 'marcarhora':
            if( isset($_POST['txtnome']) &&
                isset($_POST['data_hora']) &&
                isset($_POST['tipo_corte']) ) {
    
                    //fazendo a validação
                    $erros = array();
    
                    if(!Validacao::testarNome($_POST['txtnome']) ){
                        $erros[] = 'Nome inválido!';
                    }
    
                    if(!Validacao::testarDatetimeLocal($_POST['data_hora']) ){
                        $erros[] = 'Data inválida!';
                    }
    
                    if(!Validacao::testarTipoCorte($_POST['tipo_corte']) ){
                        $erros[] = 'Tipo inválido!';
                    }
    
                    if( count($erros) == 0){
                        $a = new Agenda();
                        $a->nomeCliente = $_POST['txtnome'];
                        $a->data_hora = $_POST['data_hora'];
                        $a->tipoCorte = $_POST['tipo_corte'];
    
                        /*Enviar o objeto $u para o banco de dados */
                        $aDAO = new AgendaDAO;
                        $aDAO->marcarHorario($mh);
    
                        $_SESSION['agenda']=serialize($a);
                        $_SESSION['msg'] = 'O cliente '.$a->nomeCliente.' foi agendado com sucesso!';
    
                        header("location:../visao/guiresposta.php");
                    }else{
                        $e = serialize($erros);
                        header("location:../visao/guierro.php?erros=$e");
                    }//fecha o if do count
              }else{
                 echo 'Variaveis inválidas!';
              }//fecha o isset
        break;

        case 'consultarcliente':
            $aDAO = new AgendaDAO();

            $array = array();
            $array = $uDAO->buscarCliente();

            $_SESSION['agenda'] = serialize($array);
            header("location:../visao/guiconsulta.php");
        break;

        case 'buscarcliente':
            if( isset($_POST['txtfiltro']) &&
                isset($_POST['rdfiltro'])){
                    $erros = array();
                    if(!Validacao::validarFiltro($_POST['txtfiltro'])){
                        $erros[] = 'Dado Inválido!';
                    }

                    if(count($erros) == 0){
                        $aDAO = new AgendaDAO();
                        $agenda = array();
                    

                        if ($_POST['rdfiltro'] == 'idCliente') {
                            $query = "where idCliente = " . $_POST['txtfiltro'];
                        } else if ($_POST['rdfiltro'] == 'nomeCliente') {
                            $query = "where nome = \"" . $_POST['txtfiltro'] . "\"";
                        } else if ($_POST['rdfiltro'] == 'partesnome') {
                            $query = "where nome like '%" . $_POST['txtfiltro'] . "%'";
                        } else {
                            $query = "where tipoCorte = \"" . $_POST['txtfiltro'] . "\"";
                        }
                        

                    $agenda = $aDAO->buscar($query);

                    $_SESSION['agenda']=serialize($agenda);
                    header('location:../visao/guiconsulta.php');
                }else{
                    $_SESSION['erros'] = serialize($erros);
                    header('location:../visao/guierro.php');
                }
                }else{
                    echo 'Variáveis não existem!';
                }

        break;

        case 'deletar':
            if( isset($_REQUEST['idCliente'])){
                $aDAO = new AgendaDAO();
                $aDAO->deletarCliente($_REQUEST['idCliente']);

                header('location:../controle/agendacontrole.php?op=consultar');
            }else{
                echo'idCliente não existe';
            }

        break;

        case 'alterar':
            if( isset($_GET['idCliente'])){
                $query = 'where idCliente = '.$_GET['idCliente'];

                $aDAO = new AgendaDAO();
                $agendas = array();
                $agendas = $uDAO->buscar($query);

                $_SESSION['agenda'] = serialize($agendas);
                header('location:../visao/guialterar.php');

            }else{
                echo 'Não existem variáveis!';
            }
        break;

        case 'confirmalterar';
        if( isset($_POST['txtidcliente']) &&
        isset($_POST['txtnome']) &&
        isset($_POST['data_hora']) &&
        isset($_POST['tipo_corte'])){

            $idCliente = $_POST['txtidcliente'];
            $nomeCliente = $_POST['txtnome'];
            $data_hora = $_POST['data_hora'];
            $tipoCorte = $_POST['tipo_corte'];

            $erros = array();

            if(!Validacao::testarNome($_POST['txtnome']) ){
                $erros[] = 'Nome inválido!';
            }

            if(!Validacao::testarDatetimeLocal($_POST['data_hora']) ){
                $erros[] = 'Data inválida!';
            }

            if(!Validacao::testarTipoCorte($_POST['tipo_corte']) ){
                $erros[] = 'Tipo inválido!';
            }

            if( count($erros) == 0){
                $a = new Agenda();
                $a->nomeCliente = $_POST['txtnome'];
                $a->data = $_POST['data_hora'];
                $a->hora = $_POST['data_hora'];
                $a->tipoCorte = $_POST['tipo_corte'];

                $aDAO = new AgendaDAO();
                $aDAO->alterarCliente($a);
                $_SESSION['a'] = serialize($a);
                header('location:../controle/agendacontrole.php?op=consultar');
            }else{
                $_SESSION['erros'] = serialize($erros);
                header('location:../visao/guierro.php');
            }

        }else{
            echo 'Variáveis não existem!';
        }
        break;

        case 'logar':
            if( isset($_POST['txtlogin']) &&
                isset($_POST['txtsenha'])){
                $cont = 0;

                if(!Validacao::testarLogin($_POST['txtlogin'])){
                    $cont++;
                }

                if(!Validacao::testarSenha($_POST['txtsenha'])){
                    $cont++;
                }

                if($cont == 0){
                    $nomeBarbeiro = Validacao::retirarEspacos($_POST['txtlogin']);
                    $nomeBarbeiro = Validacao::escaparAspas($nomeBarbeiro);

                    $senha = Validacao::retirarEspacos($_POST['txtsenha']);
                    $senha = Validacao::escaparAspas($senha);

                    $barbeiro = new Barbeiro();

                    
                    $barbeiro->nomeBarbeiro = $nomeBarbeiro;
                    $barbeiro->senha = $senha;
                    ControleLogin::logar($barbeiro);
                }else{
                    $_SESSION['msg'] = 'Login/Senha inválidos!';
                    header('location:../visao/guiresposta.php');
                }

            }else{
                echo'Não existe txtlogin e/ou txtsenha!!';
            }
        break;

        case 'deslogar':
            ControleLogin::deslogar();
        break;

        case 'cadastrar':
            if( isset($_POST['txtlogin']) &&
            isset($_POST['txtsenha']) ) {

                //fazendo a validação
                $erros = array();

                if(!Validacao::testarLogin($_POST['txtlogin']) ){
                    $erros[] = 'Login inválido!';
                }

                if(!Validacao::testarSenha($_POST['txtsenha']) ){
                    $erros[] = 'Senha inválida!';
                }

                if( count($erros) == 0){
                    $barbeiro = new Barbeiro();
                    $barbeiro->nomeBarbeiro = $_POST['txtlogin'];
                    $barbeiro->senha = $_POST['txtsenha'];

                    /*Enviar o objeto $u para o banco de dados */
                    $fDAO = new FuncionarioDAO();
                    $fDAO->cadastrarBarbeiro($barb);

                    $_SESSION['barbeiros']=serialize($b);
                    $_SESSION['msg'] = 'O barbeiro '.$b->nomeBarbeiro.' foi cadastrado com sucesso!';

                    header("location:../visao/guiresposta.php");
                }else{
                    $e = serialize($erros);
                    header("location:../visao/guierro.php?erros=$e");
                }//fecha o if do count
          }else{
             echo 'Variaveis inválidas!';
          }//fecha o isset
        break;

        default: 'Erro no switch!';
        break;

    }//fecha o switch
}else{
    echo 'Variável não existe!';
}//fecha o if else







?>