<?php

//funcion que borra los datos de las tablas de un alumno
function borrarAlumno($db, $id, $nombre, $retorno){
    try{
        $db->beginTransaction();    

        //comienzo borrando los datos de la base de datos
        $borrador = $db->query("DELETE FROM Anexoiii_pertenece WHERE cod_alumno='$id'");             //borro los datos de la tabla de anexos3
        $borrador = $borrador && $db->query("DELETE FROM Pertenece WHERE cod_alumno = '$id' ");     //luego de la tabla pertenece
        $borrador = $borrador && $db->query("DELETE FROM Alumnos WHERE cod_alumno='$id'");           //y por ultimo en la tabla de alumnos

        if($borrador){
            borrarCarpeta("archivos/alumnos/$nombre");
            $db->commit();
            header("Location: $retorno");
        }
        else{
            $db->rollBack();
            return true;
        }
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return "Error en la base de datos ".$e->getMessage();
    }
}

function borrarEmpresa($db, $id, $nombre, $retorno){
    try{
        $db->beginTransaction();
        //comienzo borrando los datos de la base de datos
        $borrador = $db->query("DELETE FROM Mail_empresas  where cod_empresa = '$id'");
        $borrador = $borrador && $db->query("DELETE FROM Telefono_empresas  where cod_empresa = '$id'");
        $borrador = $borrador && $db->query("DELETE FROM Ciclo_empresas  where cod_empresa = '$id'");
        $borrador = $borrador && $db->query("DELETE FROM Empresas where cod_empresa = '$id'");

        if($borrador){
            borrarCarpeta("archivos/empresas/$nombre");
            $db->commit();
            header("Location: $retorno");
        }
        else{
            $db->rollBack();
            return true;
        }
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return "Error en la base de datos ".$e->getMessage();
    }

}

function borrarAsignado($db, $id, $nombre, $retorno){
    try{
        $db->beginTransaction();
        //comienzo borrando los datos de la base de datos
        $borrador = $db->query("DELETE FROM Anexoiii_pertenece WHERE cod_alumno='$id'");
        $borrador = $borrador && $db->query("DELETE FROM Pertenece WHERE cod_alumno = '". $_GET["cod_alumno"] ."' AND cod_empresa = '". $_GET["cod_empresa"] ."'");

        if($borrador){
            borrarCarpeta("archivos/alumnos/$nombre");
            $db->commit();
            header("Location: $retorno");
        }
        else{
            $db->rollBack();
            return true;
        }
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return "Error en la base de datos ".$e->getMessage();
    }

}

//funcion que borra los archivos y directorios de una carpeta de forma recursiva
function borrarCarpeta($directorio) {
    if (is_dir($directorio)) {
        // Recorre todos los elementos del directorio
        $archivos = array_diff(scandir($directorio), array('.', '..'));
        foreach ($archivos as $archivo) {
            $ruta = $directorio . '/' . $archivo;

            // Verifica si es un archivo y lo elimina
            if (is_file($ruta)) {
                unlink($ruta);
            }

            // Verifica si es un directorio y llama recursivamente a la función para eliminarlo
            elseif (is_dir($ruta)) {
                borrarCarpeta($ruta);
            }
        }

        // Elimina el directorio vacío
        rmdir($directorio);
    }
    return true;
}


/*-------------------------------------------------------CODIGO FUNCIONAL-------------------------------------------------------*/

session_start();
//miro si el usuario está loggeado para redirigirlo en caso contrario
require_once("../Funciones/loginRequerido.php"); 

$tabla;             //dato que guarda la tabla de la BBDD
$campo;             //dato que guarda el campo de la BBDD
$id;                //dato que guarda el ID de la BBDD
$ciclo;             //dato que se usa al borrar carpetas, se recoje mas adelante
$retorno;           //guarda la url de retorno
$_SESSION["error_borrar"] = false;  //si está a true muestra un error en la pantalla



//comienzo asignando los valores de las variables globales que uso para mostrar el nombre del objeto a eliminar

