<?php
    
    class Mlibros {

        private $conexion;

        public function __construct() {
            require_once 'config/configdb.php';
            $this->conexion = new mysqli($servidor, $usuario, $contrasena, $bd);
            $this->conexion->set_charset("utf8");
        }

        public function obtenerLibrosDeCurso($idCurso) {

            $sql = 'SELECT libros.ISBN, titulo, precio, nomEditorial FROM libros
                    INNER JOIN libroscursos LC ON libros.ISBN = LC.ISBN
                    INNER JOIN cursos ON LC.idCurso = cursos.idCurso
                    INNER JOIN editorial ON libros.idEditorial = editorial.idEditorial
                    WHERE cursos.idCurso = '.$idCurso.';';
            $resultado = $this->conexion->query($sql);
            
            if($resultado->num_rows > 0) {
                
                $libros = array();
                while($libro = $resultado->fetch_assoc()) {
                    $libros[] = $libro;
                }
                
                return $libros;

            } else {
                return false;
            }
        }

    }
    
?>