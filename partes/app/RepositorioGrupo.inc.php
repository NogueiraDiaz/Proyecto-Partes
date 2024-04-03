<?php
class RepositorioGrupo{
  public static function getGrupos($conexion){
    try {
      $sql = "select * from Cursos";
      $sentencia = $conexion->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll();
    } catch (PDOException $ex) {
      print "ERROR: " . $ex->getMessage();
    }
  }
  public static function deleteGrupoByName($conexion, $nombre){
    try {
      $sql = "delete from Cursos where nombre = :nombre";
      $sentencia = $conexion->prepare($sql);
      $sentencia->bindParam(":nombre", $nombre, PDO::PARAM_STR);
      $sentencia->execute();
      return $sentencia->fetchAll();
    } catch (PDOException $ex) {
      print "ERROR: " . $ex->getMessage();
    }
  }
  public static function addGrupo($conexion, $grupo){
    try {
      $sql = "insert into Cursos values(:nombre)";
      $sentencia = $conexion->prepare($sql);
      $sentencia->bindParam(":nombre", $grupo, PDO::PARAM_STR);
      $sentencia->execute($sql);
      return $sentencia->fetchAll();
    } catch (PDOException $ex) {
      print "ERROR: ".$ex->getMessage();
    }
  }
}