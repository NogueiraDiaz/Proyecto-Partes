<?php
require_once "../../archivosComunes/conexion.php";
session_start();

try {
    // Establecer el modo de error de PDO a excepción
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos del formulario
    $cod_Usuario = $_SESSION['usuario_login']['cod_usuario'];
    $matricula_Alumno = $_POST['matricula_Alumno'];
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

    // Obtener los valores de puntos para depurar
    $consultaValores = $db->prepare("
        SELECT i.puntos 
        FROM Incidencias i 
        JOIN Partes p ON i.cod_incidencia = p.incidencia 
        WHERE p.matricula_Alumno = :matricula_Alumno
    ");
    $consultaValores->bindParam(':matricula_Alumno', $matricula_Alumno);
    $consultaValores->execute();
    $valores = $consultaValores->fetchAll(PDO::FETCH_ASSOC);

    // Obtener la suma de puntos de todos los partes del alumno
    $consultaPuntos = $db->prepare("
        SELECT SUM(i.puntos) AS total_puntos 
        FROM Incidencias i 
        JOIN Partes p ON i.cod_incidencia = p.incidencia 
        WHERE p.matricula_Alumno = :matricula_Alumno
    ");
    $consultaPuntos->bindParam(':matricula_Alumno', $matricula_Alumno);
    $consultaPuntos->execute();
    $resultadoPuntos = $consultaPuntos->fetch(PDO::FETCH_ASSOC);
    $totalPuntos = $resultadoPuntos['total_puntos'];

    // Verificar si la suma de puntos es mayor a diez
    if ($totalPuntos >= 10) {
        // Confirmar la transacción
        $db->commit();

        // Mostrar un formulario para preguntar si se desea insertar en la tabla expulsiones
        echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Expulsión</title>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
                <style>
                    .centered-box {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        background-color: #343a40;
                        padding: 20px;
                        border-radius: 10px;
                        color: white;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='centered-box'>
                        <form action='insertarExpulsion.php' method='post'>
                            <input type='hidden' name='matricula_Alumno' value='$matricula_Alumno'>
                            <p>Con este último parte el alumno ha acumulado 10 o más puntos, ¿Qué tipo de expulsión desea llevar a cabo?</p>
                            <button type='submit' name='tipo_expulsion' value='Trabajo Social Educativo' class='btn btn-primary'>Trabajos SocioEducativos</button>
                            <button type='submit' name='tipo_expulsion' value='Expulsion a Casa' class='btn btn-primary'>Expulsión a casa</button>
                        </form> 
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
    // Mostrar el error
    echo "Error: " . $e->getMessage();
    exit();
}
?>
