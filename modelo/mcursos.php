<?php
    
    class Mcursos {

        private $conexion;

        public function __construct() {
            require_once 'config/configdb.php';
            $this->conexion = new mysqli($servidor, $usuario, $contrasena, $bd);
            $this->conexion->set_charset("utf8");
        }

        public function obtenerCursos() {
            
            $sql = "SELECT idCurso, nombreCurso, Tipo FROM Cursos";
            $resultado = $this->conexion->query($sql);
            
            if($resultado->num_rows > 0) {
                
                while($row = $resultado->fetch_assoc()) {
                    $cursos[] = $row;
                }
                
                return $cursos;

            } else {
                return false;
            }
        }

    }
    
?>