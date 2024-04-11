<?php 

require_once("../archivosComunes/conexion.php");

if (isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'][0])) {
    // Obtener el número de archivos seleccionados
    $numArchivos = count($_FILES['archivo']['name']);
    $eliminar =$db->prepare("DELETE FROM alumnos");
    $eliminar->execute();
    // Recorrer cada archivo
    for ($i = 0; $i < $numArchivos; $i++) {
        $rutaArchivo = $_FILES['archivo']['tmp_name'][$i];
        

        $contenidoarchivo = file_get_contents($rutaArchivo);
        $contenidoarchivo = explode("\n",$contenidoarchivo);
        $contenidoarchivo = array_filter($contenidoarchivo);

        foreach($contenidoarchivo as $file){
            /* if (str_contains($file, ',')){
                $lista[] = explode(",",$file);
            }else{
                $lista[] = explode(";",$file);
            } */


            $lista[] = explode(",",$file);
        }

        foreach ($lista as $datos) {
        
            $matricula = $datos[0];
            $nombre = $datos[1];
            $apellidos = $datos[2];
            $grupo = trim($datos[3]);

            if($matricula != ""){
                
                $conexion =$db->prepare("INSERT INTO alumnos (matricula, nombre, apellidos, grupo)
                VALUES ( :matricula , :nombre, :apellidos, :grupo)");
                $conexion->execute(array(":matricula" => $matricula, ":nombre" => $nombre, ":apellidos" => $apellidos, ":grupo" => $grupo));
                
            }
         }

        

    }
}   


?>