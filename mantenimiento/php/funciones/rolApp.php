<?php
  session_start();

  require_once('loginRequerido.php');
  require_once('../../../archivosComunes/conexion.php');
  // Dependiendo quien haya iniciado sesión, este switch seleccionara el rol y te enviará a la pagina que corresponda
  switch ($_SESSION['usuario_login']['rol']) {
    case 0:
      header("Location: ../admin.php");
      break;
    case 1:
      // Sacamos el nombre y el codigo de todos los profesores que sean de informatica y los añadimos al select
      $referencia = "SELECT referencia FROM Departamentos WHERE codigo = ".$_SESSION['usuario_login']['departamento'];
      $referencia = $db->query($referencia);
      $columna = "";
      // Mostramos los resultados de la consulta en un select
      foreach ($referencia as $row) {
        $columna = $row["referencia"];
      }
      if( $columna=="inf"){
        header("Location: ../profesor.php");
      }else{
        header("Location: ../profesorCreadas.php");
      }
      break;
    case 2:
      header("Location: ../operario.php");
      break;
      case 3:
        header("Location: ../profesorCreadas.php");
      
      break;
}
