<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php
                    echo "Expulsiones del alumno: " . $partes_alumno[0]["nom_alumno"]
                    . " " . $partes_alumno[0]["ape_alumno"]
                    ?>
                </h3>
            </div>
            <?php if (empty($partes_alumno) && empty($partes_expulsion_alumno)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    No hay expulsiones. 
                </h4>
            <?php } else {
                ?>

                <div class="panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <th class="mifuente  micoloretiqueta minegrita">Profesor</th>
                            <th class="mifuente  micoloretiqueta minegrita">fecha</th>
                            <th class="mifuente  micoloretiqueta minegrita">Incidencia</th>
                            <th class="mifuente  micoloretiqueta minegrita">Puntos</th>
                            <th class="mifuente  micoloretiqueta minegrita">Acciones</th>
                        </tr>
                        <tbody>
                            <?php
                            foreach ($partes_alumno as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nom_profesor"] . " " . $parte["ape_profesor"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($parte["fecha_parte"])); ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nom_incidencia"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["puntos_parte"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="codigo_parte" value="<?php echo $parte["cod_parte"] ?>">
                                            <button type="submit" class="btn micolor btn-primary miversalita" 
                                                    name="ver">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                    Ver
                                                </span>
                                            </button> 
                                        </form>
                                    </td>
                                </tr>    
                            <?php } 
                            foreach ($partes_expulsion_alumno as $parte) {
                                ?>
                                <tr>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nom_profesor"] . " " . $parte["ape_profesor"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo date("d-m-Y", strtotime($parte["fecha_parte"])); ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["nom_incidencia"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <?php echo $parte["puntos_parte"] ?>
                                    </td>
                                    <td class="mifuente micolor minegrita">
                                        <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="codigo_parte" value="<?php echo $parte["cod_parte_expulsion"] ?>">
                                            <button type="submit" class="btn micolor btn-primary miversalita" 
                                                    name="ver">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true">
                                                    Ver
                                                </span>
                                            </button> 
                                        </form>
                                    </td>
                                </tr>    
                            <?php } ?>
                                
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

