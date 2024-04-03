<?php

class Expulsion {

    private $Matricula_del_alumno;
    private $Fecha_inicio_expulsion;
    private $Fecha_fin_expulsion;
    private $Fecha_insercion;

    public function __construct($matricula_del_alumno, $fecha_inicio_expulsion, $fecha_fin_expulsion, $Fecha_insercion) {
        $this->Matricula_del_alumno = $matricula_del_alumno;
        $this->Fecha_inicio_expulsion = $fecha_inicio_expulsion;
        $this->Fecha_fin_expulsion = $fecha_fin_expulsion;
        $this->Fecha_insercion = $Fecha_insercion;
    }
    public function getMatricula_del_alumno() {
        return $this->matricula_del_alumno;
    }

    public function getFecha_inicio_expulsion() {
        return $this->fecha_inicio_expulsion;
    }

    public function getFecha_fin_expulsion() {
        return $this->fecha_fin_expulsion;
    }

    public function getFecha_insercion(){
        return $this->getFecha_insercion;
    }

    public function setMatricula_del_alumno($matricula_del_alumno) {
        $this->matricula_del_alumno = $matricula_del_alumno;
    }
    
    public function setFecha_inicio_expulsion($fecha_inicio_expulsion) {
        $this->fecha_inicio_expulsion = $fecha_inicio_expulsion;
    }

    public function setFecha_fin_expulsion($fecha_fin_expulsion) {
        $this->fecha_fin_expulsion = $fecha_fin_expulsion;
    }

}
