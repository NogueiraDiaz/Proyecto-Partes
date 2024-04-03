<div class="col-md-12 mimargensuperior15"> 
    <div class="panel panel-default" >
        <div class="panel-heading" >
            <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                Expulsiones alumno.
            </h3>
        </div>
        <div class="panel-body">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th class="mifuente  micoloretiqueta minegrita">Nombre</th>
                        <th class="mifuente  micoloretiqueta minegrita">Grupo</th>
                        <th class="mifuente  micoloretiqueta minegrita">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Para que solo salgan las cabeceras al acceder a la página
                    // por primera vez. No muestro todo como en profesores, ya 
                    // que sería una consulta muy pesada
                    if (isset($alumnos)) {
                        foreach ($alumnos as $alumno) {
                            ?>
                            <tr>
                                <td class="mifuente micolor minegrita">
                                <?php echo $alumno["nombre"] . " " . $alumno["apellidos"] ?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                <?php echo $alumno["grupo"] ?>
                                </td>
                                <td class="mifuente micolor minegrita">
                                    <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                        <input type="hidden" name="alumno" value="<?php echo $alumno["matricula"] ?>">
                                        <button type="submit" class="btn  micolor btn-primary miversalita" 
                                                name="expulsiones_alumno">
                                            <span class="glyphicon glyphicon-bullhorn" aria-hidden="true">
                                                Expulsiones
                                            </span>
                                        </button> 
                                    </form>
                                </td>
                            </tr>    
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

