<div class="container">
    <br>
    <div class="row mifondo">
        <h3 class="text-center mifondo miversalita micoloretiqueta mipaddingtitulo">
            Datos parte. 
        </h3>
        <?php
        RepositorioSesion::iniciarSesion();
        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Profesor", ($datos_parte["nombreProfesor"] . " " . $datos_parte["apellidosProfesor"]));
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Alumno", ($datos_parte["nombreAlumno"] . " " . $datos_parte["apellidosAlumno"]));
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Grupo", $datos_parte["grupo"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Fecha parte incidencia", date("d-m-Y", strtotime($datos_parte["fecha"])));
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Hora", $datos_parte["hora"]);
        echo "</div>";

        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Materia", $datos_parte["materia"]);
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Incidencia", $datos_parte["incidencia"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Puntos", $datos_parte["puntos"]);
        echo "</div>";

        echo "<div class = 'row col-md-12'> ";
        RepositorioSesion::mostrarDatosSesion("Descripcion", utf8_encode($datos_parte["descripcion"]));
        echo "</div>";

        echo "<div class = 'row col-md-4'> ";
        RepositorioSesion::mostrarDatosSesion("Medio Comunicación", $datos_parte["via_Comunicacion"]);
        echo "</div>";
        echo "<div class = 'col-md-8'> ";
        RepositorioSesion::mostrarDatosSesion("Fecha Comunicación", date("d-m-Y", strtotime($datos_parte["fecha_Comunicacion"])));
        echo "</div>";
        ?> 
    </div>    
</div>
<br>
