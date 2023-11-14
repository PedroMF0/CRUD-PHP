<?php
    class Validacao{

        public static function testarNome($valor){
            $exp='/[a-zA-Záéíóúâêîôûãõàèìòùäëïöüç]{3,50}$/u';
            if(preg_match($exp,$valor) ){
                return true;
            }else{
                return false;
            }//fecha o else
        }//fecha o método
    
        public static function testarDatetimeLocal($valor){
            $exp = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/';
            if(preg_match($exp, $valor)){
                return true;
            } else {
                return false;
            }
        }

        public static function testarTipoCorte($valor){
            $exp='/^(cabelo|barba|ambos)$/';
            if(preg_match($exp,$valor) ){
                return true;
            }else{
                return false;
            }//fecha o else
        }//fecha o método

        public static function retirarEspacos($valor){
            return trim($valor);
        }//fecha o método
    
        public static function escaparAspas($valor){
            return addslashes($valor);
        }//fecha o método

        public static function validarFiltro($valor){
            $exp = '/[a-zA-Záéíóúâêîôûãõàèìòùäëïöüç]{3,50}$/';
            if(preg_match($exp,$valor)){
                return true;
            }else{
                return false;
            }//fecha o else
        }//fecha o método

        public static function testarLogin($valor){
            $exp='/[a-zA-Záéíóúâêîôûãõàèìòùäëïöüç]{3,50}$/';
            if(preg_match($exp,$valor) ){
                return true;
            }else{
                return false;
            }//fecha o else
        }//fecha o método

        public static function testarSenha($valor){
            $exp='/^[0-9]{6,12}$/';
            if(preg_match($exp,$valor) ){
                return true;
            }else{
                return false;
            }//fecha o else
        }//fecha o método
    
    }
?>