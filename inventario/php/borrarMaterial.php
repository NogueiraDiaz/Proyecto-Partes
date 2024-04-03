<?php
    // Tenemos que borrar en todas las tablas donde tenga el registro que se desea borrar
    require_once("../../archivosComunes/conexion.php");
    session_start();
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../index.php?redirigido=true");
    };
    
    // Delete sobre la tabla tiene, es decir, la union del departamento y los articulos
    $consulta2 = "DELETE FROM Tiene WHERE cod_articulo = ".$_GET['cod'].";";
    $borrarArticuloTiene = $db->query($consulta2);

    // Delete sobre la tabla fungible, es decir, borrara si se encuentra el articulo si no no realiza nada
    $consulta3 = "DELETE FROM Fungibles WHERE codigo = ".$_GET['cod'].";";
    $borrarArticuloFungible = $db->query($consulta3);

    // Delete sobre la tabla nofungible, es decir, si no borra en la anterior, lo haria en esta tabla
    $consulta3 = "DELETE FROM Nofungibles WHERE codigo = ".$_GET['cod'].";";
    $borrarArticuloNoFungible = $db->query($consulta3);
    
    // Delete sobre la tabla principal de articulos
    // Antes hay que borrar en las otras tablas por la union de las foreign key
    $consulta = "DELETE FROM Articulos WHERE codigo = ".$_GET['cod'].";";
    $borrarArticulo = $db->query($consulta);

    header("Location: lista.php");
?>