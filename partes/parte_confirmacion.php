<?php
include_once "plantillas/cabecera.inc.php";
include_once "plantillas/navbar.inc.php";

include_once "app/Conexion.inc.php";

include_once "app/RepositorioSesion.inc.php";

include_once "app/Parte.inc.php";
include_once "app/RepositorioParte.inc.php";

include_once "app/Expulsion.inc.php";
include_once "app/RepositorioExpulsion.inc.php";

include_once "app/RepositorioParte_Expulsion.inc.php";
include_once "app/RepositorioIncidencia.inc.php";
session_start();
if(!isset($_SESSION["usuario_login"])){
    header("Location: ../index.php?redirigido=true");
};
RepositorioSesion::iniciarSesion();
if (isset($_POST["alta_parte"])) {

    /* if ($_SESSION["identificador_parte"] == "convivencia") {
        $_SESSION["puntos_incidencia"] = 0;
        $_SESSION["codigo_incidencia"] = 1;
    } */
    Conexion::abrirConexion();

    $parte = new Parte($_SESSION["usuario_login"]["dni"]
            , $_SESSION["codigo_alumno"]
            , $_SESSION["nombre_incidencia"]
            , $_SESSION["puntos_incidencia"]
            , $_SESSION["materia"]
            , $_SESSION["fecha"]
            , $_SESSION["hora"]
            , $_SESSION["descripcion_parte"]
            , $_SESSION["fecha_comunicacion_parte"]
            , $_SESSION["medio_comunicacion_parte"]
            , $_SESSION["tipo_es_expulsion"]
            , 0);

    //doy de alta el parte

    if (RepositorioParte::nuevoParte(Conexion::getConexion(), $parte)) {
        if ($_SESSION["identificador_parte"] == "incidencia") {
            //compruebo si es una expulsion sumando los puntos de los partes del alumno
            if (RepositorioParte::expulsadoParte(Conexion::getConexion(), $_SESSION["codigo_alumno"]) >= 10 || $_SESSION["tipo_es_expulsion"] == "Expulsion") {
                RepositorioParte::CaducarPartes(Conexion::getConexion(), $_SESSION["codigo_alumno"]);

                // para saber que se ha producido una expulsion y mostrar el mensaje
                // para avisar a jefatura
                $_SESSION["expulsion"]=1;
                //en el caso de que sea una expulsion, doy de alta la expulsion y me quedo
                //con el codigo de la expulsion para darle de alta en la tabla de partes_expulsion
                if (!($cod_expulsion = RepositorioExpulsion::nuevaExpulsion(Conexion::getConexion(), $_SESSION["codigo_alumno"], NULL, NULL))) {
                    echo "No se ha podido crear la expulsión. Contacta con la dirección del centro";
                }
            } else {
                header("Location:parte_correcto.php");
            }
        }
            header("Location:parte_correcto.php");
        }
    }
?>    

<!-- Salida por pantalla de los datos del parte-->
<div class="container">
    <br>
    <div class="row mifondoGlow">
        <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
            Datos parte <?php echo $_SESSION["identificador_parte"] ?>
        </h3>
        <?php
        RepositorioSesion::iniciarSesion();
        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Profesor", $_SESSION["usuario_login"]["nombre"]." ". $_SESSION["usuario_login"]["apellidos"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Alumno", $_SESSION["nombre_alumno"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Grupo", $_SESSION["grupo"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Fecha parte incidencia", $_SESSION["fecha"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Hora", $_SESSION["hora"]);
        echo "</div>";

        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Materia", $_SESSION["materia"]);
        echo "</div>";

        if ($_SESSION["identificador_parte"] == "incidencia") {
            echo "<div class = 'row col-md-4'> ";
            RepositorioSesion::mostrarDatosSesion("Incidencia", $_SESSION["nombre_incidencia"]);
            echo "</div>";
            echo "<div class = 'col-md-8'> ";
            RepositorioSesion::mostrarDatosSesion("Puntos", $_SESSION["puntos_incidencia"]);
            echo "</div>";
        }

        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Descripcion", $_SESSION["descripcion_parte"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Medio Comunicación", $_SESSION["medio_comunicacion_parte"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Fecha Comunicación", $_SESSION["fecha_comunicacion_parte"]);
        echo "</div>";
        ?> 

        <form class="center-block mipadding" method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 "> 
                    <button class="btn btn-lg btn-danger btn-block miversalita mimargensuperior15" 
                            type="submit" name="alta_parte">
                        <span >Confirmar datos partes y CREAR PARTE</span>
                    </button>
                </div>

            </div>
        </form>
    </div>    
</div>

<?php
include_once "plantillas/pie.inc.php";
?>




