<div class="container">
    <div class="col-md-12"> 
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <h3 class="text-center mifuente minegrita miversalita micoloretiqueta ">
                    <?php
                    echo "Expulsiones del alumno: " . $datos_alumno[1]
                    . " " . $datos_alumno[2];
                    ?>
                </h3>
            </div>
            <?php if (empty($partes_alumno)) { ?>
                <h4 class="mifuente minegrita mimargen micolor miversalita">
                    No hay expulsiones. 
                </h4>
            <?php } else { ?>
                <div class="panel-body">
                    <table class="table table-responsive">
                        <?php foreach ($partes_alumno as $parte) { ?>
                                <tr class ="mifondo text-center">
                                    <td colspan="4" class="mifuente  micoloretiqueta minegrita">
                                        <span class="mifuente  micoloretiqueta minegrita">Fecha Inicio Expulsión: </span>
                                        <?php echo date("d-m-Y", strtotime($parte["fecha_Inicio"])); ?>
                                        <span class="mifuente  micoloretiqueta minegrita">- Fecha Fin Expulsión: </span>
                                        <?php echo date("d-m-Y", strtotime($parte["fecha_Fin"])); ?>
                                    </td>
                                </tr>
						<?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

