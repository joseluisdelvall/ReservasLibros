<?php
    
    require_once 'controlador/creserva.php';
    require_once 'config/config.php';

    $cReserva = new Creserva();
    $reserva = $cReserva->obtenerReserva($_GET['idReserva']);

    if($reserva != false) {

        require_once 'vista/vistaValidacionIndividual.php';

    } else {

        $m = $cReserva->mensajeEstado;
        require_once 'vista/vistaError.php';
        
    }

    
    
?>