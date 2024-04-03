<?php
include(__DIR__.'/../api/model/utils/dbc.php');
/** Modelo para Usuarios, usado solo para Login
 * @author Eloy Rodríguez Martín (ERMtn)
 * @todo Reimplementar las funciones de esta clase en el modelo API /api/model/Usuarios
 */
class Users extends Dbc {

    protected function checkUser($email){
        $stmt = $this -> connect() -> prepare('SELECT email FROM usuarios WHERE email = ?;');
        if(!$stmt -> execute(array($email))){
            // On error, close statement
            $stmt = null;
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return ( count($rows) > 0 );
    }

    protected function checkUnactivated(){
        $stmt = $this -> connect() -> prepare('SELECT * FROM usuarios WHERE validar = 0;');
        if(!$stmt->execute(array())){
            // On error, close statement
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        // Close statement and return
        $stmt = null;
        return $rows;
    }

    protected function setUser($name, $surname, $email, $pwd){
       $stmt = $this -> connect() -> prepare("INSERT INTO usuarios(nombre,apellidos,email,clave,rol,validar) VALUES(?,?,?,?,'Profesor',false);");

       $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

       if(!$stmt -> execute(array($name,$surname,$email,$hashedPwd))){
           // On error, close statement
           $stmt = null;
           header("location: ../signup.php?error=stmtfailed");
           exit();
       }
       // Finally close statement
       $stmt = null;
    }

    protected function getUser($email, $pwd){
        $stmt = $this -> connect() -> prepare('SELECT clave, validar FROM usuarios WHERE email = ?;');

        if(!$stmt -> execute(array($email))){
            // On error, close statement
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        if( count($rows) == 0 ){
            // No results, close statement
            $stmt = null;
            header("location: ../login.php?error=wrongLogin");
            exit();
        }
        $checkPwd = password_verify($pwd, $rows[0]["clave"]);
        if($checkPwd == false){
            // Wrong password, close statement
            $stmt = null;
            header("location: ../login.php?error=wrongLogin");
            exit();
        } else if($checkPwd == true){
            $stmt = $this -> connect() -> prepare("SELECT cod_usuario, nombre, apellidos, rol, email, validar FROM usuarios WHERE email = ? AND clave = ?;");
            if(!$stmt -> execute(array($email,$rows[0]['clave']))){
                // On error, close statement
                $stmt = null;
                header("location: ../login.php?error=stmtFailed");
                exit();
            }

            $user = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            if($user[0]['validar'] == false){
                // Non activated user, close statement
                $stmt = null;
                header("location: ../login.php?error=nonActivatedUser");
                exit();
            }


            session_start();
            $_SESSION['usuario_login'] = $user[0];
         ;
        }

        $stmt = null;

     }

    protected function updateUserPassword($uid, $pwd, $newPwd){
        $stmt = $this -> connect() -> prepare('SELECT * FROM usuarios WHERE cod_usuario = ?;');

        if(!$stmt -> execute(array($uid))){
            // On error, close statement
            $stmt = null;
            header("location: ../newPassword.php?error=stmtFailed");
            exit();
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) == 0){
            // No user with that ID and clave
            $stmt = null;
            header("location: ../newPassword.php?error=notFound");
            exit();
        }

        if(!password_verify($pwd, $rows[0]["clave"])){
            // Wrong password, close statement
            $stmt = null;
            header("location: ../newPassword.php?error=wrongLogin");
            exit();
        }
        $newHashPwd = password_hash($newPwd, PASSWORD_DEFAULT);
        $stmt = $this -> connect() -> prepare("UPDATE usuarios SET clave = ? WHERE cod_usuario = ?;");
        if(!$stmt -> execute(array($newHashPwd, $uid))){
            // On error, close statement
            $stmt = null;
            header("location: ../newPassword.php?error=stmtFailed");
            exit();
        }

        // Close update statement
        $stmt = null;

    }

     // For password recovery
     protected function checkEmailExists($email){
        $stmt = $this -> connect() -> prepare('SELECT validar FROM usuarios WHERE email = ?;');

        if(!$stmt -> execute(array($email))){
            // On error, close statement
            $stmt = null;
            header("location: ../forgotPassword.php?error=stmtFailed");
            exit();
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) == 0){
            // Email does not exist
            $stmt = null;
            header("location: ../forgotPassword.php?error=notFound");
            exit();
        }
        if($rows[0]['validar'] == false){
            // User is not activated
            $stmt = null;
            header("location: ../forgotPassword.php?error=nonActivatedUser");
            exit();
        }

        header("location: ../forgotPassword.php?error=TBD");
        // TODO: SEND RECOVERY MAIL THEN REDIRECT
        //header("location: ../forgotPassword.php?error=none");


        $stmt = null;
     }

     protected function deleteUnactivatedUser($uid){
        $uid = (int) $uid;
        $stmt = $this -> connect() -> prepare('DELETE FROM usuarios WHERE cod_usuario = ? AND validar = 0;');

        if(!$stmt -> execute(array($uid))){
            // On error, close statement
            $stmt = null;
            header("location: ../index.php?error=stmtFailed");
            exit();
        }

        $stmt = null;
        header("location: ../index.php?error=noneRm");
     }

     protected function activateUser($uid){
        $uid = (int) $uid;
        $stmt = $this -> connect() -> prepare('UPDATE usuarios SET validar = 1 WHERE cod_usuario = ?');

        if(!$stmt -> execute(array($uid))){
            // On error, close statement
            $stmt = null;
            header("location: ../index.php?error=stmtFailed");
            exit();
        }

        $stmt = null;
        header("location: ../index.php?error=noneAc");
     }
}