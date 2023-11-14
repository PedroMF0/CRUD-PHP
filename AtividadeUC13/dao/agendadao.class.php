<?php
include_once '../persistencia/conexaobanco.class.php';
class AgendaDAO{
    private $conexao=null;

    public function __construct(){
        $this->conexao = ConexaoBanco::getInstancia();
    }

    public function marcarHorario($mh){
        try{
            $stat = $this->conexao->prepare("insert into agenda(idCliente, nomeCliente, data_hora, tipoCorte)values(null, ?, ?, ?) ");

            $stat->bindValue(1,$mh->nomeCliente);
            $stat->bindValue(2,$mh->data);
            $stat->bindValue(3,$mh->hora);
            $stat->bindValue(4,$mh->tipoCorte);

            $stat->execute();

            $this->conexao=null;

        }catch(PDOException $e){
            echo 'Erro ao marcar horário!';
        }//fecha o catch
    }//fecha o método

    public function buscarCliente(){
        try{
            $stat = $this->conexao->query("select * from agenda" );

            $array = array();
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'agenda');

            $this->conexao=null;
            return $array;

        }catch(PDOException $e){
            echo 'Erro ao buscar cliente!';
        }//fecha o catch
    }//fecha o método

    public function deletarCliente($idCliente){
        try{
            $stat = $this->conexao->prepare("delete from agenda where idCliente = ?");

            $stat->bindValue(1,$idCliente);
            $stat->execute();
            
            $this->conexao=null;
        }catch(PDOException $e){
            echo 'Erro ao deletar cliente!';
        }//fecha o catch
    }//fecha o método

    
    public function buscar($query){
        try{
            $stat = $this->conexao->query("select * from agenda ".$query);
            $array = $stat->fetchAll(PDO::FETCH_CLASS, 'agenda');
            $this->conexao = null;
            return $array;
        }catch(PDOException $e){
            echo 'Erro ao buscar com filtro!';
        }

    }//fecha o método

    public function alterarCliente($age){
        try{
            $stat = $this->conexao->prepare('update agenda set nomeCliente = ?, data_hora = ?, tipoCorte = ? where idCliente = ?');
            $stat->bindValue(1,$age->nomeCliente);
            $stat->bindValue(2,$age->data_hora);
            $stat->bindValue(3,$age->tipoCorte);
            $stat->bindValue(4,$age->idCliente);

            $stat->execute();

            $this->conexao = null;
        }catch(PDOException $e){
            echo 'Erro ao alterar cliente!';
        }
    }//fecha o método

}
?>