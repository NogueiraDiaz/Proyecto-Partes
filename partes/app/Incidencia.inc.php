<?php

class Incidencia {

    private $Nombre;
    private $Puntos;
    private $Descripcion;

    public function __constructor($nombre, $puntos, $descripcion) {
        $this->Nombre = $nombre;
        $this->Puntos = $puntos;
        $this->Descripcion = $descripcion;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPuntos() {
        return $this->puntos;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPuntos($puntos) {
        $this->puntos = $puntos;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

}
