<?php
    
    require_once 'controlador/creserva.php';

    $cReserva = new Creserva();
    $reservas = $cReserva->listarReservas();

    require_once 'vista/vistaValidacion.php';
    
?>