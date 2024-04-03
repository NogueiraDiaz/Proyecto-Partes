<?php

class RepositorioSesion {

    public static function iniciarSesion() {
        if (session_id() == "") {
            session_start();
        }
    }

    public static function mostrarDatosSesion($encabezado, $dato_sesion) {
        echo "<label class='miversalita micolor mipaddingsesion'>";
        echo "<span class ='micoloretiqueta'>" . $encabezado . ": </span>";
        echo "<span class ='text-justify'>" . $dato_sesion . "</span>";
        echo "</label>";
    }

    public static function borrarNombreProfesorSesion() {
        self::iniciarSesion();
        if (isset($_SESSION["nombre_profesor"])) {
            unset($_SESSION["nombre_profesor"]);
        }
        if (isset($_SESSION["nombre_profesor_navbar"])) {
            unset($_SESSION["nombre_profesor_navbar"]);
        }
        if (isset($_SESSION["tipo_profesor"])) {
            unset($_SESSION["tipo_profesor"]);
        }
    }

    public static function borrarDatosSesion() {
        self::iniciarSesion();
        if (isset($_SESSION["codigo_alumno"])) {
            unset($_SESSION["codigo_alumno"]);
        }
        if (isset($_SESSION["nombre_alumno"])) {
            unset($_SESSION["nombre_alumno"]);
        }
        if (isset($_SESSION["grupo"])) {
            unset($_SESSION["grupo"]);
        }
        if (isset($_SESSION["alumno"])) {
            unset($_SESSION["alumno"]);
        }
		if (isset($_SESSION["alumnos"])) {
            unset($_SESSION["alumnos"]);
        }
        if (isset($_SESSION["materia"])) {
            unset($_SESSION["materia"]);
        }
        if (isset($_SESSION["fecha"])) {
            unset($_SESSION["fecha"]);
        }
        if (isset($_SESSION["hora"])) {
            unset($_SESSION["hora"]);
        }
        if (isset($_SESSION["puntos_incidencia"])) {
            unset($_SESSION["puntos_incidencia"]);
        }
        if (isset($_SESSION["nombre_incidencia"])) {
            unset($_SESSION["nombre_incidencia"]);
        }
        if (isset($_SESSION["descripcion_parte"])) {
            unset($_SESSION["descripcion_parte"]);
        }
        if (isset($_SESSION["fecha_comunicacion_parte"])) {
            unset($_SESSION["fecha_comunicacion_parte"]);
        }
        if (isset($_SESSION["medio_comunicacion_parte"])) {
            unset($_SESSION["medio_comunicacion_parte"]);
        }
        if (isset($_SESSION["tipo_es_expulsion"])) {
            unset($_SESSION["tipo_es_expulsion"]);
        }
    }

}
