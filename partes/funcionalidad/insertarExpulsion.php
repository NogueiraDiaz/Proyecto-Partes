<?php
// Incluir el archivo de conexión a la base de datos
require_once "../../archivosComunes/conexion.php";
session_start();

try {
    // Obtener los datos del formulario
    $cod_Usuario = $_SESSION['usuario_login']['cod_usuario'];
    $matricula_Alumno = $_POST['matricula_Alumno'];
    $tipo_expulsion = $_POST['tipo_expulsion'];
    $fecha_Insercion = date('Y-m-d'); // Fecha actual

    // Iniciar una transacción
    $db->beginTransaction();

    // Preparar la consulta SQL para insertar la expulsión
    $consulta = $db->prepare(
        "INSERT INTO expulsiones (cod_Usuario, matricula_del_Alumno, tipo_expulsion, fecha_Insercion) 
        VALUES (:cod_Usuario, :matricula_Alumno, :tipo_expulsion, :fecha_Insercion)"
    );
    $consulta->bindParam(':cod_Usuario', $cod_Usuario);
    $consulta->bindParam(':matricula_Alumno', $matricula_Alumno);
    $consulta->bindParam(':tipo_expulsion', $tipo_expulsion);
    $consulta->bindParam(':fecha_Insercion', $fecha_Insercion);



    echo "Valores insertados:<br>";
    echo "cod_Usuario: " . htmlspecialchars($cod_Usuario) . "<br>";
    echo "matricula_Alumno: " . htmlspecialchars($matricula_Alumno) . "<br>";
    echo "tipo_expulsion: " . htmlspecialchars($tipo_expulsion) . "<br>";
    echo "fecha_Insercion: " . htmlspecialchars($fecha_Insercion) . "<br>";

    // Ejecutar la consulta
    $consulta->execute();

    // Confirmar la transacción
    $db->commit();

    // Redirigir al usuario con un mensaje de éxito
    header("Location: ../verPartes.php?insertado=2");
    exit();
} catch (PDOException $e) {
    // En caso de error, deshacer la transacción y redirigir al usuario con un mensaje de error
    $db->rollBack();
    header("Location: ../verPartes.php?insertado=3");
    exit();
}
