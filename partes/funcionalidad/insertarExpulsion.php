<?php
require_once "../../archivosComunes/conexion.php";
session_start();

try {
    // Establecer el modo de error de PDO a excepción
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    print_r($_POST['matriculas_Alumnos']);

    // Obtener los datos del formulario
    $matriculas_Alumnos = $_POST['matriculas_Alumnos'];
    $tiposExpulsion = $_POST['tipo_expulsion'];
    $cod_Usuario = $_SESSION['usuario_login']['cod_usuario'];

    // Iniciar una transacción
    $db->beginTransaction();

    // Preparar la consulta SQL para insertar la expulsión
    $consulta = $db->prepare(
        "INSERT INTO expulsiones (cod_Usuario, matricula_del_Alumno, tipo_expulsion, fecha_Insercion) 
        VALUES (:cod_Usuario, :matricula_Alumno, :tipo_expulsion, :fecha)"
    );

    $fecha = date('Y-m-d'); // Fecha actual


    foreach ($matriculas_Alumnos as $matricula_Alumno) {
        $tipoExpulsion = $tiposExpulsion[$matricula_Alumno];

        $consulta->bindParam(':cod_Usuario', $cod_Usuario);
        $consulta->bindParam(':matricula_Alumno', $matricula_Alumno);
        $consulta->bindParam(':tipo_expulsion', $tipoExpulsion);
        $consulta->bindParam(':fecha', $fecha);

        // Ejecutar la consulta
        $consulta->execute();
    }

    // Confirmar la transacción
    $db->commit();

    // Redirigir al usuario con un mensaje de éxito
    header("Location: ../verPartes.php?insertado=2");
    exit();
} catch (PDOException $e) {
    // En caso de error, deshacer la transacción y redirigir al usuario con un mensaje de error
    $db->rollBack();
    echo "Error: " . $e->getMessage();
    header("Location: ../verPartes.php?insertado=3");
    exit();
}
?>
