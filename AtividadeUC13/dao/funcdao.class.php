<?php
include_once '../persistencia/conexaobanco.class.php';
class FuncionarioDAO{
    private $conexao=null;

    public function __construct(){
        $this->conexao = ConexaoBanco::getInstancia();
    }

    public function verificarBarbeiro($b){
        try{    
            $stat = $this->conexao->query("select * from barbeiro where nomeBarbeiro = '$b->nomeBarbeiro' and senha = '$b->senha'");

            $barbeiro = $stat->fetchObject('barbeiros');
            return $barbeiro;
        }catch(PDOException $e){
            echo 'Erro ao verificar barbeiro!';
        }//fecha o catch
    }//fecha o método

    public function cadastrarBarbeiro($barb){
        try{
            $stat = $this->conexao->prepare("insert into barbeiros(idBarbeiro,nomeBarbeiro,senha)values(null,?,?)" );

            $stat->bindValue(1,$barb->nomeBarbeiro);
            $stat->bindValue(2,$barb->senha);

            $stat->execute();

            //Encerrando a conexao
            $this->conexao=null;
            
        }catch(PDOException $e){
            echo 'Erro ao cadastrar barbeiro!';
        }//fecha o catch
    }//fecha o método
}
?>