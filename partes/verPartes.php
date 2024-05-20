<!doctype html>
<html lang="en">

<head>
    <title>Partes de la Base de Datos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="./js/paginacionFiltroPartes.js"></script>

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
            <?php
            // Verificar si se ha recibido el parámetro 'eliminado' en la URL
            if (isset($_GET['eliminado'])) {
                // Mostrar el mensaje según el valor del parámetro
                if ($_GET['eliminado'] == 1) {
                    echo '<h3 class="text-light rounded bg-success p-2 px-3">Parte eliminado exitosamente</h3>';
                } elseif ($_GET['eliminado'] == 0) {
                    echo '<h3 class="text-light rounded bg-danger p-2 px-3">No se ha podido eliminar el parte. Intentelo más tarde</h3>';
                }
            }
            ?>
            <h2 class="text-light rounded bg-dark p-2 px-3">Tabla de Partes</h2>
            <div class="row my-3">
                <div class="col-lg-3 col-md-6 my-2">
                    <div class="input-group">
                        <span class="input-group-text">Desde</span>
                        <input type="date" id="filtroFechaInicio" class="form-control" placeholder="Fecha de inicio">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 my-2">
                    <div class="input-group">
                        <span class="input-group-text">Hasta</span>
                        <input type="date" id="filtroFechaFin" class="form-control" placeholder="Fecha de fin">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-2">
                    <input type="text" id="filtroNombreProfesor" class="form-control"
                        placeholder="Filtrar por nombre del profesor">
                </div>
                <div class="col-lg-4 col-md-6 my-2">
                    <input type="text" id="filtroNombreAlumno" class="form-control"
                        placeholder="Filtrar por nombre del alumno">
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
                            echo "<option value=".$row['grupo'].">" .$row['grupo']. "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 my-2">
                    <select id="filtroPuntos" class="form-select">
                        <option value="">Filtrar por puntos</option>
                        <option value="3">3 puntos</option>
                        <option value="5">5 puntos</option>
                        <option value="10">10 puntos</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6 my-2">
                    <select id="filtroCaducado" class="form-select">
                        <option value="">Filtrar por estado</option>
                        <option value="Caducado">Caducado</option>
                        <option value="Usado">Usado</option>
                        <option value="Vigente">Vigente</option>
                    </select>
                </div>

            </div>
            <table id="tablaPartes" class="table table-striped table-rounded">
                <thead>
                    <tr>
                        <th style="width: 125px" class="text-center">Fecha</th>
                        <th style="width: 200px">Nombre Profesor</th>
                        <th style="width: 200px">Nombre Alumno</th>
                        <th style="width: 100px" class="text-center">Grupo</th>
                        <th style="width: 100px" class="text-center">Puntos</th>
                        <th style="width: 100px" class="text-center">Estado</th>
                        <th style="width: 100px" class="ps-2"> Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


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

                        $consulta = $db->prepare("SELECT p.cod_parte, CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, i.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto, p.materia, p.descripcion, p.caducado, a.grupo
                        FROM Incidencias i
                        JOIN Partes p ON i.cod_incidencia = p.incidencia
                        JOIN Usuarios u ON p.cod_usuario = u.cod_usuario
                        JOIN alumnos a ON p.matricula_Alumno = a.matricula
                        $query
                        ORDER BY p.fecha DESC
                    ");

                        $consulta->execute();



                        // Iterar sobre los resultados y mostrar cada parte en una fila de la tabla

while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr class='fila-tabla'>";
echo "<td class='text-center'>" . $row['fecha'] . "</td>";
echo "<td>" . $row['nombreProfesorCompleto'] . "</td>";
echo "<td>" . $row['nombreAlumnoCompleto'] . "</td>";
echo "<td class='text-center'>" . $row['grupo'] . "</td>";
echo "<td class='text-center'>" . $row['puntos'] . "</td>";

// Aplicar clases de estilo según el estado
$estado = '';
switch ($row['caducado']) {
    case 0:
        $estado = 'Vigente';
        $color = 'text-success';
        break;
    case 1:
        $estado = 'Caducado';
        $color = 'text-danger'; 
        break;
    case 2:
        $estado = 'Usado';
        $color = 'text-warning'; 
        break;
    default:
        $estado = 'Desconocido';
        $color = '';
        break;
}

echo "<td class='text-center $color'>$estado</td>";

echo "<td><p><a class='text-decoration-none  text-black' href='detalleParte.php?cod_parte=" . $row['cod_parte'] . "'>Ver Parte -></a></p></td>";
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
document.addEventListener("DOMContentLoaded", function () {
    const filtroFechaInicio = document.getElementById("filtroFechaInicio");
    const filtroFechaFin = document.getElementById("filtroFechaFin");
    const filtroNombreProfesor = document.getElementById("filtroNombreProfesor");
    const filtroNombreAlumno = document.getElementById("filtroNombreAlumno");
    const filtroGrupo = document.getElementById("filtroGrupo");
    const filtroPuntos = document.getElementById("filtroPuntos");
    const filtroCaducado = document.getElementById("filtroCaducado");
    const tablaPartes = document.getElementById("tablaPartes").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    // Agregar event listeners para los campos de filtro
    filtroFechaInicio.addEventListener("input", filtrarTabla);
    filtroFechaFin.addEventListener("input", filtrarTabla);
    filtroNombreProfesor.addEventListener("input", filtrarTabla);
    filtroNombreAlumno.addEventListener("input", filtrarTabla);
    filtroGrupo.addEventListener("change", filtrarTabla);
    filtroPuntos.addEventListener("change", filtrarTabla);
    filtroCaducado.addEventListener("change", filtrarTabla);

    function filtrarTabla() {
        const fechaInicio = filtroFechaInicio.valueAsDate;
        const fechaFin = filtroFechaFin.valueAsDate;
        const textoNombreProfesor = filtroNombreProfesor.value.toLowerCase();
        const textoNombreAlumno = filtroNombreAlumno.value.toLowerCase();
        const valorGrupo = filtroGrupo.value;
        const valorPuntos = filtroPuntos.value;
        const valorCaducado = filtroCaducado.value; 

        for (let fila of tablaPartes) {
            const fecha = new Date(fila.cells[0].textContent); // Convertir la fecha de texto a objeto Date

            const cumpleFiltroFechaInicio = !fechaInicio || fecha >= fechaInicio; // Verificar si la fecha está después de la fecha de inicio
            const cumpleFiltroFechaFin = !fechaFin || fecha <= fechaFin; // Verificar si la fecha está antes de la fecha de fin
            const cumpleFiltroNombreProfesor = fila.cells[1].textContent.toLowerCase().includes(textoNombreProfesor) || textoNombreProfesor === "";
            const cumpleFiltroNombreAlumno = fila.cells[2].textContent.toLowerCase().includes(textoNombreAlumno) || textoNombreAlumno === "";
            const cumpleFiltroGrupo = valorGrupo === "" || fila.cells[3].textContent === valorGrupo;
            const cumpleFiltroPuntos = valorPuntos === "" || fila.cells[4].textContent === valorPuntos;
            const cumpleFiltroCaducado = valorCaducado === "" || fila.cells[5].textContent === valorCaducado;

            fila.style.display = cumpleFiltroFechaInicio && cumpleFiltroFechaFin && cumpleFiltroNombreProfesor && cumpleFiltroNombreAlumno && cumpleFiltroGrupo && cumpleFiltroPuntos && cumpleFiltroCaducado ? "" : "none";
        }
    }
});
</script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/bootstrap-icons.min.js"></script>
    <!-- Agregamos la librería de Bootstrap Icons -->
</body>

</html>
