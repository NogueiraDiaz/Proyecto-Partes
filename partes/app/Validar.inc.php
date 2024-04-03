<?php
class Validar {

//--------------------------------------------------------------------------------------
// Métodos Reutilizados
//--------------------------------------------------------------------------------------
    protected function variableIniciada($valor) {
        // Para comprobar que un campo haya sido introducido
        return (isset($valor) && !empty($valor)) ? true : false;
    }

    protected function variableVacia($valor) {
        // Para comprobar que esta vacia
        return $valor === "" ? true : false;
    }

    protected function mostrarValor($valor) {
        echo $this->inicioavisoerror . $valor . $this->finavisoerror;
    }

    protected function valorValue($valor) {
        echo 'value="' . $valor . '"';
    }

}
