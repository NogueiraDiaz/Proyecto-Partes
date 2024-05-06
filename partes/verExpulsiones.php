<!doctype html>
<html lang="en">

<head>
    <title>Expulsiones Pendientes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="js/paginacionFiltroPartes.js"></script>

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
            <h2 class="text-light rounded bg-dark p-2 px-3">Expulsiones Pendientes</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 my-2">
                    <input type="text" id="filtroNombreAlumno" class="form-control" placeholder="Filtrar por nombre del alumno">
                </div>
                <?php
                // Incluir el archivo de conexión a la base de datos
                require_once "../archivosComunes/conexion.php";
                ?>
                <div class="col-lg-2 col-md-6 my-2">
                    <select id="filtroGrupo" class="form-select">
                        <option value="">Filtrar grupo</option>
                        <?php
                        $consulta = $db->prepare("SELECT * FROM Cursos");
                        $consulta->execute();
                        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $row['grupo'] . ">" . $row['grupo'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <table id="tablaPartes" class="table table-striped table-rounded">
                <thead>
                    <tr>
                        <th>Nombre Alumno</th>
                        <th>Grupo</th>
                        <th>Administrar</th>
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
                        $query = " ";
                        // Preparar la consulta SQL
                        if ($rol_usuario == 1) {
                            // Si el rol del usuario es 1, mostrar todas las partes
                            $id_usuario = $_SESSION['usuario_login']['cod_usuario']; // Asegúrate de ajustar esto según tu sistema de autenticación
                            $query = "WHERE u.cod_usuario = $id_usuario";
                        }

                        $consulta = $db->prepare("SELECT a.matricula, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto, a.grupo, 
                            SUM(i.puntos) AS totalPuntos
                            FROM Incidencias i
                            JOIN Partes p ON i.cod_incidencia = p.incidencia
                            JOIN Alumnos a ON p.matricula_Alumno = a.matricula
                            $query
                            WHERE p.caducado = 0
                            GROUP BY a.matricula
                            HAVING totalPuntos >= 10
                        ");

                        $consulta->execute();

                        // Iterar sobre los resultados y mostrar cada parte en una fila de la tabla
                        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['nombreAlumnoCompleto'] . "</td>";
                            echo "<td>" . $row['grupo'] . "</td>";
                            echo "<td><p><a class='text-decoration-none  text-black' href='Confirmar_Expulsion.php?matricula=" . $row['matricula'] . "'>Confirmar expulsión -></a></p></td>";

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
            <div class="d-flex justify-content-center mt-5" id="tablaPaginacion">

                <nav aria-label="Page navigation example">
                    <ul class="pagination" id="paginacion">

                    </ul>
                </nav>

            </div>

        </div>
    </main>
    <footer>
        <?php
        require_once "./archivosComunes/footerPartes.php";
        ?>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filtroNombreAlumno = document.getElementById("filtroNombreAlumno");
            const filtroGrupo = document.getElementById("filtroGrupo");
            const tablaPartes = document.getElementById("tablaPartes").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            // Agregar event listeners para los campos de filtro
            filtroNombreAlumno.addEventListener("input", filtrarTabla);
            filtroGrupo.addEventListener("change", filtrarTabla);

            function filtrarTabla() {
                const textoNombreAlumno = filtroNombreAlumno.value.toLowerCase();
                const valorGrupo = filtroGrupo.value;
                // Iterar sobre las filas de la tabla
                for (let fila of tablaPartes) {
                    const nombreAlumno = fila.cells[0].textContent.toLowerCase(); // Cambiado a 0, primera celda de la fila
                    const grupo = fila.cells[1].textContent; // Cambiado a 1, segunda celda de la fila
                    // Verificar si la fila coincide con los filtros
                    const cumpleFiltroNombreAlumno = nombreAlumno.includes(textoNombreAlumno) || textoNombreAlumno === "";
                    const cumpleFiltroGrupo = valorGrupo === "" || grupo === valorGrupo;
                    // Mostrar u ocultar la fila según los filtros
                    fila.style.display = cumpleFiltroNombreAlumno && cumpleFiltroGrupo ? "" : "none";
                }
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>