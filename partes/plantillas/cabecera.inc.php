<!DOCTYPE html>
<?php
// para evitar problemas con las cabeceras y las sesiones de php, que dan problemas raros
// con los espacio en blanco antes y despues de la etiquetas de php
// de esta forma se elimina todos automaticamente. Se pone aquí y al final.
ob_start();
?>
<html>
    <head>
        <title>Partes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/png" href="image/birrete.png">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">

    </head>
    <body>
        
    <?php
    // para evitar que salgan las NOTICE (warnings), no aparecen con Windows 7,
    // pero aparecen con Windows 10. Con esto no aparecen en ninguno de los dos
    // Los demás errores si aparecen
    
    
    //error_reporting(E_ALL & ~E_NOTICE) => solo quitaría las NOTICE
    
    //Este quita las NOTICE y los DEPRECATED
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        
    ?>
