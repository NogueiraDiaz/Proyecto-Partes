<?php
    // Iniciamos la sesion
    session_start();
    require_once("../archivosComunes/conexion.php");
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    require_once('../archivosComunes/loginRequerido.php');

    // Verificar si se recibió el parámetro "grupo"
if (isset($_GET['grupo']) && $_GET['aula'] && $_GET['grupoA']){
        // Obtener el valor del parámetro "grupo"
        $grupo = $_GET['grupo'];
        $aula = $_GET['aula'];
        $grupoA = $_GET['grupoA'];

        // Construir la consulta para actualizar la clase correspondiente
        $update = "UPDATE Cursos SET aula = :aula, grupo = :grupo WHERE grupo = :grupoA";
        $stmt = $db->prepare($update);
        $stmt->bindParam(':aula', $aula);
        $stmt->bindParam(':grupo', $grupo);
        $stmt->bindParam(':grupoA', $grupoA);
        $stmt->execute();

        // Redirigir a la página de clases
        header('Location: cursos.php');
        exit();
    }else {
        // Si no se recibió el parámetro "cod_clase", mostrar un mensaje de error o redirigir a otra página
        echo "Error: código de clase no especificado";
    }
?>