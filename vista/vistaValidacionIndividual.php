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
                <h1>Solicitud de <?php echo $reserva['nombreAlumno'] ?></h1>
                <article id="validacionIndividual">
                    <div id="infoPersona">

                        <?php
                            echo '<p>';
                                echo '<span>Nombre:</span> ' . $reserva['nombreAlumno'];
                            echo '</p>';
                            echo '<p>';
                                echo '<span>Curso:</span> ' . $reserva['nombreCurso'];
                            echo '</p>';
                            echo '<div>';
                                echo '<p>';
                                    echo '<span>Libros:</span>';
                                echo '</p>';
                                echo '<ul>';
                                    foreach($reserva['libros'] as $libro) {
                                        echo '<li>' . $libro['Titulo'] . ' - ISBN ' . $libro['ISBN'] . ' - '
                                        . $libro['nomEditorial'] . ' - ' . $libro['Precio'] . '€' . '</li>';
                                    }
                                echo '</ul>';
                            echo '</div>';
                            echo '<p>';
                                echo '<span>Fecha:</span> ' . $reserva['Fecha'];
                            echo '</p>';
                        ?>

                        <a class="volverFlecha" href="">
                            <img src="img/hacia-atras.png" alt="">
                        </a>
                        <a id="aceptar" href="">Validar</a>
                        <a id="denegar" href="">Denegar</a>
                    </div>
                    <div id="divImagen">

                        <?php
                            
                            echo '<img src="' . RUTA_JUSTIFICANTES . $reserva['idAlumno'] . '/' . $reserva['rutaJustificante'] . '" alt="Imagen justificante">';
                            
                        ?>
                    </div>
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