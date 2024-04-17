<!doctype html>
<html lang="en">

<head>
    <title>Detalles de la Parte</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .card-rounded {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
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

                // Verificar si se proporcionó el parámetro cod_parte en la URL
                if(isset($_GET['cod_parte'])) {
                    // Obtener el valor del parámetro cod_parte
                    $cod_parte = $_GET['cod_parte'];
                    
                    // Preparar la consulta para obtener los detalles de la parte
                    $consulta = $db->prepare("SELECT p.cod_parte, CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, p.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto, p.materia, p.descripcion
                                            FROM partes p
                                            JOIN usuarios u ON p.cod_usuario = u.cod_usuario
                                            JOIN alumnos a ON p.matricula_Alumno = a.matricula
                                            WHERE p.cod_parte = :cod_parte
                    ");
                    $consulta->bindParam(":cod_parte", $cod_parte, PDO::PARAM_INT);
                    $consulta->execute();
                    
                    // Obtener los detalles de la parte
                    $parte = $consulta->fetch(PDO::FETCH_ASSOC);
                    
                    // Verificar si se encontró la parte
                    if($parte) {
                        // Mostrar los detalles de la parte en una card de Bootstrap
                        echo "<div class='card card-rounded'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>Detalles de la Parte</h5>";
                        echo "<p class='card-text'>Fecha: " . $parte['fecha'] . "</p>";
                        echo "<p class='card-text'>Nombre del Profesor: " . $parte['nombreProfesorCompleto'] . "</p>";
                        echo "<p class='card-text'>Nombre del Alumno: " . $parte['nombreAlumnoCompleto'] . "</p>";
                        echo "<p class='card-text'>Puntos: " . $parte['puntos'] . "</p>";
                        echo "<p class='card-text'>Materia: " . $parte['materia'] . "</p>";
                        echo "<p class='card-text'>Detalle: " . $parte['descripcion'] . "</p>";
                        echo "<button class='btn btn-danger' onclick='eliminarParte(" . $parte['cod_parte'] . ")'>Eliminar Parte</button>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        // Mostrar un mensaje si la parte no fue encontrada
                        echo '<h3 class="text-black rounded bg-light p-2 px-3">No se encontro el parte</h3>';

                    }
                } else {
                    // Mostrar un mensaje si no se proporcionó el parámetro cod_parte
                    echo "<p>No se proporcionó el parámetro cod_parte en la URL.</p>";
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script>
        function eliminarParte(cod_parte) {
            if (confirm("¿Estás seguro de que quieres eliminar esta parte?")) {
                // Redirigir a la página de eliminación con el código de la parte
                window.location.href = "./funcionalidad/eliminarParte.php?cod_parte=" + cod_parte;
            }
        }
    </script>
</body>

</html>
