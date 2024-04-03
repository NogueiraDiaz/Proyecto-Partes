<?php
    // Iniciamos la sesion
    session_start();
    // Recuperamos los datos del usuario logueado de la base de datos
    require_once('conexion.php');
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    require_once('loginRequerido.php');
    //$usuario_id = $_SESSION['usuario_login']['EMAIL'];
    $select = "SELECT * FROM Usuarios WHERE cod_usuario = ".$_GET['idusuario']."";
    $resul = $db->query($select);
    // Guardamos los datos de la consulta anterior en una variable.
    $usuario = $resul->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['actualizar'])) {
        // Recuperar los nuevos valores ingresados en los campos
        $email = $_POST['validacionEmail'];
        $password = $_POST['password'];
        $nombre = $_POST['validacionNombre'];
        $apellidos = $_POST['validacionApellidos'];
        $dni = $_POST['validacionDni'];
        $departamento = $_POST['validacionDepartamento'];
        $tutor = $_POST['validacionTutor'];
        $delphos = $_POST['validacionDelphos'];
        if($delphos==null){
            $delphos=0;
        }
        echo '<script language="javascript">alert('.$departamento.');</script>';

        // Condicional para ver si se pone la opcion por defecto ponerlo a null
        // MARIO: Cuando intentar poner esa opcion salta un error
        if($departamento == '- Seleccione su departamento -'){
            $dpto_actualizado = null;
        } else {
            
            $dpto_actualizado = $departamento;
        }
        
        // Si los campos están vacios, no deja actualizar
        if($email == "" || $password == "" || $nombre == "" || $apellidos == "" || $dni == "" ){
            echo "<script>alert('Rellene los campos para actualizar el perfil')</script>";
            
        } else {
            //Comprobar si se ha cambiado la Contraseña
            $select = "SELECT * FROM Usuarios WHERE cod_usuario = ".$_GET['idusuario']."";
            $resul = $db->query($select);
            // Guardamos los datos de la consulta anterior en una variable.
            $usuario = $resul->fetch(PDO::FETCH_ASSOC);
            if($usuario['clave'] == $password){
            }else{
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
            // Actualizar los datos del usuario en la base de datos
            if($usuario['rol'] == 1 || $usuario['rol'] == 0){
                $update = "UPDATE Usuarios SET dni = '$dni', departamento = $dpto_actualizado, email = '$email', clave = '$password', nombre = '$nombre', apellidos = '$apellidos', cod_delphos = $delphos, tutor_grupo = '$tutor' WHERE cod_usuario = '".$_GET['idusuario']."'";
                echo $update;

                $result = $db->query($update);
                $_SESSION["usu_editar"]["departamento"]=$dpto_actualizado;
                $_SESSION["usu_editar"]["tutor_grupo"]=$tutor;
                $_SESSION["usu_editar"]["cod_delphos"]=$delphos;
                $_SESSION["usuario_login"]["departamento"]=$dpto_actualizado;
                $_SESSION["usuario_login"]["tutor_grupo"]=$tutor;
                $_SESSION["usuario_login"]["cod_delphos"]=$delphos;


            } else {
                $update = "UPDATE Usuarios SET dni = '$dni', email = '$email', clave = '$password', nombre = '$nombre', apellidos = '$apellidos' WHERE cod_usuario = '".$_GET['idusuario']."'";
                $result = $db->query($update);
            }
            

            // Comprobar errores
            if ($result) {
                echo '<script>alert("Perfil Actualizado")</script>';
                // Actualizar los datos existentes del usuario con los nuevos valores ingresados
                $usuario['Email'] = $email;
                $usuario['Clave'] = $password;
                $usuario['Nombre'] = $nombre;
                $usuario['Apellidos'] = $apellidos;
                // Igualamos la sesion iniciada al nuevo email actualizado
                $_SESSION['email'] = $email;

                // Vuelve a editarPerfil.php donde se encuentran los usuarios
                if($_SESSION['usuario_login']['rol'] == 0){
                    header ("Location: editarPerfil.php");
                } else {
                    header ("Location: selector.php");
                }
                
            } else {
                print_r($db->errorinfo());
            }
        }
    }
?>