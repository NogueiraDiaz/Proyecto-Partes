<?php

class ValidarRegistroProfesor {
    
    private $dni;
    private $apellidos;
    private $nombre;
    private $email;
    private $password1;
    private $password2;
    private $tutor_grupo;
    //para controlar los errores
    
    private $errorDni;
    private $errornombre;
    private $errorapellidos;
    private $erroremail;
    private $errorpassword1;
    private $errorpassword2;
    //para mostrar por pantalla los avisos de errores
    private $inicioavisoerror;
    private $finavisoerror;
    
    public function __construct($dni, $apellidos, $nombre, $email, $password1, $password2,$tutor_grupo) {
        $this->dni = $dni;
        $this->apellidos = $apellidos;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password1 = $password1;
        $this->tutor_grupo = $tutor_grupo;
        
        $this->errorDni = $this->validarDNI($dni);
        $this->errorapellidos = $this->validarApellidos($apellidos);
        $this->errornombre = $this->validarNombre($nombre);
        $this->erroremail = $this->validarEmail($email);
        $this->errorpassword1 = $this->validarPassword1($password1);
        $this->errorpassword2 = $this->validarPassword2($password1, $password2);
        
        $this->inicioavisoerror = "<div class='alert alert-danger' role='alert'>";
        $this->finavisoerror = "</div>";
    }
    public function variableIniciada($valor) {
        // Para comprobar que un campo haya sido introducido
        return (isset($valor) && !empty($valor)) ? true : false;
    }
    
    public function variableVacia($valor) {
        // Para comprobar que esta vacia
        return $valor === "" ? true : false;
    }
    
    public function valorValue($valor) {
        echo 'value="' . $valor . '"';
    }

