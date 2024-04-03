<?php
    // importamos el archivo de conexion a la base de datos
    require_once('../../archivosComunes/conexion.php'); 
    // iniciamos la sesion
    session_start(); 
    // si el usuario no ha iniciado sesion
    if(!isset($_SESSION["usuario_login"])){ 
        // redirigimos al usuario a la pagina de inicio de sesion
        header("Location: ../../index.php?redirigido=true"); 
    };
    // consulta para obtener informacion del articulo fungible
    $consulta = "SELECT * FROM Fungibles WHERE codigo = ?";
    // preparamos la consulta 
    $consulta = $db->prepare($consulta); 
    // ejecutamos la consulta con el codigo del articulo pasado por get
    $consulta->execute(array($_GET['cod'])); 

    foreach ($consulta as $key) {
        // obtenemos el valor de la columna pedir del articulo
        $pedir = $key['pedir']; 
    }
    // si el valor de pedir es no
    if ($pedir == 'no'){ 
        // consulta para actualizar el valor de pedir a si
        $query = "UPDATE Fungibles SET pedir = ? WHERE codigo = ?"; 
        // preparamos la consulta
        $query = $db->prepare($query); 
        // ejecutamos la consulta para actualizar el valor de pedir a si
        $query->execute(array('si', $_GET['cod'])); 
        // si el valor actual de pedir es si
    } else if ($pedir == 'si') { 
        // consulta para actualizar el valor de pedir a no
        $query = "UPDATE Fungibles SET pedir = ? WHERE codigo = ?"; 
        // preparamos la consulta
        $query = $db->prepare($query); 
        // ejecutamos la consulta para actualizar el valor de pedir a no
        $query->execute(array('no', $_GET['cod'])); 
    }
    // redirigimos a la pagina de lista con el valor actualizado de pedir
    header ("Location: lista.php?pedir=".$pedir); 
?>