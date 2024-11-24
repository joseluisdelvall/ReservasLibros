<?php
    
    class Ccursos {

        public function __construct() {
            require_once 'modelo/mcursos.php';
        }

        public function obtenerCursos() {

            $mdlCursos = new Mcursos();

            $resultado = $mdlCursos->obtenerCursos();

            if($resultado != false) {
                return $resultado;
            } else {
                return false;
            }

        }

    }
    
?>