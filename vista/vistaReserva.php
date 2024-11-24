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
            <a href="https://fundacionloyola.com/vguadalupe/" target="_blank">
                <img src="img/logoEVG.png" alt="">
            </a>
            <nav>
                <a href="">Manual de Reserva</a>
                <a href="">Reserva Presencial</a>
            </nav>
        </header>
        <main>
            <section>
                <h1>Formulario de reserva</h1>
                <p class="parrafoCentrado">
                    Rellena el siguiente formulario para reservar tus libros.
                </p>
                <article>
                    <form action="formReservaPart2.php" method="POST" class="claseFormulario">
                        <label for="curso">Curso:</label>
                        <select name="curso" id="selectForm">
                            <option disabled selected> - Selecciona un curso - </option>
                            <?php

                                foreach ($cursos as $curso) {
                                    // Concatenamos la etiqueta en una varible y si el tipo no es nulo, lo concatenamos
                                
                                    // el option hay q hacerle un split para sacar el nombre del curso y el id al mismo tiempo
                                    $option = "<option value='".$curso['idCurso'].'#'.$curso['nombreCurso']."'>".$curso['nombreCurso'];

                                    if($curso['Tipo'] != "")
                                        $option = $option." - ".$curso['Tipo'];

                                    $option = $option."</option>";

                                    echo $option;

                                }
                                
                            ?>
                        </select>
                        <input type="submit">
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