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
    <h2 class="text-light rounded bg-dark p-2 px-3">Seleccione fecha de expulsion  y  Pates</h2> 
    <div class='card card-rounded'>
        <form class="m-3 d-flex justify-content-center">
            <div class="m-3">  
            <label class="me-2">Fecha inicio de expulsión</label>
            <input type="date">
            </div>
            <div class="m-3">
            <label class="me-2">Fecha final  de la  expulsión</label>
            <input type="date">
            </div>

        <?php
    // Incluir el archivo de conexión a la base de datos
    require_once "../archivosComunes/conexion.php";

    // Verificar si se proporcionó el parámetro cod_parte en la URL
    if(isset($_GET['matricula'])) {
        // Obtener el valor del parámetro cod_parte
        $cod_matricula = $_GET['matricula'];
        
        // Preparar la consulta para obtener los detalles de la parte
        $consulta = $db->prepare("SELECT p.cod_parte, CONCAT(u.nombre, ' ', u.apellidos) AS nombreProfesorCompleto, p.fecha, i.puntos, CONCAT(a.nombre, ' ', a.apellidos) AS nombreAlumnoCompleto,a.matricula,p.materia, p.descripcion, p.caducado, a.grupo
        FROM Incidencias i
        JOIN Partes p ON i.cod_incidencia = p.incidencia
        JOIN Usuarios u ON p.cod_usuario = u.cod_usuario
        JOIN alumnos a ON p.matricula_Alumno = a.matricula
        WHERE a.matricula = :cod_matricula
        ORDER BY p.fecha DESC");
        $consulta->bindParam(":cod_matricula", $cod_matricula);
        $consulta->execute();
        $nombre = $consulta->fetch();
    } else {
        // Mostrar un mensaje si no se proporcionó el parámetro cod_parte
        echo "<p>No se proporcionó el parámetro cod_parte en la URL.</p>";
    }

    // Cerrar la conexión a la base de datos
    $db = null;
?>


        <input type="submit" value="Expulsar" class="btn btn-danger m-1">
        </form>  
    </div>
    </div>  
<h2 class="text-light rounded bg-dark p-2 px-3">Partes del alumno : <?php echo "$nombre[nombreAlumnoCompleto]" ?></h2>
 <table id="tablaPartes" class="table table-striped table-rounded" >
                
    <thead>
        <tr>
            <th style="width: 125px" class="text-center">Fecha</th>
            <th style="width: 200px">Nombre Profesor</th>
            <th style="width: 200px">Nombre Alumno</th>
            <th style="width: 100px" class="text-center">Grupo</th>
            <th style="width: 100px" class="text-center">Puntos</th>
        </tr>
    </thead>
    <tbody>


<?php 

    // Verificar si se encontró la parte
    while ($row = $consulta->fetch(PDO::FETCH_ASSOC)){
    // Mostrar los detalles de la parte en una card de Bootstrap
        echo "<tr class='fila-tabla'>";
        echo "<td class='text-center'>" . $row['matricula'] . "</td>";
        echo "<td>" . $row['nombreProfesorCompleto'] . "</td>";
        echo "<td>" . $row['nombreAlumnoCompleto'] . "</td>";
        echo "<td class='text-center'>" . $row['grupo'] . "</td>";
        echo "<td class='text-center'>" . $row['puntos'] . "</td>";
        echo "</tr>";
    }

?>
    </tbody>
    </table>
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