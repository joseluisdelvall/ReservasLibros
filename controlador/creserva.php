<?php
    
    class Creserva {

        public readonly string $mensajeEstado;


        public function __construct() {
            require_once 'config/config.php';
        }

        public function guardarReserva($arrayReserva, $arrayFile) {

            require_once 'modelo/mreserva.php';

            // Comprobamos que los campos que siempre son obligatorios esten rellenos
            if(!empty($arrayReserva['nombreAlumno']) && !empty($arrayReserva['apellidosAlumno'])
                && !empty($arrayReserva['correo']) && isset($arrayReserva['libros']) /*&& !empty($arrayReserva['file'])*/) {

                if(filter_var($arrayReserva['correo'], FILTER_VALIDATE_EMAIL)){

                    $mReserva = new Mreserva();

                    // Comprobamos si la reserva la esta haciendo un padre o un alumno
                    if(!empty($arrayReserva['nombrePadre']) || !empty($arrayReserva['apellidosPadre']) || !empty($arrayReserva['dniPadre'])) {
                        /* ---------------------------------------- RESERVA DE PADRE ---------------------------------------- */

                        // Comprobamos si el padre ha introducido todos sus datos
                        if(!empty($arrayReserva['nombrePadre']) && !empty($arrayReserva['apellidosPadre']) && !empty($arrayReserva['dniPadre'])) {
                            // reserva realizada por el padre correctamente (al menos los datos estan introducidos)

                            $estado = $mReserva->reservaPadre($arrayReserva, $arrayFile);
                            $this->mensajeEstado = $mReserva->mensajeEstado;
                            return $estado;

                        } else {
                            // reserva realizada por el padre pero no ha introducido todos los datos
                            $this->mensajeEstado = "Si estas haciendo la reserva a su hijo, tiene que rellenar todos los datos del padre/madre/tutor";
                            return false;
                        }

                    } else {
                        /* ---------------------------------------- RESERVA DE ALUMNO ---------------------------------------- */

                        // Si esta realizada por alumno, comprobamos que se haya introducido su DNI (dnialumno)
                        if(!empty($arrayReserva['dniAlumno'])) {
                            // reserva realizada por el alumno correctamente (al menos los datos estan introducidos)

                            $estado = $mReserva->reservaAlumno($arrayReserva, $arrayFile);
                            $this->mensajeEstado = $mReserva->mensajeEstado;
                            return $estado;

                        } else {
                            // reserva realizada por el alumno pero no ha introducido el DNI
                            $this->mensajeEstado = "Reserva realizada por alumno SIN DNI";
                            return false;
                        }

                    }

                }else {
                    // el correo no es valido
                    $this->mensajeEstado = "Correo no valido";
                    return false;
                }

            } else {
                // no se han rellenado los campos obligatorios
                $this->mensajeEstado = "Rellena los campos obligatorios";
                return false;

            }

        }

        public function listarReservas() {
                
                require_once 'modelo/mreserva.php';
    
                $mReserva = new Mreserva();
                $reservas = $mReserva->obtenerReservas();
    
                return $reservas;
        }

        public function obtenerReserva($idReserva) {
                
                require_once 'modelo/mreserva.php';
    
                $mReserva = new Mreserva();
                $reserva = $mReserva->obtenerReserva($idReserva);
    
                return $reserva;
        }

    }
    
?>