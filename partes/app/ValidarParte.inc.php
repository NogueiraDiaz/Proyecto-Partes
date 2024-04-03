<?php

class ValidarParte {

    private $inicioavisoerror;
    private $inicioavisoinformacion;
    private $finaviso;

    public function __construct() {
        $this->inicioavisoerror = "<div class='alert alert-danger' role='alert'>";
        $this->inicioavisoinformacion = "<div class='alert alert-success text-wight text-center' role='alert'>";
        $this->finaviso = "</div>";
    }

    private function variableVacia($valor) {
        // Para comprobar que esta vacia
        return $valor === "" ? true : false;
    }

    public function mostrarError($valor) {
        echo $this->inicioavisoerror . $valor . $this->finaviso;
    }

    public function mostrarInformacion($valor) {
        echo $this->inicioavisoinformacion . $valor . $this->finaviso;
    }

    public function getError($errorvalor) {
        if (!$this->variableVacia($errorvalor)) {
            $this->mostrarError($errorvalor);
        }
    }
    public function validaFecha($fecha) {
        //Expresion regular para controlar formato fecha dd-mm-aaaa
        //  $patron = "/^(?:3[01]|[12][0-9]|0?[1-9])([\/|-])(0?[1-9]|1[1-2])\1\d{4}$/";


        /* No he utilizado expresiones regulares porque para la fecha
         * me han fallado un montón  

         * checkdate comprueba todos los meses, bisiestos....... le paso primero
         * el mes porque lo define así la función, el primer parámetro tiene
         * que ser el mes, el segundo el día y el tercero el año

         * Aunque php no es tipado, internamente si que trabaja con tipos
         * y por eso hago las conversiones para comprobar y que funcione correctamente
         */
        $valor = preg_split("[\/|-]", $fecha);
        $dia = (int) $valor[0];
        $mes = (int) $valor[1];
        $anno = (int) $valor[2];
        if (is_int($dia) && is_int($mes) && is_int($anno)) {
            if (checkdate($mes, $dia, $anno)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
