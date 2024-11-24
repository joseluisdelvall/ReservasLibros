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
                <a href="">Manual de Reserva</a>
                <a href="">Reserva Presencial</a>
            </nav>
        </header>
        <main>
            <section>
                <h1>Formulario de reserva</h1>
                <p class="parrafoCentrado">
                    Continua con la reserva de tus libros, selecciona cuáles deseas reservar.
                </p>
                <p class="parrafoCentrado">
                    Si quieres reservas los libros de tu hijo recuerda rellenar los campos de padre/madre/tutor.
                    Si vas a reservar tus propios libros omite los campos padre/madre/tutor
                </p>
                <article>
                    <form action="guardarReservas.php" method="POST" class="claseFormulario" enctype="multipart/form-data">
                        <input type="text" name="nombreAlumno" placeholder="Nombre Alumno*">
                        <input type="text" name="apellidosAlumno" placeholder="Apellidos Alumno*">
                        <input type="text" name="dniAlumno" placeholder="DNI Alumno">
                        <input type="text" name="nombrePadre" placeholder="Nombre Padre/Madre/Tutor">
                        <input type="text" name="apellidosPadre" placeholder="Apellidos Padre/Madre/Tutor">
                        <input type="text" name="dniPadre" placeholder="DNI Padre/Madre/Tutor">
                        <input type="text" name="correo" placeholder="Correo Electronico de Contacto*">
                        <?php
                            
                            // sacamos el nombre del curso con la propiedad del controlador de libros
                            echo '<label for="libros">Libros de '.$clibros->nomCurso.'</label>';
                            echo '<div>';

                                foreach($libros as $libro) {
                                    echo '<input type="checkbox" id="'.$libro['ISBN'].'" name="libros[]" value="'.$libro['ISBN'].'">';
                                    echo '<label for="'.$libro['ISBN'].'">'.$libro['titulo'].' - '.$libro['precio'].'€</label><br>';
                                }

                            echo '</div>';
                        ?>
                        <label for="file-upload" id="archivoSubida">Selecciona un archivo</label>
                        <input type="file" name="file" id="file-upload">
                        <?php
                            
                            // sacamos el nombre del curso con la propiedad del controlador de libros
                            echo '<input type="hidden" name="curso" value="'.$clibros->idCurso.'">';
                            
                        ?>
                        <input type="submit">
                        <a class="volverFlecha" href="formReserva.php">
                            <img src="img/hacia-atras.png" alt="">
                        </a>
                    </form>
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