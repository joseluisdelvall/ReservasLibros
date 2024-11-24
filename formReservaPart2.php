<?php

    require_once 'controlador/clibros.php';

    $clibros = new Clibros();
    var_dump($_POST);
    $libros = $clibros->obtenerLibrosDeCurso($_POST);
    
    if($libros != false) {
        require_once 'vista/vistaReservaPart2.php';
    }else {
        $m = $clibros->mensajeEstado;
        require_once 'vista/vistaError.php';
    }

    
    
?>