<?php
// Incluir el archivo de conexión a la base de datos
require_once "../../archivosComunes/conexion.php";
session_start();

try {
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

    // Preparar la consulta SQL
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

    // Redirigir al usuario con un mensaje de éxito
    header("Location: ../verPartes.php?insertado=1");
    exit();
} catch (PDOException $e) {
    // En caso de error, redirigir al usuario con un mensaje de error
    header("Location: ../verPartes.php?insertado=0");
    exit();
}
?>
