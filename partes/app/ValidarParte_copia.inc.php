<?php

class ValidarParte {
    
    private $fecha_parte;
    private $hora_parte;
    private $materia_parte;
    private $tipo_parte;
    private $descripcion_profesor;
    private $fecha_comunicacion_familia;
    private $via_comunicacion_familia;
    //Errores
    private $error_fecha_parte;
    private $error_hora_parte;
    private $error_materia_parte;
    private $error_tipo_parte;
    private $error_descripcion_profesor;
    private $error_fecha_comunicacion_familia;
    private $error_via_comunicacion_familia;
    
    public function __construct($fecha_parte, $hora_parte, $materia_parte, $tipo_parte, 
    $descripcion_profesor, $fecha_comunicacion_familia, $via_comunicacion_familia) {
        $this->fecha_parte = "";
        $this->hora_parte = "";
        $this->materia_parte = "";
        $this->tipo_parte = "";
        
        $this->descripcion_profesor = "";
        $this->fecha_comunicacion_familia = "";
        $this->via_comunicacion_familia = "";
        
        $this->error_fecha_parte = $this->validarFecha($fecha_parte);
        //$this->error_hora_parte = $this->validarHora($hora_parte);
        //  $this->error_materia_parte = $this->validarMateria($materia_parte);
        //  $this->error_tipo_parte = $this->validarTipo($tipo_parte);
        
        
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
    private function validarFecha($fecha_parte) {
        if (!$this->>variableIniciada($fecha_parte)) {
            return "Debes introducir una fecha del parte.";
        } else {
            // me quedo con el apellido aqui para poder mostrarlo en caso de error
            // para que el usuario puedar ver lo que ha escrito y corregirlo y
            // de esta forma no tenga que escribir el apellido cada vez que
            // se equivoque
            $this->fecha_parte = $fecha_parte;
        }
        if (strlen($fecha_parte) > 12) {
            return "Tus apellidos no pueden tener más de 40 caracteres.";
        } else {
            return "";
        }
    }
    
    public function getFecha() {
        if (!$this->variableVacia($this->fecha_parte)) {
            $this->valorValue($this->fecha_parte . '"');
        }
    }
    
    public function getErrorFecha() {
        if (!$this->variableVacia($this->error_fecha_parte)) {
            return $this->error_fecha_parte;
        }
        else{
            return "";
        }
    }
    
    //--------------------------------------------------------------------------------------
    // Validación Curso, las validaciones son todas iguales tienen tres partes,
    // - validarApellidos => Realiza las comprobaciones básicas longitud, vacia...
    // - getApellidos => Se utiliza para mostrar el contenido cuando nos equivocamos
    // - getErrorApellidos => Para saber si el valido o no el apellido
    // Las demás validaciones son iguales 
    //--------------------------------------------------------------------------------------
    private function validarCurso($fecha_parte) {
        if (!$this->variableIniciada($fecha_parte)) {
            return "Debes introducir una fecha del parte.";
        } else {
            // me quedo con el apellido aqui para poder mostrarlo en caso de error
            // para que el usuario puedar ver lo que ha escrito y corregirlo y
            // de esta forma no tenga que escribir el apellido cada vez que
            // se equivoque
            $this->fecha_parte = $fecha_parte;
        }
        if (strlen($fecha_parte) > 12) {
            return "Tus apellidos no pueden tener más de 40 caracteres.";
        } else {
            return "";
        }
    }
    
    public function getCurso() {
        if (!$this->variableVacia($this->fecha_parte)) {
            $this->valorValue($this->fecha_parte . '"');
        }
    }
    
    public function getErrorCurso() {
        if (!$this->variableVacia($this->error_fecha_parte)) {
            return $this->error_fecha_parte;
        }
        else{
            return "";
        }
    }
    //--------------------------------------------------------------------------------------
    // Comprobación validación partes-fecha
    //--------------------------------------------------------------------------------------
    public function registroCorrectoFecha() {
        return ($this->error_fecha_parte === "") ? true : false; //&&
        // $this->errorapellidos === "" &&
        // $this->erroremail === "" &&
        // $this->errorpassword1 === "" &&
        //$this->errorpassword2 === "") ? true : false;
    }
}

