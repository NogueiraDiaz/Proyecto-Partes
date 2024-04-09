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
            <h2 class="text-light rounded bg-dark p-2">Partes de la Base de Datos</h2>
            <div class="row">
                <div class="col-lg-4 col-md-12 my-2">
                    <input type="text" id="filtroFecha" class="form-control" placeholder="Filtrar por fecha">
                </div>
                <div class="col-lg-4 col-md-12 my-2">
                    <input type="text" id="filtroNombre" class="form-control" placeholder="Filtrar por nombre">
                </div>
                <div class="col-lg-4 col-md-12 my-2">
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
                        <th>Nombre</th>
                        <th>Puntos</th>
                        <!-- Agrega más encabezados según las columnas de tu tabla -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Incluir el archivo de conexión a la base de datos
                        require_once "../archivosComunes/conexion.php";

                        try {
                            
                            // Preparar la consulta SQL
                            $consulta = $db->prepare("SELECT u.nombre, p.fecha, p.puntos 
                                                      FROM partes p
                                                      JOIN usuarios u ON p.cod_usuario = u.dni
                                                      ORDER BY p.fecha DESC
                                                    ");
                            
                            $consulta->execute();
                            
                            // Iterar sobre los resultados y mostrar cada parte en una fila de la tabla
                            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row['fecha'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
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
        require_once "../archivosComunes/footer.php";
        ?>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filtroFecha = document.getElementById("filtroFecha");
            const filtroNombre = document.getElementById("filtroNombre");
            const filtroPuntos = document.getElementById("filtroPuntos");
            const tablaPartes = document.getElementById("tablaPartes").getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            // Agregar event listeners para los campos de filtro
            filtroFecha.addEventListener("input", filtrarTabla);
            filtroNombre.addEventListener("input", filtrarTabla);
            filtroPuntos.addEventListener("change", filtrarTabla);

            function filtrarTabla() {
                const textoFecha = filtroFecha.value.toLowerCase();
                const textoNombre = filtroNombre.value.toLowerCase();
                const valorPuntos = filtroPuntos.value;

                // Iterar sobre las filas de la tabla
                for (let fila of tablaPartes) {
                    const fecha = fila.cells[0].textContent.toLowerCase(); // Ajusta el índice según las columnas de tu tabla
                    const nombre = fila.cells[1].textContent.toLowerCase(); // Ajusta el índice según las columnas de tu tabla
                    const puntos = fila.cells[2].textContent; // Ajusta el índice según las columnas de tu tabla
                    // Verificar si la fila coincide con los filtros
                    const cumpleFiltroFecha = fecha.includes(textoFecha) || textoFecha === "";
                    const cumpleFiltroNombre = nombre.includes(textoNombre) || textoNombre === "";
                    const cumpleFiltroPuntos = valorPuntos === "" || puntos === valorPuntos;
                    // Mostrar u ocultar la fila según los filtros
                    fila.style.display = cumpleFiltroFecha && cumpleFiltroNombre && cumpleFiltroPuntos ? "" : "none";
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
