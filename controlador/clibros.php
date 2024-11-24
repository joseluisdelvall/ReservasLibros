<?php
    
    class Clibros {

        public readonly string $idCurso;
        public readonly string $nomCurso; // https://php.watch/versions/8.1/readonly

        public readonly string $mensajeEstado;

        public function __construct() {}

        public function obtenerLibrosDeCurso($arrayCurso) {

            require_once 'modelo/mlibros.php';

            if(isset($arrayCurso['curso'])) {
                // hacemos el "split" para sacar los dos valores, en php explode

                $arrayCurso = explode("#", $arrayCurso['curso']);

                    // guardamos el nombre e id del curso para mostrarlo/usarlo en la vista
                $this->idCurso = $arrayCurso[0];
                $this->nomCurso = $arrayCurso[1];

                $idCurso = $arrayCurso[0];
                $mLibros = new Mlibros();
                $libros = $mLibros->obtenerLibrosDeCurso($idCurso);

                if($libros != false){

                    return $libros;

                } else {
                    
                    $this->mensajeEstado = "No se han encontrado libros para este curso";
                    return false;
                }
                
            }else{
                $this->mensajeEstado = "No se ha seleccionado un curso";
                return false;
            }

        }

    }
    
?>