<div class="form-group">
    <div class="col-md-4">
        <div class="panel panel-default miquitarborder" >

            <label class="miversalita micolor">
                Comunicación del parte de  <?php echo $_SESSION["identificador_parte"] ?>: 
            </label>
            <!-- Lo tengo que hacer con span para que salga el checkbox en la misma linea-->
            <div class="panel-body">
                <input  type="radio" name="comunicacion" value="Entrevista con los padres"/> 
                <span class="micolor mifuente miversalita">
                    Entrevista con los padres
                </span><br>

                <input  type="radio" name="comunicacion" value="Llamada telefónica"/>
                <span class="micolor mifuente miversalita" >
                    Llamada telefónica
                </span><br>

                <input type="radio" name="comunicacion" value="Mensaje"/> 
                <span class="micolor mifuente miversalita" >
                    Mensaje
                </span><br>

                <input type="radio" name="comunicacion" value="Notificación escrita"/>
                <span class="micolor mifuente miversalita" >
                    Notificación escrita
                </span><br>
            </div>

            <div class="row">
                <?php $time = time(); ?>
                <div class="form-group col-md-7">  
                    <label class="miversalita micolor">Fecha comunicación parte: </label> 
                    <div class="col-md-9"> 
                        <input class="text-center form-control " type="text" name="fecha" 
                               value="<?php echo date("d-m-Y", $time); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mimargensuperior15" >     	
            <button class="btn btn-success  miversalita mimargenizquierdo" 
                    type="submit" name="parte_comunicacion">
                Siguiente
            </button>
        </div>
    </div>

    <div class="col-md-8">
        <?php
        Conexion::abrirConexion();
        $alumno = RepositorioAlumno::getAlumnoCodigo(Conexion::getConexion(), $_SESSION["codigo_alumno"]);
        Conexion::cerrarConexion();
        ?>
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    Datos de contacto del alumno
                </h3>
            </div>
            <div class="panel-body">
                <div> 
                    <?php
                    RepositorioSesion::mostrarDatosSesion("Alumno", 
                    ($alumno["nombre"]. " " .$alumno["apellidos"]));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>





