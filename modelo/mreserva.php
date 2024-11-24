<?php
    
    class Mreserva {

        public string $mensajeEstado;

        private $conexion;
        public function __construct() {
            require_once 'config/configdb.php';
            $this->conexion = new mysqli($servidor, $usuario, $contrasena, $bd);
            $this->conexion->set_charset("utf8");
        }

        public function reservaPadre($arrayReserva, $arrayFile) {
            // Aqui entramos con todos los datos validados del Padre y Alumno

            $nombrePadre = $arrayReserva['nombrePadre'] . ' ' . $arrayReserva['apellidosPadre'];
            $dniPadre = $arrayReserva['dniPadre'];
            $nombreAlumno = $arrayReserva['nombreAlumno'] . ' ' . $arrayReserva['apellidosAlumno'];
            if(!empty($arrayReserva['dniAlumno'])) {
                $dniAlumno = '"' . $arrayReserva['dniAlumno'] . '"';
            } else {
                $dniAlumno = 'NULL';
            }
            $correo = $arrayReserva['correo'];
            $libros = $arrayReserva['libros'];
            $idCurso = $arrayReserva['curso'];

            // BUSCAR MANERA DE VALIDAR SI ESA RESERVA YA ESTA HECHA, CON DNIAlumno NO PODEMOS YA QUE PUEDE SER NULL
            $idPadre = $this->altaPadre($nombrePadre, $dniPadre);
            if($idPadre == false) {
                $m = $this->mensajeEstado;
                return false;
            };

            $estado = $this->reserva($arrayFile, $nombreAlumno, $dniAlumno, $correo, $libros, $idCurso, $idPadre);
            return $estado;

        }

        public function reservaAlumno($arrayReserva, $arrayFile) {
            // Aqui entramos con todos los datos validados del Alumno

            $nombreAlumno = $arrayReserva['nombreAlumno'] . ' ' . $arrayReserva['apellidosAlumno'];
            $dniAlumno = '"' . $arrayReserva['dniAlumno'] . '"';
            $correo = $arrayReserva['correo'];
            $libros = $arrayReserva['libros'];
            $idCurso = $arrayReserva['curso'];
            $idPadre = 'NULL';

            $estado = $this->reserva($arrayFile, $nombreAlumno, $dniAlumno, $correo, $libros, $idCurso, $idPadre);
            return $estado;
        }

        private function reserva($arrayFile, $nombreAlumno, $dniAlumno, $correo, $libros, $idCurso, $idPadre) {
            // Introducir el alumno
            $idAlum = $this->altaAlumno($nombreAlumno, $dniAlumno, $correo, $idCurso, $idPadre);
            if($idAlum != false) {
                
                try {
                    $rutaJustificante = $this->guardarArchivoLocal($arrayFile, $idAlum);
                } catch (Exception $e) {
                    $this->mensajeEstado = "Error al guardar el archivo: " . $e->getMessage();
                    return false;
                }

                $fecha = date('Y-m-d');
                $idReserva = $this->altaReserva($fecha, $rutaJustificante, $idAlum, $libros);
                if($idReserva == false) {
                    $m = $this->mensajeEstado;
                    return false;
                } else {
                    $this->mensajeEstado = "Reserva realizada correctamente, tu codigo de reserva es: " . $idReserva;
                    return true;
                }

            }else {
                
                return false;

            }
            
        }

        private function guardarArchivoLocal($arrayFile, $idAlumno) {
            // Guardamos el archivo en la carpeta justificantes
            $rutaDirectorio = RUTA_JUSTIFICANTES . $idAlumno . '/';

            /* 
                creo el directorio del usuario, no hace falta validar el
                directorio ya que no entran usuarios que tengan un directorio ya creado
            */
            mkdir($rutaDirectorio , 0750, true);

            if(move_uploaded_file($arrayFile['file']['tmp_name'], $rutaDirectorio . $arrayFile['file']['name'])) {
                return $arrayFile['file']['name'];
            } else {
                return false;
            }
        }

        /* 
         * Intenta añadir el Padre a la base de datos, si ya existe devuelve su id
         */
        private function altaPadre($nomPadre, $dniPadre) {

            $sql = 'INSERT INTO padres (nomPadre, DNI) VALUES ("'.$nomPadre.'", "'.$dniPadre.'")';

            try {
                $this->conexion->query($sql);
            }catch (mysqli_sql_exception $e) {

                if($e->getCode() == 1062) {
                    return $this->obtenerIdPadre($dniPadre);
                }else {
                    $this->mensajeEstado = $e->getMessage();
                    return false;
                }
            }

            return $this->conexion->insert_id;

        }

        private function obtenerIdPadre($dniPadre) {

            $sql = 'SELECT idPadre FROM padres WHERE DNI = "'.$dniPadre.'"';

            $resultado = $this->conexion->query($sql);

            if($resultado->num_rows > 0) {
                return $resultado->fetch_assoc()['idPadre'];
            } else {
                return false;
            }

        }

        private function altaAlumno($nombreAlumno, $dniAlumno, $correo, $idCurso, $idPadre) {

            $sql = 'INSERT INTO alumnos (nombreAlumno, DNIalumno, correo, idCurso, idPadre) VALUES
                    ("'.$nombreAlumno.'", '.$dniAlumno.', "'.$correo.'", '.$idCurso.', '.$idPadre.')';

            try {
                $this->conexion->query($sql);

            }catch (mysqli_sql_exception $e) {
                if($e->getCode() == 1062) {
                    $this->mensajeEstado = "Este alumno ya tiene una reserva";
                }else {
                    $this->mensajeEstado = $e->getMessage();
                }
                return false;
            }

            return $this->conexion->insert_id;

        }

        private function altaReserva($fecha, $rutaJustificante, $idAlum, $libros) {

            $sql = 'INSERT INTO reservas (fecha, rutaJustificante, idAlumno) VALUES
                    ("'.$fecha.'", "'.$rutaJustificante.'", '.$idAlum.')';

            try {

                $this->conexion->query($sql);

            }catch (mysqli_sql_exception $e) {
                $this->mensajeEstado = $e->getMessage();
                return false;
            }


            $idReserva = $this->conexion->insert_id;
            if($this->altaLibrosReservas($idReserva, $libros)) {
                return $idReserva;
            } else {
                return false;
            }

        }

        private function altaLibrosReservas($idReserva, $libros) {

            $sql = 'INSERT INTO ReservasLibros (idReserva, ISBN) VALUES ';

            foreach($libros as $libro) {
                $sql .= '('.$idReserva.', '.$libro.'),';
            }

            $sql = substr($sql, 0, -1);

            try {
                $this->conexion->query($sql);
            }catch (mysqli_sql_exception $e) {
                $this->mensajeEstado = $e->getMessage();
                return false;
            }

            return true;
            
        }

        public function obtenerReservas() {
            
            $sql = "SELECT idReserva, Fecha, nombreAlumno, nombreCurso, Tipo
                    FROM reservas
                    INNER JOIN alumnos ON reservas.idAlumno = alumnos.idAlumno
                    INNER JOIN cursos ON cursos.idCurso = alumnos.idCurso
                    ORDER BY Fecha ASC";

            try {
                $resultado = $this->conexion->query($sql);
            } catch (mysqli_sql_exception $e) {
                $m = $e->getMessage();
                require_once 'vista/vistaError.php';
            }

            $reservas = array();
            while($fila = $resultado->fetch_assoc()) {
                $reservas[] = $fila;
            }

            return $reservas;

        }

        public function obtenerReserva($idReserva) {
            
            $sql = "SELECT idReserva, Fecha, nombreAlumno, nombreCurso, Tipo, rutaJustificante, correo, DNIalumno, alumnos.idAlumno
                    FROM reservas
                    INNER JOIN alumnos ON reservas.idAlumno = alumnos.idAlumno
                    INNER JOIN cursos ON cursos.idCurso = alumnos.idCurso
                    WHERE idReserva = ".$idReserva;

            try {
                $resultado = $this->conexion->query($sql);
                $reserva = $resultado->fetch_assoc();

                // Consulta para obtener los libros asignados
                $sqlLibros = "SELECT Titulo, Precio, libros.ISBN, nomEditorial
                            FROM ReservasLibros
                            INNER JOIN libros ON ReservasLibros.ISBN = libros.ISBN
                            INNER JOIN editorial ON libros.idEditorial = editorial.idEditorial
                            WHERE ReservasLibros.idReserva = ".$idReserva;

                $resultadoLibros = $this->conexion->query($sqlLibros);
                $libros = array();
                while ($fila = $resultadoLibros->fetch_assoc()) {
                    $libros[] = $fila;
                }

                // Añadir los libros a la reserva
                $reserva['libros'] = $libros;

            } catch (mysqli_sql_exception $e) {
                $m = $e->getMessage();
                require_once 'vista/vistaError.php';
            }

            return $reserva;

        }

    }
    
?>