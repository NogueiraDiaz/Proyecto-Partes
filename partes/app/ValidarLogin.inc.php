<?php
class ValidarLogin {
    
    private $email;
    private $password;
    //para controlar los errores
    
    private $errorpassword;
    //para mostrar por pantalla los avisos de errores
    private $inicioavisoerror;
    private $finavisoerror;
    
    public function __construct($email, $password) {
        
        $this->email = $email;
        $this->password = $password;
        
        
        $this->erroremail = $this->validarEmail($email);
        $this->errorpassword = $this->validarPassword($password);
        
        $this->inicioavisoerror = " <div class='alert alert-danger text-justify' role='alert'>";
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
    // Validación Email
    // Cambia respecto de las demás validaciones en las que comprobamos si el correo
    // está en uso con el método emailRepetido(), es decir, se utiliza el correo 
    // de otro usuario. NO SE PUEDE, ya que es el campo que utilizamos para 
    // identificar al usuario. 
    //--------------------------------------------------------------------------------------
    private function validarEmail($email) {
        if (!$this->variableIniciada($email)) {
            return "Introduce tu correo.";
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
            // control propio de php para validar un correo, copiar y pegar
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "El formato del correo no es correcto.";
            } else {
                return "";
            }
        }
    }
    
    public function getEmail() {
        if ($this->variableVacia($this->email)) {
            $this->valorValue($this->email . '"');
        }
    }
    
    public function getErrorEmail() {
        if (!$this->variableVacia($this->erroremail)) {
            $this->mostrarValor($this->erroremail);
        }
    }
    
    private function emailUsuario($email) {
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
    
    private function validarPassword($password) {
        if (!$this->variableIniciada($password)) {
            return "Introduce tu contraseña.";
        } else {
            if (strlen($password) < 8) {
                return "Tu contraseña debe tener más de 8 caracteres.";
            } else {
                // expresión regular para controlar la contraseña, mayúculas, minúsculas...
                $patron="/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";
                if (!preg_match($patron, $password)) {
                    return "Tu contraseña debe tener mayúsculas, minúsculas y números.";
                } else {
                    $this->password = $password;
                    return "";
                }
            }
        }
    }
    
    public function getPassword() {
        if ($this->variableVacia($this->password !== "")) {
            $this->valorValue($this->password . '"');
        }
    }
    
    public function getErrorPassword() {
        if (!$this->variableVacia($this->errorpassword)) {
            $this->mostrarValor($this->errorpassword);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Comprobación validación del login
    //--------------------------------------------------------------------------------------
    public function loginCorrecto() {
        
        if ($this->erroremail === "" && $this->errorpassword === "") {
            $profesor = $this->emailUsuario($this->email);
            
            if ($profesor['email'] === $this->email && password_verify($this->password, $profesor['password'])) {
                return $profesor;
            } else {
                $this->errorpassword = "Revisa tus datos no son correctos.";
                return false;
            }
        } else {
            return false;
        }
    }
    
}
