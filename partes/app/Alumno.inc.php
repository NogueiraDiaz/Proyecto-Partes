<?php

class Alumno {
    
    private $Matricula;
    private $Nom_alumno;
    private $Ape_alumno;
    private $Grupo;
    
    public function __construct($matricula, $nom_alumno, $ape_alumno, $grupo) {
        
        $this->Matricula = $matricula;
        $this->Nom_alumno = $nom_alumno;
        $this->Ape_alumno = $ape_alumno;
        $this->Grupo = $grupo;        
    }
    
    public function getMatricula(){
        return $this->Matricula;
    }
    public function getNom_alumno(){
        return $this->Nom_alumno;
    }
    public function getApe_alumno(){
        return $this->Ape_alumno;
    }
    public function getGrupo(){
        return $this->Grupo;
    }
    
    public function setMatricula($matricula){
        $this->Matricula = $matricula;
    }
    public function setNom_alumno($nom_alumno){
        $this->Nom_alumno = $nom_alumno;
    }
    public function setApe_alumno($ape_alumno){
        $this->Ape_alumno = $ape_alumno;
    }
    public function setGrupo($grupo){
        $this->Grupo = $grupo;
    }
}
