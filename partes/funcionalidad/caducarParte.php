<?php
// Incluir el archivo de conexión a la base de datos
require_once "../../archivosComunes/conexion.php";

// Verificar si se proporcionó el parámetro cod_parte en la URL
if(isset($_GET['cod_parte'])) {
    // Obtener el valor del parámetro cod_parte
    $cod_parte = $_GET['cod_parte'];
    
    // Preparar y ejecutar la consulta para actualizar el campo caducado
    $consulta = $db->prepare("UPDATE Partes SET caducado = '1' WHERE cod_parte = :cod_parte");
    $consulta->bindParam(":cod_parte", $cod_parte, PDO::PARAM_INT);
    $consulta->execute();

    // Redirigir de vuelta a la página de detalles de la parte
    header("Location: ../detalleParte.php?cod_parte=" . $cod_parte);
    exit();
} else {
    // Mostrar un mensaje si no se proporcionó el parámetro cod_parte
    echo "<p>No se proporcionó el parámetro cod_parte en la URL.</p>";
}

// Cerrar la conexión a la base de datos
$db = null;
?>
