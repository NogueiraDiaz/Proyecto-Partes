<?php

class Parte {
    
    private $Dni_Profesor;
    private $Matricula_Alumno;
    private $Incidencia;
    private $Puntos;
    private $Materia;
    private $Fecha;
    private $Hora;
    private $Descripcion; 
    private $Fecha_Comunicacion;	
    private $Via_Comunicacion;
    private $Tipo_Parte;
    private $Caducado;
    
    public function __construct($Dni_Profesor, $Matricula_Alumno, $Incidencia, $Puntos, $Materia,
    $Fecha, $Hora, $Descripcion, $Fecha_Comunicacion, $Via_Comunicacion, $Tipo_Parte, $Caducado) {
        $this->Dni_Profesor = $Dni_Profesor;
        $this->Matricula_Alumno = $Matricula_Alumno;
        $this->Incidencia = $Incidencia;
        $this->Puntos = $Puntos;
        $this->Materia = $Materia;
        $this->Fecha = $Fecha;
        $this->Hora = $Hora;
        $this->Descripcion = $Descripcion;
        $this->Fecha_Comunicacion = $Fecha_Comunicacion;
        $this->Via_Comunicacion = $Via_Comunicacion;
        $this->Tipo_Parte = $Tipo_Parte;
        $this->Caducado = $Caducado;
    }
    
    public function getDni_Profesor(){
        return $this->Dni_Profesor;
    }
    public function getMatricula_Alumno(){
        return $this->Matricula_Alumno;
    }
    public function getIncidencia(){
        return $this->Incidencia;
    }
    public function getPuntos(){
        return $this->Puntos;
    }
    public function getMateria(){
        return $this->Materia;
    }
    public function getFecha(){
        return $this->Fecha;
    }
    public function getHora(){
        return $this->Hora;
    }
    public function getDescripcion(){
        return $this->Descripcion;
    }
    public function getFecha_Comunicacion(){
        return $this->Fecha_Comunicacion;
    }
    public function getVia_Comunicacion(){
        return $this->Via_Comunicacion;
    }
    public function getTipo_Parte(){
        return $this->Tipo_Parte;
    }
    public function getCaducado(){
        return $this->Caducado;
    }
    
    public function setDni_Profesor($Dni_Profesor){
        $this->Dni_Profesor = $Dni_Profesor;
    }
    public function setMatricula_Alumno($Matricula_Alumno){
        $this->Matricula_Alumno = $Matricula_Alumno;
    }
    public function setIncidencia($Incidencia){
        $this->Incidencia = $Incidencia;
    }
    public function setPuntos($Puntos){
        $this->Puntos = $Puntos;
    }
    public function setMateria($Materia){
        $this->Materia = $Materia;
    }
    public function setFecha($Fecha){
        $this->Fecha = $Fecha;
    }
    public function setHora($Hora){
        $this->Hora = $Hora;
    }
    public function setDescripcion($Descripcion){
        $this->Descripcion = $Descripcion;
    }
    public function setFecha_Comunicacion($Fecha_Comunicacion){
        $this->Fecha_Comunicacion = $Fecha_Comunicacion;
    }
    public function setVia_Comunicacion($Via_Comunicacion){
        $this->Via_Comunicacion = $Via_Comunicacion;
    }
    public function setTipo_Parte($Tipo_Parte){
        $this->Tipo_Parte = $Tipo_Parte;
    }
    public function setCaducado($caducado){
        $this->Caducado = $caducado;
    }
    
}
