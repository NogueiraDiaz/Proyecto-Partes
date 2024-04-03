<div class="col-md-12 mimargensuperior15"> 
    <div class="panel panel-default" >
        <div class="panel-heading" >
            <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                Gestión alumno
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
								<form method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
	                                <td class="mifuente micolor minegrita">
		                                <?php echo $alumno["nombre"] . " " . $alumno["apellidos"] ?>
	                                </td>
	                                <td class="mifuente micolor minegrita">
										<input type="hidden" name="grupo_alumno" value="<?php echo $alumno["grupo"] ?>">
	                                	<?php echo $alumno["grupo"] ?>
                                	</td>
                                	<td class="mifuente micolor minegrita">
                                       	<input type="hidden" name="alumno" value="<?php echo $alumno["matricula"] ?>">
                                        <button type="submit" class="btn  micolor btn-primary miversalita" name="partes_alumno">
                                        	<span class="glyphicon glyphicon-bullhorn" aria-hidden="true">
                                          	    Partes
                                            </span>
                                    	</button> 
                                	</td>
								</form>
                            </tr>    
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

