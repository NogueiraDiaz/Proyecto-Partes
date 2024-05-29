<?php
require_once "../../archivosComunes/conexion.php";
session_start();

try {
    // Establecer el modo de error de PDO a excepción
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $cod_Usuario = $_SESSION['usuario_login']['cod_usuario'];
    $matriculas_Alumnos = $_POST['matricula_Alumno']; // Esto es ahora un array
    $incidencia = $_POST['incidencia'];
    $materia = $_POST['materia'];
    $descripcion = $_POST['descripcion'];
    $fecha_Comunicacion = $_POST['fecha_Comunicacion'];
    $via_Comunicacion = $_POST['via_Comunicacion'];
    $fecha = date('Y-m-d'); // Fecha actual
    $hora = date('H:i:s'); // Hora actual
    $caducado = 0;

    // Iniciar una transacción
    $db->beginTransaction();

    // Preparar la consulta SQL para insertar el parte
    $consulta = $db->prepare(
        "INSERT INTO partes (cod_Usuario, matricula_Alumno, incidencia, materia, fecha, hora, descripcion, fecha_Comunicacion, via_Comunicacion, caducado) 
        VALUES (:cod_Usuario, :matricula_Alumno, :incidencia, :materia, :fecha, :hora, :descripcion, :fecha_Comunicacion, :via_Comunicacion, :caducado)"
    );

    foreach ($matriculas_Alumnos as $matricula_Alumno) {
        $consulta->bindParam(':cod_Usuario', $cod_Usuario);
        $consulta->bindParam(':matricula_Alumno', $matricula_Alumno);
        $consulta->bindParam(':incidencia', $incidencia);
        $consulta->bindParam(':materia', $materia);
        $consulta->bindParam(':fecha', $fecha);
        $consulta->bindParam(':hora', $hora);
        $consulta->bindParam(':descripcion', $descripcion);
        $consulta->bindParam(':fecha_Comunicacion', $fecha_Comunicacion);
        $consulta->bindParam(':via_Comunicacion', $via_Comunicacion);
        $consulta->bindParam(':caducado', $caducado);

        // Ejecutar la consulta
        $consulta->execute();
    }

    // Obtener la suma de puntos de todos los partes del alumno
    $consultaPuntos = $db->prepare("
        SELECT matricula_Alumno, SUM(i.puntos) AS total_puntos 
        FROM Incidencias i 
        JOIN Partes p ON i.cod_incidencia = p.incidencia 
        WHERE p.matricula_Alumno IN (" . implode(',', array_fill(0, count($matriculas_Alumnos), '?')) . ")
        GROUP BY matricula_Alumno
    ");
    $consultaPuntos->execute($matriculas_Alumnos);
    $resultadoPuntos = $consultaPuntos->fetchAll(PDO::FETCH_ASSOC);

    // Array para guardar los alumnos que superan los 10 puntos
    $alumnosExpulsion = [];

    foreach ($resultadoPuntos as $puntosAlumno) {
        if ($puntosAlumno['total_puntos'] >= 10) {
            $alumnosExpulsion[] = $puntosAlumno['matricula_Alumno'];
        }
    }

    if (!empty($alumnosExpulsion)) {
        // Confirmar la transacción
        $db->commit();

        // Mostrar un formulario para preguntar si se desea insertar en la tabla expulsiones para cada alumno
        echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Expulsión</title>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
            </head>
            <style>
            body {
                color: white;
                background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            }
            </style>
            <body>
                <div class='container mt-5'>
                    <div class='row justify-content-center'>
                        <div class='col-md-6'>
                            <div class='card'>
                                <div class='card-body bg-dark rounded-lg'>
                                    <form action='insertarExpulsion.php' method='post'>
        ";
        
        foreach ($alumnosExpulsion as $matricula_Alumno) {
            echo "
                <input type='hidden' name='matriculas_Alumnos[]' value='" . $matricula_Alumno . "'>
                <p class='mb-4'>El alumno con matrícula " . $matricula_Alumno . " ha acumulado 10 o más puntos. ¿Qué tipo de expulsión desea llevar a cabo?</p>
                <div class='form-group'>
                    <label for='tipo_expulsion_" . $matricula_Alumno . "'>Tipo de expulsión</label>
                    <select class='form-control' id='tipo_expulsion_" . $matricula_Alumno . "' name='tipo_expulsion[" . $matricula_Alumno . "]'>
                        <option value='Trabajo Social Educativo'>Trabajo Social Educativo</option>
                        <option value='Expulsion a Casa'>Expulsión a casa</option>
                    </select>
                </div>
            ";
        }
        
        echo "
                                        <button type='submit' class='btn btn-primary btn-block'>Confirmar expulsión</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
                <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js'></script>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
            </body>
            </html>
        ";
    } else {
        // Confirmar la transacción
        $db->commit();

        // Redirigir al usuario con un mensaje de éxito
        header("Location: ../verPartes.php?insertado=1");
        exit();
    }
} catch (PDOException $e) {
    // En caso de error, deshacer la transacción y redirigir al usuario con un mensaje de error
    $db->rollBack();
    header("Location: ../verPartes.php?insertado=0");
    exit();
}
?>
