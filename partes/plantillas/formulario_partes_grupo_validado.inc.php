<label class="miversalita micolor mipadding">Curso: </label>
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

<?php
if (isset($_SESSION["error_curso_grupo"])) {
    $validar = new ValidarParte();
    $validar->getError($_SESSION["error_curso_grupo"]);
    unset($_SESSION["error_curso_grupo"]);
}
?>  
