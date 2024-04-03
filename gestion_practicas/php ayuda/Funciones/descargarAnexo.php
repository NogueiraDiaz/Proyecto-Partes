<?php
//php utilizado para descargar un archivo, en este caso anexos
function descargarArchivo($rutaArchivo) {
    // Verificar si el archivo existe
    if (file_exists($rutaArchivo)) {
        // Configurar las cabeceras para la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($rutaArchivo).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaArchivo));
        readfile($rutaArchivo);
        exit;
    } else {
        echo "El archivo no existe.";
    }
}

descargarArchivo($_GET["rutaAnexo"]);
            


echo '<script>window.close();</script>';
?>