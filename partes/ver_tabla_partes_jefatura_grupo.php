<?php

include_once "plantillas/cabecera.inc.php";
include_once "app/RepositorioSesion.inc.php";
RepositorioSesion::iniciarSesion();

include_once "app/Conexion.inc.php";

include_once "app/RepositorioAlumno.inc.php";
include_once "app/RepositorioParte.inc.php";
include_once "app/RepositorioParte_Expulsion.inc.php";
include_once "app/RepositorioExpulsion.inc.php";

Conexion::abrirConexion();

$partes_alumnos = RepositorioParte::getPartesGrupo
                (Conexion::getConexion(), $_SESSION["grupo"]);



if (isset($_POST["borrar"])) {
    // borro el parte que se ha seleccionado
    RepositorioParte::borrarParteCodigo
            (Conexion::getConexion(), $_POST["codigo_parte"]);
    header("Location: ver_partes_jefatura_grupo.php");
}

if (isset($_POST['borrar_parte_expulsion'])) {
    // separo la cadena 0->cod_parte_expulsion 1->cod_expulsion
    $datos_borrado = explode("-", $_POST["datos"]);

    // borro el parte que se ha seleccionado
    RepositorioParte_Expulsion::borrarParteCodigo(Conexion::getConexion(), $datos_borrado[0]);

    if ($valor = RepositorioParte_Expulsion::sumarPuntosPartesExpulsion(Conexion::getConexion()
                    , $datos_borrado[1]) < 10) {

        // vuelvo a realizar la consulta para que no me salgan los que he borrado
        $partes_expulsion_borrar = RepositorioParte_Expulsion::getPartesExpulsion
                        (Conexion::getConexion(), $datos_borrado[1]);

        // paso los partes de la tabla expulsiones_parte a la tabla de partes
        // y los borro de la tabla de expulsiones parte
        foreach ($partes_expulsion_borrar as $parte_borrar) {
            // creo un objeto parte
            $parte_aux = new Parte(
                    $parte_borrar["cod_profesor"], $parte_borrar["cod_alumno"]
                    , $parte_borrar["cod_incidencia"], $parte_borrar["materia_parte"]
                    , $parte_borrar["fecha_parte"], $parte_borrar["hora_parte"]
                    , $parte_borrar["puntos_parte"], $parte_borrar["descripcion_profesor"]
                    , $parte_borrar["fecha_comunicacion_familia"]
                    , $parte_borrar["via_comunicacion_familia"]);

            // Añado el nuevo parte a la tabla de partes
            RepositorioParte::nuevoParte(Conexion::getConexion(), $parte_aux);

            //borro el parte de la tabla de expulsiones partes
            RepositorioParte_Expulsion::borrarParteCodigo(Conexion::getConexion()
                    , $parte_borrar["cod_parte_expulsion"]);
        }

        // borro la expulsion
        RepositorioExpulsion::borrarExpulsionCodigo(Conexion::getConexion()
                , $datos_borrado[1]);
    }
   

    // compruebo que los partes retantes sumen 10 puntos, si no suma 10 puntos significa que se quiere
    // quitar la expulsión y los tengo que pasar todos a la tabla de partes

    header("Location: ver_tabla_partes_jefatura_grupo.php");
}

include_once "plantillas/tabla_partes_grupo.inc.php";


if (isset($_POST['ver']) || isset($_POST["ver_parte_expulsion"])) {
    // separo la cadena 0->cod_parte_expulsion 1->cod_expulsion
    $datos_ver = explode("-", $_POST["datos"]);
    
    //cargo los datos del parte que corresponda
    if (isset($_POST['ver'])) {
        $datos_parte = RepositorioParte::getDatosParte
                        (Conexion::getConexion(), $_POST["codigo_parte"]);
    } else {
        $datos_parte = RepositorioParte_Expulsion::getDatosParteExpulsion
                        (Conexion::getConexion(), $datos_ver[0]);
    }
    Conexion::cerrarConexion();

    //muestro la información del parte seleccionado
    include_once("plantillas/datos_parte.inc.php");
}
Conexion::abrirConexion();
include_once("plantillas/pie.inc.php");
?>


