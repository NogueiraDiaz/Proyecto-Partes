<?php
    require_once("conexion.php");

    $consulta = 'SELECT * FROM Usuarios WHERE cod_usuario = '.$_GET["cod"].';';
    $usuario = $db->query($consulta);
    $usuario = $usuario->fetch();

    if($usuario['email'] == 'incidenciasiesbargas@gmail.com') {
        // error para desde el ficheor editarPerfil.php salte un alerta de que no se puede borrar el usuario
        header("Location: editarPerfil.php?admin=true");
    } else {
        // MARIO: aqui cuando no has hecho nada ni con mantenimiento ni con empresas lo borra pero cuando haces tareas por ejemplo
        // da un error porque lo tienen como foreign al igual que pasa con el de empresas, el de mantenimiento yo en su dia lo hable con 
        // Borja y dijo que dejandolo a null pues no pasaba nada lo que hacia es que si tenia alguna tarea asignada se quedaba en blanco o algo asi
        $consulta_mant1 = "UPDATE Tareas SET cod_usuario_gestion = NULL WHERE cod_usuario_gestion = ".$_GET['cod'].";";
        $consulta_mant1_1 = $db->query($consulta_mant1);

        $consulta_mant2 = "UPDATE Tareas SET cod_usuario_crea = NULL WHERE cod_usuario_crea = ".$_GET['cod'].";";
        $consulta_mant2_1 = $db->query($consulta_mant2);

        $consulta2 = 'DELETE FROM Usuarios WHERE cod_usuario = '.$_GET["cod"].';';
        $borrar = $db->query($consulta2);
        header("Location: editarPerfil.php");
    }

    

?>