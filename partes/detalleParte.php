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
        $consulta = $db->prepare("SELECT p.cod_parte, CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, i.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto, asi.nombre Materia, p.descripcion, p.caducado
                                FROM Incidencias i
                                JOIN Partes p ON i.cod_incidencia = p.incidencia
                                JOIN Usuarios u ON p.cod_usuario = u.cod_usuario
                                JOIN alumnos a ON p.matricula_Alumno = a.matricula
                                JOIN asignaturas asi ON p.materia = asi.cod_Asignatura
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
            echo "<h5 class='card-title mb-5 text-decoration-underline'>Detalles del Parte</h5>";
            echo "<p class='card-text'>Fecha: " . $parte['fecha'] . "</p>";
            echo "<p class='card-text'>Nombre del Profesor: " . $parte['nombreProfesorCompleto'] . "</p>";
            echo "<p class='card-text'>Nombre del Alumno: " . $parte['nombreAlumnoCompleto'] . "</p>";
            echo "<p class='card-text'>Puntos: " . $parte['puntos'] . "</p>";
            echo "<p class='card-text'>Materia: " . $parte['Materia'] . "</p>";
            echo "<p class='card-text'>Detalle: " . $parte['descripcion'] . "</p>";
            echo "<p class='card-text ".($parte['caducado'] == 1 ? 'text-danger' : '')."'>".($parte['caducado'] == 1 ? 'Caducado' : '')."</p>";
            echo "<button class='btn btn-danger mt-4' onclick='eliminarParte(" . $parte['cod_parte'] . ")' " . ($parte['caducado'] == 2 ? "disabled" : "") . ">Eliminar Parte</button>";
            echo '<button class="btn ' . ($parte['caducado'] == 0 ? 'btn-warning' : 'btn-danger') . ' mt-4 ms-4" onclick="caducarParte(' . $parte['cod_parte'] . ')" ' . ($parte['caducado'] == 0 ? '' : 'disabled') . '>Caducar Parte</button>';
            echo "</div>";
            echo "</div>";
        } else {
            // Mostrar un mensaje si la parte no fue encontrada
            echo '<h3 class="text-black rounded bg-light p-2 px-3">No se encontró el parte</h3>';
        }
    } else {
        // Mostrar un mensaje si no se proporcionó el parámetro cod_parte
        echo "<h2 class='text-dark rounded bg-light p-2 px-3 my-4'>Algo ha salidomal, intentelo mas tarde.</h2>";

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
            if (confirm("¿Estás seguro de que quieres eliminar este parte?")) {
                // Redirigir a la página de eliminación con el código del parte
                window.location.href = "./funcionalidad/eliminarParte.php?cod_parte=" + cod_parte;
            }
        }
        function caducarParte(cod_parte) {
            if (confirm("¿Estás seguro de que quieres caducar este parte?")) {
                // Redirigir a la página de eliminación con el código del parte
                window.location.href = "./funcionalidad/caducarParte.php?cod_parte=" + cod_parte;
            }
        }
    </script>
</body>

</html>
