<!doctype html>
<html lang="en">

<head>
    <title>Partes de la Base de Datos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .table-rounded {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <header>
        <?php
        require_once "archivosComunes/navPartes.php";
        ?>
    </header>
    <main class="p-4">
        <div class=" m-2">
            <h2 class="text-light rounded bg-dark p-2 px-3">Partes de la Base de Datos</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 my-2">
                    <input type="text" id="filtroFecha" class="form-control" placeholder="Filtrar por fecha">
                </div>
                <div class="col-lg-3 col-md-6 my-2">
                    <input type="text" id="filtroNombreProfesor" class="form-control" placeholder="Filtrar por nombre del profesor">
                </div>
                <div class="col-lg-3 col-md-6 my-2">
                    <input type="text" id="filtroNombreAlumno" class="form-control" placeholder="Filtrar por nombre del alumno">
                </div>
                <div class="col-lg-3 col-md-6 my-2">
                    <select id="filtroPuntos" class="form-select">
                        <option value="">Filtrar por puntos</option>
                        <option value="3">3 puntos</option>
                        <option value="5">5 puntos</option>
                        <option value="10">10 puntos</option>
                    </select>
                </div>
            </div>
            <table id="tablaPartes" class="table table-striped table-rounded">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre Profesor</th>
                        <th>Nombre Alumno</th>
                        <th>Puntos</th>
                        <!-- Agrega más encabezados según las columnas de tu tabla -->
                    </tr>
                </thead>
                <tbody>
                <?php
// Incluir el archivo de conexión a la base de datos
require_once "../archivosComunes/conexion.php";

try {
    // Obtener el rol del usuario
    $rol_usuario = $_SESSION['usuario_login']['rol']; // Asegúrate de ajustar esto según tu sistema de autenticación

    // Preparar la consulta SQL
    if ($rol_usuario == 0) {
        // Si el rol del usuario es 0, mostrar todas las partes
        $consulta = $db->prepare("SELECT CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, p.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto
                                FROM partes p
                                JOIN usuarios u ON p.cod_usuario = u.cod_usuario
                                JOIN alumnos a ON p.matricula_Alumno = a.matricula
                                ORDER BY p.fecha DESC
                            ");
    } else {
        // Si el rol del usuario es diferente de 0, mostrar solo las partes del propio usuario
        $id_usuario = $_SESSION['usuario_login']['cod_usuario']; // Asegúrate de ajustar esto según tu sistema de autenticación
        $consulta = $db->prepare("SELECT CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, p.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto
                                FROM partes p
                                JOIN usuarios u ON p.cod_usuario = u.cod_usuario
                                JOIN alumnos a ON p.matricula_Alumno = a.matricula
                                WHERE u.cod_usuario = :id_usuario
                                ORDER BY p.fecha DESC
                            ");
        $consulta->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
    }

    $consulta->execute();

    // Iterar sobre los resultados y mostrar cada parte en una fila de la tabla
    while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['fecha'] . "</td>";
        echo "<td>" . $row['nombreProfesorCompleto'] . "</td>";
        echo "<td>" . $row['nombreAlumnoCompleto'] . "</td>";
        echo "<td>" . $row['puntos'] . "</td>";
        // Agrega más columnas según las columnas de tu base de datos
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$db = null;
?>

                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <?php
        require_once "./archivosComunes/footerPartes.php";
        ?>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filtroFecha = document.getElementById("filtroFecha");
            const filtroNombreProfesor = document.getElementById("filtroNombreProfesor");
            const filtroNombreAlumno = document.getElementById("filtroNombreAlumno");
            const filtroPuntos = document.getElementById("filtroPuntos");
            const tablaPartes = document.getElementById("tablaPartes").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            // Agregar event listeners para los campos de filtro
            filtroFecha.addEventListener("input", filtrarTabla);
            filtroNombreProfesor.addEventListener("input", filtrarTabla);
            filtroNombreAlumno.addEventListener("input", filtrarTabla);
            filtroPuntos.addEventListener("change", filtrarTabla);

            function filtrarTabla() {
                const textoFecha = filtroFecha.value.toLowerCase();
                const textoNombreProfesor = filtroNombreProfesor.value.toLowerCase();
                const textoNombreAlumno = filtroNombreAlumno.value.toLowerCase();
                const valorPuntos = filtroPuntos.value;

                // Iterar sobre las filas de la tabla
                for (let fila of tablaPartes) {
                    const fecha = fila.cells[0].textContent.toLowerCase(); // Ajusta el índice según las columnas de tu tabla
                    const nombreProfesor = fila.cells[1].textContent.toLowerCase(); // Ajusta el índice según las columnas de tu tabla
                    const nombreAlumno = fila.cells[2].textContent.toLowerCase(); // Ajusta el índice según las columnas de tu tabla
                    const puntos = fila.cells[3].textContent; // Ajusta el índice según las columnas de tu tabla
                    // Verificar si la fila coincide con los filtros
                    const cumpleFiltroFecha = fecha.includes(textoFecha) || textoFecha === "";
                    const cumpleFiltroNombreProfesor = nombreProfesor.includes(textoNombreProfesor) || textoNombreProfesor === "";
                    const cumpleFiltroNombreAlumno = nombreAlumno.includes(textoNombreAlumno) || textoNombreAlumno === "";
                    const cumpleFiltroPuntos = valorPuntos === "" || puntos === valorPuntos;
                    // Mostrar u ocultar la fila según los filtros
                    fila.style.display = cumpleFiltroFecha && cumpleFiltroNombreProfesor && cumpleFiltroNombreAlumno && cumpleFiltroPuntos ? "" : "none";
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
