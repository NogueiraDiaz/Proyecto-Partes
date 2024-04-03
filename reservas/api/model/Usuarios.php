<?php
include_once(__DIR__."/utils/dbc.php");
/** Clase / Modelo principal para la API de Usuarios
 * @author Eloy Rodríguez Martín (ERMtn)
 */
class Usuarios extends Dbc{
    const TABLA = "Usuarios";

// SELECTS

    /** Busca un usuario por su cod_usuario.
     * @param String|int $uid cod_usuario de usuario.
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getById($uid){
        $data = $this->getUserById($uid);
        if($data != null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** Busca un usuario por su email.
     * @param String|int $email Email de usuario.
     * @return JSON Respuesta JSON con los registros obtenidos o error
    */
    public function getByEmail($email){
        $stmt = $this -> connect() -> prepare("SELECT * FROM ".self::TABLA." WHERE email = ?");
        if(!$stmt->execute(array($email))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) == 0){
            echo json_encode(array("isok"=>true,"data"=>null));
        } else{
            echo json_encode(array("isok"=>true,"data"=>$rows[0]));
        }
        $stmt = null;
    }

    /** Obtiene todos los usuarios no activados de la base de datos
     * @return JSON Respuesta JSON con los registros obtenidos o error.
     */
    public function getUnactivated(){
        $data = $this->getUnactivatedUsers();
        if($data != null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

    /** Obtiene todos los usuarios activados de la base de datos
     * @return JSON Respuesta JSON con los registros obtenidos o error.
     */
    public function getAll(){
        $data = $this->getAllUsers();
        if($data != null) echo json_encode(array("isok"=>true,"data"=>$data));
        else echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
    }

// INSERTS
    /** Crea un nuevo usuario con rol PROFESOR y SIN ACTIVAR en la base de datos.
     * @param String $nombre Nombre del usuario
     * @param String $ape Apellidos del usuario
     * @param String $email Email asociado al usuario
     * @param String $clave Contraseña para el usuario.
     * @return JSON Respuesta JSON con el número de registros creados o error.
     */
    public function registerUser($nombre,$ape,$email,$clave){
        $pwdHash = password_hash($clave, PASSWORD_DEFAULT);
        $stmt = $this -> connect() -> prepare("INSERT INTO ".self::TABLA."(nombre,apellidos,email,clave,rol,validar) VALUES(?,?,?,?,'Profesor',0)");
        if(!$stmt->execute(array($nombre,$ape,$email,$pwdHash))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        echo json_encode(array("isok"=>true,"data"=>$stmt->rowCount()));
        $stmt = null;
    }

// UPDATES
    /** Activa un usuario con un cod_usuario concreto.
     * @param String $uid cod_usuario de la reserva a actualizar.
     * @return JSON Respuesta JSON con el número de registros actualizados o error.
     */
    public function activate($uid){
        $stmt = $this -> connect() -> prepare("UPDATE ".self::TABLA." SET validar = 1 WHERE cod_usuario = ?");
        if(!$stmt->execute(array($uid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        $stmt = null;

        $user = $this -> getUserById($uid);
        if($user != null){
            include_once('../mailer.php');
            $mailer = new Mailer($user['email']);
            if($mailer -> userActivated())
                echo json_encode(array("isok"=>true,"data"=>"Usuario activado<br>Notificación por email enviada"));
            else
                echo json_encode(array("isok"=>true,"data"=>"Usuario activado<br><span class='text-warning'>No se ha podido notificar por email</span>"));
        }
    }

    /** Actualiza un usuario con un cod_usuario concreto.
     * @param String $uid cod_usuario de la reserva a actualizar.
     * @param String $pwd Contraseña actual del usuario.
     * @param String $newPwd Nueva contraseña para el usuario.
     * @return JSON Respuesta JSON con el número de registros actualizados o error
     */
    public function updatePassword($uid, $pwd, $newPwd){
        $stmt = $this -> connect() -> prepare('SELECT * FROM usuarios WHERE cod_usuario = ?;');
        if(!$stmt->execute(array($uid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        if($stmt->rowCount() == 0){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Usuario no encontrado"));
            exit();
        }

        $user = $stmt -> fetchAll(PDO::FETCH_ASSOC)[0];
        if(!password_verify($pwd, $user["clave"])){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Error de authentificación"));
            exit();
        }

        $newHash = password_hash($newPwd, PASSWORD_DEFAULT);
        $stmt = $this -> connect() -> prepare("UPDATE usuarios SET clave = ? WHERE cod_usuario = ?;");
        if(!$stmt->execute(array($newHash, $user['cod_usuario']))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Update Consulta fallida"));
            exit();
        }

        echo json_encode(array("isok"=>true, "data"=>$stmt->rowCount()));
        $stmt = null;
    }

    /**
     * Recuperación de contraseña de un usuario, por email.
     * Modifica la contraseña del usuario y se la envía a su email
     * @param String $email Email del usuario a recuperar la contraseña
     * @return JSON Respuesta JSON con el resultado o error
     */
    function recoverUserPassword($email){
        if(!$this -> userExists($email)){
            echo json_encode(array("isok"=>false,"error"=>"No existe usuario con el email introducido"));
            exit();
        }

        $stmt = $this -> connect() -> prepare("SELECT clave FROM ".self::TABLA." WHERE email = ?");
        if(!$stmt->execute(array($email))){
            $stmt = null;
            echo json_encode(array("isok"=>false,"error"=>"Consulta fallida"));
            exit();
        }

        $originalPass = $stmt -> fetchColumn();
        $newPass = substr($originalPass, -10);
        $newHash = password_hash($newPass, PASSWORD_DEFAULT);
        $stmt = null;
        $stmt = $this -> connect() -> prepare("UPDATE usuarios SET clave = ? WHERE email = ?;");
        if(!$stmt->execute(array($newHash, $email))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Update Consulta fallida"));
            exit();
        }

        include_once('../mailer.php');
        $mailer = new Mailer($email);
        if($mailer -> passwdRecovery($newPass)){
            echo json_encode(array("isok"=>true,"data"=>"Nueva contraseña enviada a su correo"));
        } else {
            echo json_encode(array("isok"=>false,"error"=>"No se puedo enviar el correo. Contacte con jefatura."));
        }
    }

    /** Activa un usuario con un cod_usuario concreto.
     * @param String $uid cod_usuario de la reserva a actualizar.
     * @return JSON Respuesta JSON con el número de registros actualizados o error.
     */
    public function modifyRole($uid,$rol){
        $stmt = $this -> connect() -> prepare("UPDATE ".self::TABLA." SET rol = ? WHERE cod_usuario = ?");
        if(!$stmt->execute(array($rol,$uid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        $stmt = null;
        echo json_encode(array("isok"=>true, "data"=>"Usuario actualizado a $rol."));
    }
    
// DELETES
    /** Permite eliminar un usuario con un email concreto
     * @param String $email Email del usuario a eliminar
     * @return JSON Respuesta con el número de registros borrados o error
     */
    public function deleteByEmail($email){
        $stmt = $this -> connect() -> prepare("DELETE FROM ".self::TABLA." WHERE email = ?");
        if(!$stmt->execute(array($email))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        $stmt -> fetchObject();

        echo json_encode(array("isok"=>true, "deleted"=>$stmt->rowCount()));
        $stmt = null;
    }

    /** Permite eliminar un usuario con un cod_usuario concreto
     * @param String|int $uid cod_usuario del usuario a eliminar
     * @return JSON Respuesta con el número de registros borrados o error
     */
    public function deleteById($uid){
        $stmt = $this -> connect() -> prepare("DELETE FROM ".self::TABLA." WHERE cod_usuario = ?");
        if(!$stmt->execute(array($uid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }
        echo json_encode(array("isok"=>true, "data"=>$stmt->rowCount()));
        $stmt = null;
    }

    /** Permite eliminar un usuario no validar con un cod_usuario concreto
     * @param String|int $uid cod_usuario del usuario a eliminar
     * @return JSON Respuesta con el número de registros borrados o error
     */
    public function deleteUnactivated($uid){
        $stmt = $this -> connect() -> prepare("DELETE FROM ".self::TABLA." WHERE cod_usuario = ? AND validar = 0;");
        if(!$stmt->execute(array($uid))){
            $stmt = null;
            echo json_encode(array("isok"=>false, "error"=>"Consulta fallida"));
            exit();
        }

        echo json_encode(array("isok"=>true,"deleted"=>$stmt->rowCount()));
        $stmt = null;
    }

// AUX FUNCTIONS
    /** Comprueba si ya existe un usuario registrado con un email.
     * @param String $email Email a comprobar.
     * @return bool Si existe o no.
     */
    function userExists($email){
        $stmt = $this -> connect() -> prepare("SELECT COUNT(*) FROM ".self::TABLA." WHERE email = ?");
        if(!$stmt->execute(array($email))){
            $stmt = null;
            return false;
        }

        $rows = $stmt -> fetchColumn();
        $stmt = null;
        return $rows > 0;
    }

        /** Comprueba si ya existe un usuario registrado con un email.
     * @param String $uid cod_usuario de usuario
     * @return array|null Usuario obtenido o NULL si error
     */
    function getUserById($uid){
        $stmt = $this -> connect() -> prepare("SELECT * FROM ".self::TABLA." WHERE cod_usuario = ? LIMIT 1");
        if(!$stmt->execute(array($uid))){
            $stmt = null;
            return null;
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows[0];
    }
  

    /** Obtiene todos los usuarios sin activar
     * @return array|null Lista de usuarios sin activar o NULL si error
     */
    function getUnactivatedUsers(){
        $stmt = $this -> connect() -> prepare("SELECT * FROM ".self::TABLA." WHERE validar = ?");
        if(!$stmt->execute(array(0))){
            $stmt = null;
            return null;
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;        
    }

    /** Obtiene TODOS los usuarios activados con cod_usuario > 0
     * @return array|null Lista de usuarios o NULL si error
     */
    function getAllUsers(){
        $stmt = $this -> connect() -> prepare("SELECT cod_usuario,nombre,apellidos FROM ".self::TABLA." WHERE validar = ? AND cod_usuario > ? ORDER BY nombre, apellidos;");
        if(!$stmt->execute(array("si",0))){
            $stmt = null;
            return null;
        }

        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows;        
    }

    /**
     * Comprueba si algún valor del array es un string vacío.
     * @param String[] $arrayParams  Lista de valores string.
     * @return bool
     */
    function checkEmpty($arrayParams){
        foreach ($arrayParams as $param){
            if(empty($param)) return true;
        }
        return false;
    }

    /** Comprueba la validez de nombre y/o apellidos
     * @param String $n Nombre
     * @param String $s Apellidos
     */
    function invalidName($n,$s){
        return !preg_match("/^[\p{L}\s-]+$/u", "$n $s");
    }
    /** Comprueba la validez de un email
     * @param String $e Email
     */
    function invalidEmail($e){
        if(filter_var($e, FILTER_VALIDATE_EMAIL)){
            if(preg_match("/^.+@(yopmail.com|yopmail.fr|yopmail.net|cool.fr.nf|jetable.fr.nf|courriel.fr.nf|moncourrier.fr.nf|monemail.fr.nf|monmail.fr.nf|hide.biz.st|mymail.infos.st)$/", $e)) return true;
            else return false;
        } else return true;
    }

}
