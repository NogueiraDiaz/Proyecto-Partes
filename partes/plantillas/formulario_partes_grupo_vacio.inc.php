<?php
include_once "app/RepositorioGrupo.inc.php";
include_once "app/RepositorioProfesor.inc.php";
include_once "app/RepositorioSesion.inc.php";



Conexion::abrirConexion();


?>
<label class="miversalita micolor mipadding">Grupo: </label>
<div class="form-group">
    <select class="form-control" name="grupo">
        <option value="" disabled selected>Selección curso alumno</option>
        <?php

    foreach ($_SESSION["grupos"] as $alu) {
    echo "<option>" . $alu["grupo"] ."</option>";
    }
        ?>
    </select>
</div>

<div class="form-group">     	
    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="parte_grupo">
        Siguiente
    </button>
</div>


