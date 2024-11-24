<?php

    require_once 'controlador/ccursos.php';
    
    $objCursos = new Ccursos();
    $cursos = $objCursos->obtenerCursos();

    require_once 'vista/vistaReserva.php';

?>