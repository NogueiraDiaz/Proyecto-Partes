<?php
/** Controlador para Login de usuarios
 * @author Eloy Rodríguez Martín (ERMtn)
 * @todo Reimplementar las funciones de esta clase en el modelo API /api/model/Usuarios.php
 */
include_once(__DIR__.'/users.classes.php');
/* Login controller class */
class LoginCtrl extends Users {
    private $email;
    private $pwd;

    public function __construct($email, $pwd){
        $this -> email = $email;
        $this -> pwd = $pwd;
    }

    public function loginUser(){
        if($this -> emptyLoginInput() == true) {
            header("location: ../login.php?error=emptyLoginInput");
            exit();
        } else if($this -> invalidEmail() == true) {
            header("location: ../login.php?error=invalidEmailLogin");
            exit();
        }

        $this -> getUser($this -> email, $this -> pwd);
    }

    public function checkExistingEmail(){
        if(empty($this->email) == true) {
            header("location: ../login.php?error=empty");
            exit();
        } else if($this -> invalidEmail() == true) {
            header("location: ../login.php?error=invalidEmail");
            exit();
        }

        $this->checkEmailExists($this->email);
    }

    // ERROR HANDLERS
    private function emptyLoginInput(){
        return ( empty($this->email) || empty($this->pwd) );
    }

    private function invalidEmail() {
        return ( !filter_var($this->email, FILTER_VALIDATE_EMAIL) );
    } 
}