<!doctype html>
<html lang="en">

<head>
    <title>Detalles de la Expulsión</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <?php
        require_once "./archivosComunes/navPartes.php";
        ?>
    </header>
    <main class="p-4 col-11 m-auto">
        <div class=" m-2">
            <?php
            // Incluir el archivo de conexión a la base de datos
            require_once "../archivosComunes/conexion.php";

            // Verificar si se proporcionó el parámetro cod_expulsion en la URL
            if (isset($_GET['cod_expulsion'])) {
                // Obtener el valor del parámetro cod_expulsion
                $cod_expulsion = $_GET['cod_expulsion'];

                // Preparar la consulta para obtener los detalles de la expulsión
                $consultaExpulsion = $db->prepare(
                    "SELECT
        CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesor,
        CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumno,
        e.fecha_Insercion,
        e.fecha_Inicio,
        e.Fecha_Fin
        FROM Expulsiones e
        JOIN alumnos a ON e.matricula_del_Alumno = a.matricula 
        JOIN Usuarios u ON e.cod_usuario = u.cod_usuario
        WHERE cod_expulsion = :cod_expulsion"
                );
                $consultaExpulsion->bindParam(":cod_expulsion", $cod_expulsion, PDO::PARAM_INT);
                $consultaExpulsion->execute();

                // Obtener los detalles de la expulsión
                $expulsion = $consultaExpulsion->fetch(PDO::FETCH_ASSOC);

                // Verificar si se encontró la expulsión
                if ($expulsion) {
                    // Mostrar los detalles de la expulsión en una card de Bootstrap
                    echo "<div class='card card-rounded'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title mb-4 text-decoration-underline'>Detalles de la Expulsión</h5>";
                    echo "<p class='card-text'>Profesor: " . $expulsion['nombreProfesor'] . "</p>";
                    echo "<p class='card-text'>Alumno: " . $expulsion['nombreAlumno'] . "</p>";
                    echo "<p class='card-text'>Fecha de la expulsión: " . $expulsion['fecha_Insercion'] . "</p>";
                    echo "<h5 class='card-title my-3 text-decoration-underline'>Periodo de expulsión</h5>";
                    echo "<p class='card-text'>Desde: " . $expulsion['fecha_Inicio'] . "</p>";
                    echo "<p class='card-text'>Hasta: " . $expulsion['Fecha_Fin'] . "</p>";
                    echo "<button class='btn btn-danger mt-4' onclick='eliminarExpulsion(" . $cod_expulsion . ")'>Eliminar Expulsión</button>";
                    echo "</div>";
                    echo "</div>";


                    // Consulta para obtener las partes asociadas a esta expulsión
                    $consultaPartes = $db->prepare(
                        "SELECT p.cod_parte , i.puntos, i.descripcion
            FROM partes p
            JOIN partesexpulsiones pe ON p.cod_parte = pe.cod_parte
            JOIN Incidencias i ON i.cod_incidencia = p.incidencia
            WHERE pe.cod_expulsion = :cod_expulsion"
                    );
                    $consultaPartes->bindParam(":cod_expulsion", $cod_expulsion, PDO::PARAM_INT);
                    $consultaPartes->execute();

                    echo "<h2 class='text-light rounded bg-dark p-2 px-3 my-4'>Partes Usados</h2>";
                    echo "<div class='row grid column-gap-3'>";


                    // Iterar sobre cada parte y mostrarla en una card individual
                    while ($parte = $consultaPartes->fetch(PDO::FETCH_ASSOC)) {

                        echo "<div class='card card-rounded mt-3 col-11 col-lg-5 col-md-8 m-auto'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title mb-3'>Codigo del Parte: " . $parte['cod_parte'] . "</h5>";
                        echo "<p class='card-text'>Descripción: " . $parte['descripcion'] . "</p>";
                        echo "<p class='card-text'>Puntos: " . $parte['puntos'] . "</p>";
                        echo "<button type='button' class='btn btn-primary' onclick='verParte(" . $parte['cod_parte'] . ")'>Ver Parte</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    // Mostrar un mensaje si la expulsión no fue encontrada
                    echo '<h3 class="text-black rounded bg-light p-2 px-3">No se encontró la expulsión</h3>';
                }
            } else {
                // Mostrar un mensaje si no se proporcionó el parámetro cod_expulsion
                echo "<h2 class='text-dark rounded bg-light p-2 px-3 my-4'>Algo ha salido mal, inténtelo más tarde.</h2>";
            }

            // Cerrar la conexión a la base de datos
            $db = null;
            ?>

        </div>
    </main>
    <footer>
        <?php
        require_once "./archivosComunes/footerPartes.php";
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        function eliminarExpulsion(cod_expulsion) {
            if (confirm("¿Estás seguro de que quieres eliminar esta expulsión?")) {
                window.location.href = "./funcionalidad/eliminarExpulsion.php?cod_expulsion=" + cod_expulsion;
            }
        }

        function verParte(cod_parte) {
            window.location.href = "detalleParte.php?cod_parte=" + cod_parte;
        }
    </script>
</body>

</html>