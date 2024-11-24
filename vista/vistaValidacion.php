<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reserva de Libros</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <a href="https://fundacionloyola.com/vguadalupe/" target="_blank"><img src="img/logoEVG.png" alt=""></a>
            <nav>
                <a href="">Gestión</a>
                <a href="">Info. Reservas</a>
                <a href="">Validación Solicitud</a>
                <a href="">Estadísticas</a>
            </nav>
        </header>
        <main>
            <section>
                <h1>Listado validaciones</h1>
                <article id="listado">

                    <?php
                        
                        foreach($reservas as $reserva) {

                            $a = '<a href="validacionIndividual.php?idReserva=' . $reserva['idReserva'] . '">' . $reserva['nombreAlumno'] . ' - ' . $reserva['nombreCurso'];
                            if($reserva['Tipo']) {
                                $a = $a . ' - ' . $reserva['Tipo'];
                            }
                            $a = $a . ' - ' . $reserva['Fecha'] . '</a>';
                            echo $a;
                            
                        }
                        
                    ?>
                </article>
            </section>
        </main>
        <footer>
            <p>
                Escuela Virgen de Guadalupe
            </p>
            <p>
                Grupo 2
            </p>
        </footer>
    </body>
</html>