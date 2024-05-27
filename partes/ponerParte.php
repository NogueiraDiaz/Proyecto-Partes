<!doctype html>
<html lang="en">

<head>
    <title>Introducir Parte</title>
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
        require_once "archivosComunes/navPartes.php";
        ?>
    </header>
    <main class="p-4">
        <div class="m-2">
            <h2 class="text-light rounded bg-dark p-2 px-3 mb-5">Introducir Parte</h2>
            <form action="./funcionalidad/insertarParte.php" method="post" class="rounded p-3 bg-light">
                <div class="row mb-3">
                    <div class="col">
                        <label for="grupo" class="form-label">Grupo</label>
                        <select name="grupo" id="grupo" class="form-select" required>
                            <option value="">Seleccione un grupo</option>
                            <?php
                            require_once "../archivosComunes/conexion.php";
                            $consulta = $db->prepare("SELECT grupo FROM Cursos");
                            $consulta->execute();
                            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="matriculaAlumno" class="form-label">Matrícula del Alumno</label>
                        <select name="matricula_Alumno" id="matriculaAlumno" class="form-select" required>
                            <option value="">Seleccione un Alumno</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="incidencia" class="form-label">Incidencia</label>
                    <select name="incidencia" id="incidencia" class="form-select" required>
                        <option value="">Seleccione una incidencia</option>
                        <?php
                        $consulta = $db->prepare("SELECT cod_incidencia, descripcion, puntos FROM Incidencias");
                        $consulta->execute();
                        while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['cod_incidencia'] . "'>" . $row['puntos'] . " - " . $row['descripcion'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="materia" class="form-label">Materia</label>
                    <select name="materia" id="materia" class="form-select" required>
                        <option value="">Seleccione una materia</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="fechaComunicacion" class="form-label">Fecha de Comunicación</label>
                        <input type="date" name="fecha_Comunicacion" id="fechaComunicacion" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="viaComunicacion" class="form-label">Vía de Comunicación</label>
                        <select name="via_Comunicacion" id="viaComunicacion" class="form-select" required>
                            <option value="">Seleccione una vía de comunicación</option>
                            <option value="Mensaje">Mensaje</option>
                            <option value="Notificacion Externa">Notificación Escrita</option>
                            <option value="LLamada Telefónica">Llamada Telefónica</option>
                            <option value="Entrevista con los padres">Entrevista con los padres</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Poner Parte</button>
            </form>
        </div>
    </main>
    <footer>
        <?php
        require_once "./archivosComunes/footerPartes.php";
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const grupoSelect = document.getElementById("grupo");
            const matriculaAlumnoSelect = document.getElementById("matriculaAlumno");
            const materiaSelect = document.getElementById("materia");

            grupoSelect.addEventListener("change", function() {
                const grupo = this.value;

                // Limpiar el select de alumnos
                matriculaAlumnoSelect.innerHTML = '<option value="">Seleccione un Alumno</option>';
                materiaSelect.innerHTML = '<option value="">Seleccione una Materia</option>';

                if (grupo) {
                    fetchAlumnos(grupo);


                    fetchMaterias(grupo);
                }
            });

            function fetchAlumnos(grupo) {
                const alumnos = <?php
                                $consulta = $db->prepare("SELECT matricula, CONCAT(nombre, ' ', apellidos) AS nombreCompleto, grupo FROM Alumnos");
                                $consulta->execute();
                                $alumnos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                echo json_encode($alumnos);
                                ?>;

                const filteredAlumnos = alumnos.filter(alumno => alumno.grupo === grupo);
                filteredAlumnos.forEach(alumno => {
                    const option = document.createElement("option");
                    option.value = alumno.matricula;
                    option.textContent = alumno.nombreCompleto;
                    matriculaAlumnoSelect.appendChild(option);
                });
            }

            function fetchMaterias(grupo) {

                const materias = <?php
                                    $consulta = $db->prepare("SELECT grupo, Cursos.curso, a.cod_asignatura , a.nombre FROM Cursos 
                                    JOIN Asignaturas a ON a.curso = Cursos.curso");
                                    $consulta->execute();
                                    $materias = $consulta->fetchAll(PDO::FETCH_ASSOC);
                                    echo json_encode($materias);
                                    ?>;


                const filteredMaterias = materias.filter(materia => materia.grupo === grupo);
                filteredMaterias.forEach(materia => {
                    const option = document.createElement("option");
                    option.value = materia.cod_asignatura;
                    option.textContent = materia.nombre;
                    materiaSelect.appendChild(option);
                });
            }

        });
    </script>
</body>

</html>