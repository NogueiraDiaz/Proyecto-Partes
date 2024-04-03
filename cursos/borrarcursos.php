<?php
    // Iniciamos la sesion
    session_start();
    require_once("../archivosComunes/conexion.php");
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    require_once('../archivosComunes/loginRequerido.php');

    // Verificar si se recibió el parámetro "grupo"
    if (isset($_GET['grupo'])) {
        // Obtener el valor del parámetro "grupo"
        $grupo = $_GET['grupo'];
        
        // Construir la consulta para eliminar la clase correspondiente
        $delete = "DELETE FROM Cursos WHERE grupo = :grupo";
        $stmt = $db->prepare($delete);
        $stmt->bindParam(':grupo', $grupo);
        $stmt->execute();

        // Redirigir a la página de clases
        header('Location: cursos.php');
        exit();
    } else {
        // Si no se recibió el parámetro "grupo", mostrar un mensaje de error o redirigir a otra página
        echo "Error: código de grupo no especificado";
    }
?>