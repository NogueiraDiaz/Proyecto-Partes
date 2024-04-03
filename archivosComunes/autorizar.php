<?php
// Iniciamos la sesion
session_start();
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('loginRequerido.php');
?>

<?php
require_once("conexion.php");
// Función para autorizar el acceso a la aplicación
if (isset($_POST['autorizar'])) {
    $Cod_Usuario = $_POST['idUsuario'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];

    $upd = 'UPDATE Usuarios SET validar = "si" WHERE cod_usuario = "'.$Cod_Usuario.'" AND validar = "no"';
    $result = $db->query($upd);

    //comprobar error
    if ($result && $result->rowCount() > 0) {
      echo "<script>alert('Usuario autorizado')</script>";
      $cuerpo =
      "Se ha validado al siguiente usuario:
      <ul>
          <li>Nombre: {$nombre}</li>
          <li>Apellidos: {$apellidos}</li>
          <li>Email: {$email}</li>

      </ul>
     
          ";
      require_once('../correo/correo.php');

      // Enviar correo jefatura@iesbargas.com
      enviarcorreo($email, "Nuevo usuario validado", $cuerpo);
    } else print_r($db->errorinfo());
  }

// Función para denegar el acceso a la aplicación
if (isset($_POST['denegar'])) {
    $Cod_Usuario = $_POST['idUsuario'];
    $upd = 'DELETE FROM Usuarios WHERE cod_usuario = "'.$Cod_Usuario.'"';
    $result = $db->query($upd);

    //comprobar error
    if ($result) {
      echo "<script>alert('Usuario denegado')</script>";
    } else print_r($db->errorinfo());
  }

// Función para Hacer Administrador al Usuario 
  // if (isset($_POST['efectuar'])) {
  //   $Cod_Usuario = $_POST['idUsuario'];
  //   $rol = $_POST['rolUsuario'];
  //   $upd = 'UPDATE USUARIO SET ROL = 0, VALIDAR = "si" WHERE COD_USUARIO = "'.$Cod_Usuario.'" AND ROL = "'.$rol.'" AND VALIDAR = "no"';
  //   $result = $db->query($upd);

  //   //comprobar error
  //   if ($result) {
  //     echo "<script>alert('Administrador Efectuado con éxito')</script>";
  //   } else print_r($db->errorinfo());
  // }

// Función para hacer administrador al usuario validado
  if(isset($_POST['admin'])){
    $Cod_Usuario = $_POST['idUsuario'];
    $rol = $_POST['rolUsuario'];
    $upd = 'UPDATE Usuarios SET rol = 0 WHERE cod_usuario = "'.$Cod_Usuario.'" AND rol = "'.$rol.'" AND validar = "si"';
    $result = $db->query($upd);

    //comprobar error
    if ($result) {
      echo "<script>alert('Administrador Efectuado con éxito')</script>";
    } else print_r($db->errorinfo());
  }

// Función para quitar el rol de administrador al usuario validado
  if(isset($_POST['usuario'])){
    $Cod_Usuario = $_POST['idUsuario'];
    $rol = $_POST['rolUsuario'];
    $upd = 'UPDATE Usuarios SET rol = 1 WHERE cod_usuario = "'.$Cod_Usuario.'" AND rol = "'.$rol.'" AND validar = "si"';
    $result = $db->query($upd);

    //comprobar error
    if ($result) {
      echo "<script>alert('Administrador Efectuado con éxito')</script>";
    } else print_r($db->errorinfo());
  }

  header("Location: gestionUsuariosAdmin.php");
?>