if(isset($_GET["cod_alumno"])){
    //si está borrando una relacion
    if(isset($_GET["cod_empresa"])){
        $tabla = "alumno";
        $campo="cod_alumno";
        $retorno="mostrarAsignados.php";
        $url = "cod_alumno=" . $_GET["cod_alumno"] . "&cod_empresa=" . $_GET["cod_empresa"];
    }
    //si está borrando un alumno
    else{
        $tabla = "Alumnos";
        $campo="cod_alumno";
        $retorno="../../index.php";
        $url = "cod_alumno=" . $_GET["cod_alumno"];
    }
    $id = $_GET[$campo];
}
//si está borrando una empresa
elseif(isset($_GET["cod_empresa"])){
    $tabla = "Empresas";
    $campo="cod_empresa";
    $retorno="mostrarEmpresas.php";
    $url = "cod_empresa=" . $_GET["cod_empresa"];
    $id = $_GET[$campo];
}




//Generación de datos para mostrar por pantalla
try{
    //realizo la conexión a la base de datos
    require "../../../archivosComunes/conexion.php";
    
    $datos = $db->query("SELECT * FROM $tabla WHERE $campo= '$id'");
    //Aqui guardo todos los datos del usuario
    $row = $datos->fetch();


    //Generacion del mensaje de Alerta dependiendo de lo que vayas a borrar
    if($campo == "cod_alumno"){
        if(isset($_GET["cod_empresa"])){
            $mensajeAlerta = '<h1>Estás seguro que quieres quitar de las prácticas al alumno ' . $row["nombre"] . " " . $row["apellidos"] . "</h1>";
        }
        else{
            $mensajeAlerta = '<h1>Estás seguro que quieres borrar al alumno ' . $row["nombre"] . " " . $row["apellidos"];
            $mensajeAlerta .= "<br>con DNI " . $row["dni_alumno"] . "</h1>";
        }
        $ciclo = $row["ciclo"];
    }
    elseif($campo == "cod_empresa"){
        $mensajeAlerta = '<h1>Estás seguro que quieres borrar la empresa ' . $row["nombre_empresa"] . "</h1>";
    }
}
catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
    return "Error en la base de datos ".$e->getMessage();
}

if(isset($row["nombre"])) $nombre = $row["nombre"];
else $nombre = $row["nombre_empresa"];






//Si pulso el boton eliminar borro datos del alumno, de la empresa o la relacion
if(isset($_POST["eliminar"])){
    //si están los dos códigos significa que estámos borrando una relacion
    if(isset($_GET["cod_alumno"]) && isset($_GET["cod_empresa"])){
        $_SESSION["error_borrar"] = borrarAsignado($db, $id, $nombre.$ciclo, $retorno);
    }
    //si solo está el codigo del alumno estoy borrando un alumno
    elseif(isset($_GET["cod_alumno"])){
        $_SESSION["error_borrar"] = borrarAlumno($db, $id, $nombre.$ciclo, $retorno);
    }
    //y la otra opcion es que estoy borrando una empresa
    else{
        $_SESSION["error_borrar"] = borrarEmpresa($db, $id, $nombre, $retorno);
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="stylesheet" href="../../css/eliminar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script type="text/javascript" src="../../js/bootstrap.bundle.min.js" defer></script>
    <script type="text/javascript" src="../../js/patrones.js" defer></script>
    <title>Eliminar Alumno</title>
</head>
<body>
<?php require "../Header-Footer/header.php" ?>

    <section>
        <br><br>
        <h2 class="color"><?php echo $mensajeAlerta ?></h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?$url"; ?>">
            <a href="<?php echo $retorno ?>" class='btn btn-primary'>Cancelar</a>
            <button type='submit' name="eliminar" class='btn btn-danger'>Eliminar</button>
        </form>
        <br><br><br><br><br><br><br><br>
        <?php if($_SESSION["error_borrar"] == true) echo "<h3>Error al borrar los archivos</h3>"?>
    </section>
    
    <?php require "../Header-Footer/footer.php" ?>

</body>
</html>