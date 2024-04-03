<?php

class Profesor {
    
    private $DNI;
    private $Nombre;
    private $Apellidos;
    private $Email;
    private $Contrasenia;
    private $Tutor_grupo;
    private $Nivel_acceso;
    
    public function __construct($DNI,$Nombre,$Apellidos,$Email,$Contrasenia,$Nivel_acceso,$Tutor_grupo) {
        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
        $this->Apellidos = $Apellidos;
        $this->Email = $Email;
        $this->Contrasenia = $Contrasenia;
        $this->Tutor_grupo = $Tutor_grupo;
        $this->Nivel_acceso = $Nivel_acceso;
    }
    
public function getDNI(){
    return $this->DNI;
}
public function getNombre(){
    return $this->Nombre;
}
public function getApellidos(){
    return $this->Apellidos;
}
public function getEmail(){
    return $this->Email;
}
public function getContrasenia(){
    return $this->Contrasenia;
}
public function getTutor_Grupo(){
    if ($this->Tutor_grupo == '') {
        return "No.";
    } else {
        return $this->Tutor_grupo;
    }
}
public function getNivel_Acceso(){
    return $this->Nivel_acceso;
}
    
public function setDNI($DNI){
    $this->DNI = $DNI;
}
public function setNombre($Nombre){
    $this->Nombre = $Nombre;
}
public function setApellidos($Apellidos){
    $this->Apellidos = $Apellidos;
}
public function setEmail($Email){
    $this->Email = $Email;
}
public function setContrasenia($Contrasenia){
    $this->Contrasenia = $Contrasenia;
}
public function setTutor_grupo($Tutor_grupo){
    $this->Tutor_grupo = $Tutor_grupo;
}
public function setNivel_Acceso($Nivel_Acceso){
    $this->Nivel_acceso = $Nivel_acceso;
}
    
}
