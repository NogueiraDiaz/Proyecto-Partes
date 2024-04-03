<br>
<div class="container">
     <div class="col-md-12 text-right"> 
        <a href="ver_partes_jefatura_fecha.php" 
           class="btn btn-success miversalita ">
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true">
                Volver
            </span>
        </a>
    </div> 
    <br>
    <br>
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                   Partes fecha:  <?php echo $_SESSION["fecha_inicio"]. " - " .$_SESSION["fecha_fin"];?>
                </h3>
            </div>
            <?php if (empty($partes_alumnos) && empty($partes_alumnos_expulsion)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    Actualmente no hay ningún parte. 
                </h4>
            <?php } else {
                ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="mifuente  micoloretiqueta minegrita">Alumno</th>
                                <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
                                <th class="mifuente  micoloretiqueta minegrita">Grupo</th>
                                <th class="mifuente  micoloretiqueta minegrita">Fecha</th>
                                <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                                <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($partes_alumnos as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nombreAlumno"] . " " . $parte["apellidosAlumno"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nombreProfesor"] . " " . $parte["apellidosProfesor"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["grupo"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($parte["fecha"])); ?>
                                    </td>
                                    <td class="mifuente micolorparte minegrita">
                                        <?php echo $parte["puntos"] ?>
                                    </td>
                                    <td class="mifuente  minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="codigo_parte" value="<?php $parte?>">
                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
                                                    name="ver">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                 Ver
                                                </span>
                                            </button> 
                                            <button type="submit" class="btn btn-sx micolor btn-danger miversalita" 
                                                    name="borrar">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true">
                                                 Borrar 
                                                </span>
                                            </button> 
                                        </form>
                                    </td>
                                </tr>    
                                <?php
                            }

                            foreach ($partes_alumnos_expulsion as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nombreAlumno"] . " " . $parte["apellidosAlumno"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["NombreAlumno"] . " " . $parte["ApellidosAlumno"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["Grupo"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($parte["Fecha"])); ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["Puntos"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="datos" 
                                                   value="<?php echo $parte["cod_parte_expulsion"]
                                                   . "-" . $parte["cod_expulsion"]
                                                   ?>">
                                            <button type="submit" class="btn btn-sx micolor btn-primary miversalita" 
                                                    name="ver_parte_expulsion">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                  Ver
                                                </span>
                                            </button> 
                                            <?php if ($parte["fecha_inicio_expulsion"] == "0000-00-00") { ?>
                                                <button type="submit" class="btn btn-sx micolor btn-danger miversalita" 
                                                        name="borrar_parte_expulsion">
                                                    <span class="glyphicon glyphicon-trash" aria-hidden="true">
                                                       Borrar
                                                    </span>
                                                </button> 
                                            <?php } ?>
                                        </form>
                                    </td>
                                </tr>    
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
