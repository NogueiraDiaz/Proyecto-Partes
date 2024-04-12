<?php
// Verificar si se ha recibido el código de la parte a eliminar
if(isset($_GET['cod_parte'])) {
    // Conectar a la base de datos
    require_once "../../archivosComunes/conexion.php";

    try {
        // Obtener el código de la parte a eliminar desde la solicitud GET
        $cod_parte = $_GET['cod_parte'];

        // Preparar la consulta para eliminar la parte
        $consulta = $db->prepare("DELETE FROM partes WHERE cod_parte = :cod_parte");
        $consulta->bindParam(':cod_parte', $cod_parte);
        
        // Ejecutar la consulta
        $consulta->execute();

        // Redireccionar a la página principal de partes después de eliminar
        header("Location: ../verPartes.php?eliminado=1");
        exit();
    } catch (PDOException $e) {
        // Manejar errores si ocurren
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión a la base de datos
    $db = null;
} else {
    // Si no se recibe el código de la parte, redireccionar a alguna página de error o a la página principal
    header("Location: verPartes.php?eliminado=0");
    exit();
}
?>
