<?php
include_once '../dao/agendadao.class.php';
include_once '../dao/funcdao.class.php';

class ControleLogin{

    public static function logar($b){
        $fDAO = new FuncionarioDAO();
        $barbeiro = $fDAO->verificarBarbeiro($b);

        if($barbeiro && !is_null($barbeiro)) {
            $_SESSION['privateUser']=serialize($barbeiro);

            header("location:../index.php");
            
        }else{
            $_SESSION['msg']='Login ou Senha inválidos!';
            header("location:../visao/guiresposta.php");
        }//fecha o if
    }//fecha o método logar

    public static function deslogar(){
        unset($_SESSION['privateUser']);
        $_SESSION['msg']='Você foi deslogado!';
        header("location:../visao/guiresposta.php");
    }//fecha o método deslogar

    public static function verificarAcesso(){
        if(!isset($_SESSION['privateUser']) ){
            $_SESSION['msg']='Você não está logado!';
            header("location:../visao/guiresposta.php");
        }//fim do if
    }//fecha o método verificar acesso
}
?>