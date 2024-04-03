<?php

class RepositorioIncidencia {

    public static function getIncidenciasPuntos($conexion, $puntos) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM `Incidencias` WHERE puntos = :puntos";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":puntos", $puntos, PDO::PARAM_INT);

                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }$_SESSION["tipo_profesor"];
    }
#TODO: IMPORTANTE ANIADIR FORMA PARA RECOGER EL PARAMETRO PUNTOS
    public static function getCodigoIncidencia($incidencias, $nombre_incidencia, $puntos) {
        foreach ($incidencias as $incidencia) {
            if ($incidencia["Nombre"] === $nombre_incidencia && $incidencia["Puntos"] === $puntos) {
                return  $incidencia["Nombre"].$incidencia["Puntos"];
            }
        }
    }
    public static function getIncidenciaNombre($conexion, $nombre_incidencia) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM Incidencias "
                        . "WHERE nombre = :nombre";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(":nombre", $nombre_incidencia, PDO::PARAM_STR);

                $sentencia->execute();

                return $sentencia->fetch();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getNumeroIncidenciasPuntos123($conexion) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT count(*) "
                        . "FROM `Incidencias` "
                        . "WHERE puntos = 1 "
                        . "OR puntos = 2 "
                        . " OR puntos = 3 "
                        . "GROUP BY puntos ";
                
                $sentencia = $conexion->prepare($sql);
                

                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    
    public static function getNumeroIncidenciasPuntos510($conexion) {
        if (isset($conexion)) {
            try {
                $sql = "SELECT count(*) "
                        . "FROM `Incidencias` "
                        . "WHERE puntos = 5 OR puntos = 10 "
                        . "GROUP BY puntos";
                
                $sentencia = $conexion->prepare($sql);
                

                $sentencia->execute();

                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
    public static function getPuntos($conexion) {
        if (isset($conexion)) {
            try {
                $sql = "select distinct puntos from Incidencias";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                return $sentencia->fetchAll();
            } catch (PDOException $ex) {
                print "ERROR: " . $ex->getMessage();
            }
        }
    }
}
