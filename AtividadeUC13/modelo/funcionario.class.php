<?php
    class Barbeiro{
        //Atributos
        private $idBarbeiro;
        private $nomeBarbeiro;
        private $senha;

        //Construtor
        public function __construct(){
            

        }//fecha o construtor

        public function Agenda(){

        }

        public function __get($atrib) {
            return $this->$atrib;
        }

        public function __set($atrib, $valor) {
            $this->$atrib = $valor;
        }

        public function __toString(){
            return '<br>Código: '.$this->idBarbeiro. 
                   '<br>Nome: '.$this->nomeBarbeiro. 
                   '<br>Senha: '.$this->senha; 
        }
    }//fecha a classe Usuario
?>