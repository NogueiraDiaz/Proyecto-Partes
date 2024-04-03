<?php
    require_once("../archivosComunes/conexion.php");
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    require_once('../archivosComunes/loginRequerido.php');

    $select = "SELECT grupo, aula FROM Cursos";
    $resul = $db->query($select);
    
    // Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
    while ($cursos = $resul->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        // Recorremos las columnas de la fila actual
            echo '<td id="grupoA'.$cursos['grupo'].'" hidden>'.$cursos['grupo'].'</td>';
            echo '<td id="grupo'.$cursos['grupo'].'">'.$cursos['grupo'].'</td>';
            echo '<td id="aula'.$cursos['grupo'].'">'.$cursos['aula'].'</td>';
            echo '<td> <a href="#" onclick="editar(\''.$cursos['grupo'].'\');"><i id="editar'.$cursos['grupo'].'" class="fa-solid fa-pencil"></i></a> </td>';
            echo '<td> <a href="#" onclick="borrar(\''.$cursos['grupo'].'\');"><i class="fa-solid fa-trash"></i></a> </td>';
        echo "</tr>";
    }
?>