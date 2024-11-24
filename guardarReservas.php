<?php

    require_once 'controlador/creserva.php';

    $cReserva = new Creserva();
    $estado = $cReserva->guardarReserva($_POST, $_FILES);

    if(!$estado){
        $m = $cReserva->mensajeEstado;
        require_once 'vista/vistaError.php';
    }else{
        $m = $cReserva->mensajeEstado;
        require_once 'vista/vistaCorrecto.php';
    }


?>