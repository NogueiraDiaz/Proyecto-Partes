<?php

class ValidarRegistroAlumno {
    
    private $apellidos;
    private $nombre;
    private $dni_nie;
    private $grupo;
    private $direccion;
    private $tutor1;
    private $tutor2;
    private $tel_fijo_alumno;
    private $tel_movil_alumno;
    private $tel_fijo_tutor1;
    private $tel_movil_tutor1;
    private $tel_fijo_tutor2;
    private $tel_movil_tutor2;
    private $email_tutor1;
    private $email_tutor2;
    //para controlar los errores
    
    private $error_nombre;
    private $error_apellidos;
    private $error_dni_nie;
    private $error_grupo;
    private $error_direccion;
    private $error_tutor1;
    private $error_tutor2;
    private $error_tel_fijo_alumno;
    private $error_tel_movil_alumno;
    private $error_tel_fijo_tutor1;
    private $error_tel_movil_tutor1;
    private $error_tel_fijo_tutor2;
    private $error_tel_movil_tutor2;
    private $error_email_tutor1;
    private $error_email_tutor2;
    //para mostrar por pantalla los avisos de errores
    private $inicioavisoerror;
    private $finavisoerror;
    
    public function __construct($apellidos, $nombre, $dni_nie, $grupo
    , $direccion, $tutor1, $tutor2
    , $tel_fijo_alumno, $tel_movil_alumno, $tel_fijo_tutor1, $tel_fijo_tutor2
    , $tel_movil_tutor1, $tel_movil_tutor2, $email_tutor1, $email_tutor2) {
        
        $this->apellidos = $apellidos;
        $this->nombre = $nombre;
        $this->dni_nie = $dni_nie;
        $this->grupo = $grupo;
        $this->direccion = $direccion;
        $this->tutor1 = $tutor1;
        $this->tutor2 = $tutor2;
        $this->tel_fijo_alumno = $tel_fijo_alumno;
        $this->tel_movil_alumno = $tel_movil_alumno;
        $this->tel_fijo_tutor1 = $tel_fijo_tutor1;
        $this->tel_movil_tutor1 = $tel_movil_tutor1;
        $this->tel_fijo_tutor2 = $tel_fijo_tutor2;
        $this->tel_movil_tutor2 = $tel_movil_tutor2;
        $this->email_tutor1 = $email_tutor1;
        $this->email_tutor2 =  $email_tutor2;
        
        
        $this->error_apellidos = $this->validarApellidos($apellidos);
        $this->error_nombre = $this->validarNombre($nombre);
        $this->error_dni_nie = $this->validarDNI_NIE($dni_nie);
        $this->error_grupo = $this->validarGrupo($grupo);
        $this->error_direccion = $this->validarDireccion($direccion);
        $this->error_tutor1 = $this->validarTutor($this->tutor1, $tutor1);
        $this->error_tutor2 = $this->validarTutor($this->tutor2, $tutor2);
        $this->error_tel_fijo_alumno = $this->validarTelefono($this->tel_fijo_alumno, $tel_fijo_alumno);
        $this->error_tel_movil_alumno = $this->validarTelefono($this->tel_movil_alumno, $tel_movil_alumno);
        $this->error_tel_fijo_tutor1 = $this->validarTelefono($this->tel_fijo_tutor1, $tel_fijo_tutor1);
        $this->error_tel_movil_tutor1 = $this->validarTelefono($this->tel_movil_tutor1, $tel_movil_tutor1);
        $this->error_tel_fijo_tutor2 = $this->validarTelefono($this->tel_fijo_tutor2, $tel_fijo_tutor2);
        $this->error_tel_movil_tutor2 = $this->validarTelefono($this->tel_movil_tutor2, $tel_movil_tutor2);
        $this->error_email_tutor1 = $this->validarEmail($this->email_tutor1, $email_tutor1);
        $this->error_email_tutor2 = $this->validarEmail($this->email_tutor2, $email_tutor2);
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
    // Comprobación validación de todo el registro
    //--------------------------------------------------------------------------------------
    public function registroCorrecto() {
        return ($this->error_nombre === "" &&
        $this->error_apellidos === "" &&
        $this->error_dni_nie === "" &&
        //  $this->error_grupo === "" &&
        $this->error_direccion === "" &&
        $this->error_tutor1 === "" &&
        $this->error_tutor2 === "" &&
        $this->error_tel_fijo_alumno === "" &&
        $this->error_tel_movil_alumno === "" &&
        $this->error_tel_fijo_tutor1 === "" &&
        $this->error_tel_movil_tutor1 === "" &&
        $this->error_tel_fijo_tutor2 === "" &&
        $this->error_tel_movil_tutor2 === "" &&
        $this->error_email_tutor1 === "" &&
        $this->error_email_tutor2 === "") ? true : false;
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Teléfonos
    //--------------------------------------------------------------------------------------
    private function validarTelefono(&$telefono_cualquiera, $telefono) {
        if (!$this->variableIniciada($telefono)) {
            return "";
        } else {
            $telefono_cualquiera = $telefono;
        }
        if (strlen($nombre) > 10) {
            return "El campo teléfono no puede tener más de 10 caracteres.";
        } else {
            return "";
        }
    }
    
    public function getTel_fijo_alumno() {
        if (!$this->variableVacia($this->tel_fijo_alumno)) {
            $this->valorValue($this->tel_fijo_alumno . '"');
        }
    }
    
    public function getErrorTel_fijo_alumno() {
        if (!$this->variableVacia($this->error_tel_fijo_alumno)) {
            $this->mostrarValor($this->error_tel_fijo_alumno);
        }
    }
    
    public function getTel_movil_alumno() {
        if (!$this->variableVacia($this->tel_movil_alumno)) {
            $this->valorValue($this->tel_movil_alumno . '"');
        }
    }
    
    public function getErrorTel_movil_alumno() {
        if (!$this->variableVacia($this->error_tel_movil_alumno)) {
            $this->mostrarValor($this->error_tel_movil_alumno);
        }
    }
    
    public function getTel_fijo_tutor1() {
        if (!$this->variableVacia($this->tel_fijo_tutor1)) {
            $this->valorValue($this->tel_fijo_tutor1 . '"');
        }
    }
    
    public function getErrorTel_fijo_tutor1() {
        if (!$this->variableVacia($this->error_tel_fijo_tutor1)) {
            $this->mostrarValor($this->error_tel_fijo_tutor1);
        }
    }
    
    public function getTel_movil_tutor1() {
        if (!$this->variableVacia($this->tel_movil_tutor1)) {
            $this->valorValue($this->tel_movil_tutor1 . '"');
        }
    }
    
    public function getErrorTel_movil_tutor1() {
        if (!$this->variableVacia($this->error_tel_movil_tutor1)) {
            $this->mostrarValor($this->error_tel_movil_tutor1);
        }
    }
    
    public function getTel_fijo_tutor2() {
        if (!$this->variableVacia($this->tel_fijo_tutor2)) {
            $this->valorValue($this->tel_fijo_tutor2 . '"');
        }
    }
    
    public function getErrorTel_fijo_tutor2() {
        if (!$this->variableVacia($this->error_tel_fijo_tutor2)) {
            $this->mostrarValor($this->error_tel_fijo_tutor2);
        }
    }
    
    public function getTel_movil_tutor2() {
        if (!$this->variableVacia($this->tel_movil_tutor2)) {
            $this->valorValue($this->tel_movil_tutor2 . '"');
        }
    }
    
    public function getErrorTel_movil_tutor2() {
        if (!$this->variableVacia($this->error_tel_movil_tutor2)) {
            $this->mostrarValor($this->error_tel_movil_tutor2);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Tutores
    //--------------------------------------------------------------------------------------
    private function validarTutor(&$tutor_cualquiera, $tutor) {
        if (!$this->variableIniciada($tutor)) {
            return "Debes introducir el nombre de los tutores del alumno.";
        } else {
            $tutor_cualquiera = $tutor;
        }
        if (strlen($nombre) > 70) {
            return "El campo tutor no puede tener más de 70 caracteres.";
        } else {
            return "";
        }
    }
    
    public function getTutor1() {
        if (!$this->variableVacia($this->tutor1)) {
            $this->valorValue($this->tutor1 . '"');
        }
    }
    
    public function getErrorTutor1() {
        if (!$this->variableVacia($this->error_tutor1)) {
            $this->mostrarValor($this->error_tutor1);
        }
    }
    
    public function getTutor2() {
        if (!$this->variableVacia($this->tutor2)) {
            $this->valorValue($this->tutor2 . '"');
        }
    }
    
    public function getErrorTutor2() {
        if (!$this->variableVacia($this->error_tutor2)) {
            $this->mostrarValor($this->error_tutor2);
        }
    }
    
    
    //--------------------------------------------------------------------------------------
    // Validación Direccion
    //--------------------------------------------------------------------------------------
    private function validarDireccion($direccion) {
        if (!$this->variableIniciada($direccion)) {
            return "Debes introducir la dirección de la correpondencia del alumno.";
        } else {
            $this->direccion = $direccion;
            return "";
        }
    }
    
    public function getDireccion() {
        if (!$this->variableVacia($this->direccion)) {
            $this->valorValue($this->direccion . '"');
        }
    }
    
    public function getErrorDireccion() {
        if (!$this->variableVacia($this->error_direccion)) {
            $this->mostrarValor($this->error_direccion);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Grupo
    //--------------------------------------------------------------------------------------
    private function validarGrupo($grupo) {
        if (!$this->variableIniciada($grupo)) {
            return "Debes introducir el grupo del alumno.";
        } else {
            $this->grupo = $grupo;
            return "";
        }
    }
    
    public function getGrupo() {
        if (!$this->variableVacia($this->grupo)) {
            $this->valorValue($this->grupo);
        }
    }
    
    public function getErrorGrupo() {
        if (!$this->variableVacia($this->error_grupo)) {
            $this->mostrarValor($this->error_grupo);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación DNI
    //--------------------------------------------------------------------------------------
    private function validarDNI_NIE($dni_nie) {
        
        if (!$this->variableIniciada($dni_nie)) {
            return "Debes introducir el DNI / NIE del alumno.";
        } else {
            $this->dni_nie = $dni_nie;
        }
        
        if (strlen($dni_nie) > 12) {
            return "El campo DNI / NIE no puede tener mas de 12 carateres.";
        } else {
            return "";
        }
    }
    
    public function getDNI_NIE() {
        if (!$this->variableVacia($this->dni_nie)) {
            $this->valorValue($this->dni_nie . '"');
        }
    }
    
    public function getErrorDNI_NIE() {
        if (!$this->variableVacia($this->error_dni_nie)) {
            $this->mostrarValor($this->error_dni_nie);
        }
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
            return "Debes introducir los apellidos del alumno.";
        } else {
            // me quedo con el apellido aqui para poder mostrarlo en caso de error
            // para que el usuario puedar ver lo que ha escrito y corregirlo y
            // de esta forma no tenga que escribir el apellido cada vez que
            // se equivoque
            $this->apellidos = $apellidos;
        }
        if (strlen($apellidos) > 40) {
            return "El campo apellidos apellidos no pueden tener más de 40 caracteres.";
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
        if (!$this->variableVacia($this->error_apellidos)) {
            $this->mostrarValor($this->error_apellidos);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Nombre
    //--------------------------------------------------------------------------------------
    private function validarNombre($nombre) {
        if (!$this->variableIniciada($nombre)) {
            return "Debes introducir el nombre del alumno.";
        } else {
            $this->nombre = $nombre;
        }
        if (strlen($nombre) > 30) {
            return "El campo nombre no puede tener más de 30 caracteres.";
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
        if (!$this->variableVacia($this->error_nombre)) {
            $this->mostrarValor($this->error_nombre);
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Email
    //--------------------------------------------------------------------------------------
    // le paso por referencia el valor del correo del tutor uno o el tutor2
    private function validarEmail(&$email_cualquiera, $email_tutor1) {
        if (!$this->variableIniciada($email_tutor1)) {
            return "";
        } else {
            // me quedo con el email aqui para poder mostrarlo en caso de error
            // para que el usuario puedar ver lo que ha escrito y corregirlo y
            // de esta forma no tenga que escribir el correo entero cada vez
            // que se equivoque
            $email_cualquiera = $email_tutor1;
        }
        if (strlen($email_tutor1) > 40) {
            return "El email no puede tener más de 40 caracteres.";
        } else {
            if (!filter_var($email_tutor1, FILTER_VALIDATE_EMAIL)) {
                return "El formato del email no es correcto.";
            } else {
                return "";
            }
        }
    }
    
    public function getEmail1() {
        if (!$this->variableVacia($this->email_tutor1)) {
            $this->valorValue($this->email_tutor1 . '"');
        }
    }
    
    public function getErrorEmail1() {
        if (!$this->variableVacia($this->error_email_tutor1)) {
            $this->mostrarValor($this->error_email_tutor1);
        }
    }
    
    public function getEmail2() {
        if (!$this->variableVacia($this->email_tutor2)) {
            $this->valorValue($this->email_tutor2 . '"');
        }
    }
    
    public function getErrorEmail2() {
        if (!$this->variableVacia($this->error_email_tutor2)) {
            $this->mostrarValor($this->error_email_tutor2);
        }
    }
    
}
