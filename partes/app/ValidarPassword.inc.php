<?php

class ValidarPassword {
    
    private $password1;
    private $password2;
    //para controlar los errores
    
    
    private $errorpassword1;
    private $errorpassword2;
    //para mostrar por pantalla los avisos de errores
    
    private $inicioavisoerror;
    private $finavisoerror;
    
    public function __construct($password1, $password2) {
        $this->password1 = "";
        
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
                $patron="/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
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
        return ($this->errorpassword1 === "" &&
        $this->errorpassword2 === "") ? true : false;
    }
    
}

