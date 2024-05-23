<!doctype html>
<html lang="en">
<head>
    <title>Detalles de la Parte</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .card-rounded {
            border-radius: 10px;
            overflow: hidden;
        }
        .boton{
            height: 50px;
            align-self: center;
        }
        form {
            align-items: center;
        }
    </style>
</head>
<body>
    <header>
        <?php require_once "./archivosComunes/navPartes.php"; ?>
    </header>
    <main class="p-4 col-11 m-auto">
        <div class="m-2">
            <h2 class="text-light rounded bg-dark p-2 px-3">Seleccione fecha de expulsión y Partes</h2> 
            <div class='card card-rounded'>
                <form id="expulsionForm" class="m-3 d-flex justify-content-center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="m-3">  
                        <label class="me-2">Fecha inicio de expulsión</label>
                        <input type="date" name="fecha_inicio" required>
                    </div>
                    <div class="m-3">
                        <label class="me-2">Fecha final de la expulsión</label>
                        <input type="date" name="fecha_final" required>
                    </div>
                    <?php
                        require_once "../archivosComunes/conexion.php";
                        if ($db) {
                            if (isset($_GET['matricula'])) {
                                $cod_matricula = $_GET['matricula'];
                                $consulta = $db->prepare("SELECT p.cod_parte, CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, i.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto, a.matricula, p.materia, p.fecha_Comunicacion, p.descripcion, p.caducado, a.grupo
                                                          FROM Incidencias i
                                                          JOIN Partes p ON i.cod_incidencia = p.incidencia
                                                          JOIN Usuarios u ON p.cod_usuario = u.cod_usuario
                                                          JOIN alumnos a ON p.matricula_Alumno = a.matricula
                                                          WHERE a.matricula = :cod_matricula and p.caducado = 0
                                                          ORDER BY p.fecha DESC");
                                $consulta->bindParam(":cod_matricula", $cod_matricula);
                                $consulta->execute();
                                $alumno = $consulta->fetch();
                                $partes = $consulta->fetchAll(PDO::FETCH_ASSOC);
                            } else {
                                echo "<p>No se proporcionó el parámetro cod_parte en la URL.</p>";
                            }
                        } else {
                            echo "<p>Error en la conexión a la base de datos.</p>";
                        }
                    ?>
                    <div class="m-3">
                        <label class="ms-3">Seleccione los partes</label>
                        <div class="m-3 border border-dark p-2" style="max-height: 150px; overflow-y: auto;">
                            <?php
                                if (isset($partes)) {
                                    foreach ($partes as $parte) {
                                        echo '<input type="checkbox" name="partes[]" value="' . $parte['cod_parte'] . '">';
                                        echo '<label>' . $parte['nombreProfesorCompleto'] . ' - ' . $parte['fecha_Comunicacion'] . '</label><br>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <input type="hidden" name="matricula" value="<?php echo isset($alumno['matricula']) ? $alumno['matricula'] : ''; ?>">
                    <button type="submit" name="Expulsar" class="btn btn-danger m-1 boton">Expulsar</button>
                </form>  
            </div>
        </div>  
        <h2 class="text-light rounded bg-dark p-2 px-3">Partes del alumno: <?php echo isset($alumno['nombreAlumnoCompleto']) ? $alumno['nombreAlumnoCompleto'] : ''; ?></h2>
        <table id="tablaPartes" class="table table-striped table-rounded">
            <thead>
                <tr>
                    <th style="width: 125px" class="text-center">Fecha</th>
                    <th style="width: 125px" class="text-center">Matricula</th>
                    <th style="width: 200px">Nombre Profesor</th>
                    <th style="width: 200px">Nombre Alumno</th>
                    <th style="width: 100px" class="text-center">Grupo</th>
                    <th style="width: 100px" class="text-center">Puntos</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if (isset($partes)) {
                    foreach ($partes as $row) {
                        echo "<tr class='fila-tabla'>";
                        echo "<td class='text-center'>" . $row['fecha_Comunicacion'] . "</td>";
                        echo "<td class='text-center'>" . $row['matricula'] . "</td>";
                        echo "<td>" . $row['nombreProfesorCompleto'] . "</td>";
                        echo "<td>" . $row['nombreAlumnoCompleto'] . "</td>";
                        echo "<td class='text-center'>" . $row['grupo'] . "</td>";
                        echo "<td class='text-center'>" . $row['puntos'] . "</td>";
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </main>
    <footer>
        <?php require_once "./archivosComunes/footerPartes.php"; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Expulsar"])) {
            require_once "../archivosComunes/conexion.php";
            if ($db) {
                try {
                    $db->beginTransaction();
                    $Añadir_Expulsion = $db->prepare("INSERT INTO expulsiones(cod_usuario, matricula_del_Alumno, fecha_Inicio, Fecha_Fin) VALUES (:cod_usuario, :matricula, :fecha_Inicio, :Fecha_Fin)");
                    $result = $Añadir_Expulsion->execute(array(":cod_usuario" => $_SESSION['usuario_login']['cod_usuario'], ":matricula" => $_POST["matricula"], ":fecha_Inicio" => $_POST["fecha_inicio"], ":Fecha_Fin" => $_POST["fecha_final"]));
                    
                    if(!$result){
                        throw new Exception("Error al insertar la expulsión.");
                    }

                    $cod_expulsion = $db->lastInsertId();
                    $partes = $_POST["partes"];

                    foreach ($partes as $parte) {
                        $Añadir_Parte_Expulsion = $db->prepare("INSERT INTO partesexpulsiones(cod_parte, cod_expulsion) VALUES (:cod_parte, :cod_expulsion)");
                        $result = $Añadir_Parte_Expulsion->execute(array(":cod_parte" => $parte, ":cod_expulsion" => $cod_expulsion));

                        if(!$result){
                            throw new Exception("Error al insertar datos .");
                        } else {
                            $actualizacion = $db->prepare("UPDATE partes SET caducado = 2 WHERE cod_parte = ?");
                            $actualizacion->execute(array($parte));
                        }
                    }

                    $db->commit();
                    print "
                            <script>
                            window.location = 'verExpulsiones.php?insertado=1';
                            </script>";
                    exit();
                } catch (Exception $e) {
                    $db->rollBack();
                    print "
                    <script>
                    window.location = 'verExpulsiones.php?insertado=0';
                    </script>";
                    exit();
                }
            } else {
                echo "<p>Error en la conexión a la base de datos.</p>";
            }
        }
    ?>
    <script>
        function confirmarExpulsion(event) {
            if (!confirm("¿Está seguro de que desea expulsar a este alumno?")) {
                event.preventDefault();
            }
        }     
        document.querySelector("button[name='Expulsar']").addEventListener("click", confirmarExpulsion);
    </script>
</body>
</html>