    private function mostrarValor($valor) {
        echo $this->inicioavisoerror . $valor . $this->finavisoerror;
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Apellidos, las validaciones son todas iguales tienen tres partes,
    // - validarApellidos => Realiza las comprobaciones básicas longitud, vacia...
    // - getApellidos => Se utiliza para mostrar el contenido cuando nos equivocamos
    // - getErrorApellidos => Para saber si el valido o no el apellido
    // Las demás validaciones son iguales 
    //--------------------------------------------------------------------------------------
    private function validarApellidos($apellidos) {
        if (!$this->variableIniciada($apellidos)) {
            return "Debes introducir tus apellidos para poder registrarte.";
        } else {
            // me quedo con el apellido aqui para poder mostrarlo en caso de error
            // para que el usuario puedar ver lo que ha escrito y corregirlo y
            // de esta forma no tenga que escribir el apellido cada vez que
            // se equivoque
            $this->apellidos = $apellidos;
        }
        if (strlen($apellidos) > 40) {
            return "Tus apellidos no pueden tener más de 40 caracteres.";
        } else {
            return "";
        }
    }
    
    public function getApellidos() {
        if (!$this->variableVacia($this->apellidos)) {
            $this->valorValue($this->apellidos . '"');
        }
    }
    
    public function getErrorApellidos() {
        if (!$this->variableVacia($this->errorapellidos)) {
            $this->mostrarValor($this->errorapellidos);
        }
    }

    //--------------------------------------------------------------------------------------
    // Validacion del DNI
    //--------------------------------------------------------------------------------------
    private function validarDNI($dni){
        if (!$this->variableIniciada($dni)){
            return "Debes introducir tu Dni para poder registrarte.";
        } else {
            $this->dni = $dni;
            return "";
        }
    }

    public function getDNI(){
        if ($this->variableVacia($this->dni)){
            $this->valorValue($this->dni . '"');
        }
    }

    public function getErrorDNI(){
        if (!$this->variableVacia($this->dni)){
            $this->mostrarValor($this->errorDni);
        }
    }
    //--------------------------------------------------------------------------------------
    // Validación Nombre
    //--------------------------------------------------------------------------------------
    private function validarNombre($nombre) {
        if (!$this->variableIniciada($nombre)) {
            return "Debes introducir tu nombre para poder registrarte.";
        } else {
            $this->nombre = $nombre;
        }
        if (strlen($nombre) > 30) {
            return "Tu nombre no puede tener más de 30 caracteres.";
        } else {
            return "";
        }
    }
    
    public function getNombre() {
        if (!$this->variableVacia($this->nombre)) {
            $this->valorValue($this->nombre . '"');
        }
    }
    
    public function getErrorNombre() {
        if (!$this->variableVacia($this->errornombre)) {
            $this->mostrarValor($this->errornombre);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Email
    // Cambia respecto de las demás validaciones en que comprobamos si el correo
    // esté en uso con el método emailRepetido(), es decir, se utiliza el correo 
    // de otro usuario. NO SE PUEDE, ya que es el campo que utilizamos para 
    // identificar al usuario. 
    //--------------------------------------------------------------------------------------
    private function validarEmail($email) {
        if (!$this->variableIniciada($email)) {
            return "Debes introducir tu email para poder registrarte.";
        } else {
            // me quedo con el email aqui para poder mostrarlo en caso de error
            // para que el usuario puedar ver lo que ha escrito y corregirlo y
            // de esta forma no tenga que escribir el correo entero cada vez
            // que se equivoque
            $this->email = $email;
        }
        if (strlen($email) > 40) {
            return "Tu email no puede tener más de 40 caracteres.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "El formato del email no es correcto.";
            } else {
                if (!isset($_SESSION["editado"])) {
                    if ($this->emailRepetido($email)) {
                        return "Este email pertenece a otro profesor";
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            }
        }
    }
    
    public function getEmail() {
        if (!$this->variableVacia($this->email)) {
            $this->valorValue($this->email . '"');
        }
    }
    
    public function getErrorEmail() {
        if (!$this->variableVacia($this->erroremail)) {
            $this->mostrarValor($this->erroremail);
        }
    }
    
    private function emailRepetido($email) {
        include_once "RepositorioProfesor.inc.php";
        include_once "Conexion.inc.php";
        
        //Esta conexión no está cerrada, pero no pasa nada ya que php
        //la cerrará automáticamente cuando cambiemos de página.
        Conexion::abrirConexion();
        $conexion = Conexion::getConexion();
        return RepositorioProfesor::getProfesorEmail($conexion, $email);
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Password
    //--------------------------------------------------------------------------------------
    private function validarPassword1($password1) {
        if ($this->variableVacia($resultadovalidarpassword = $this->validarPassword($password1))) {
            $this->password1 = $password1;
        }
        return $resultadovalidarpassword;
    }
    
    public function getPassword1() {
        if (!$this->variableVacia($this->password1 !== "")) {
            $this->valorValue($this->password1 . '"');
        }
    }
    
    public function getErrorPassword1() {
        if (!$this->variableVacia($this->errorpassword1)) {
            $this->mostrarValor($this->errorpassword1);
        }
    }
    
    private function validarPassword2($password1, $password2) {
        if ($this->variableVacia($resultadovalidarpassword = $this->validarPassword($password2))) {
            if ($password1 !== $password2) {
                $this->password1 = "";
                $resultadovalidarpassword = "Las contraseñas no son iguales.";
            } else {
                $this->password1 = $this->password2 = $password2;
            }
        }
        return $resultadovalidarpassword;
    }
    
    public function getPassword2() {
        if (!$this->variableVacia($this->password2 !== "")) {
            $this->valorValue($this->password2 . '"');
        }
    }
    
    public function getErrorPassword2() {
        if (!$this->variableVacia($this->errorpassword2)) {
            $this->mostrarValor($this->errorpassword2);
        }
    }
    
    // Este método nos sirve para realizar las comprobaciones comunes para las
    // dos contraseñas.
    private function validarPassword($password) {
        if (!$this->variableIniciada($password)) {
            return "Debes introducir una contraseña para poder registrarte";
        } else {
            if (strlen($password) < 8) {
                return "Tu contraseña debe tener más de 8 caracteres.";
            } else {
                // expresión regular para controlar la contraseña, mayúculas, minúsculas...
                $patron = "/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
                if (!preg_match($patron, $password)) {
                    return "Tu contraseña debe terner al menos una mayúsculas, una minúsculas y un números.";
                } else {
                    return "";
                }
            }
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Comprobación validación de todo el registro
    //--------------------------------------------------------------------------------------
    public function registroCorrecto() {
        return ($this->errornombre === "" &&
        $this->errorapellidos === "" &&
        $this->erroremail === "" &&
        $this->errorpassword1 === "" &&
        $this->errorpassword2 === "") ? true : false;
    }
    
}
