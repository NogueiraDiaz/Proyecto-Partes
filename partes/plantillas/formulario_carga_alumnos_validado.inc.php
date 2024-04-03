<label class="miversalita micolor mipadding">Grupo: </label>
<div class="form-group">
    <select class="form-control" name="grupo">
        <option value="" disabled selected>Selección asd alumno</option>
        <?php

    foreach ($_SESSION["Grupos"] as $alu) {
    echo "<option>" . $alu["grupo"] ."</option>";
    }
        ?>
    </select>
</div>

<div class="form-group">
    <input type="file" name="fichero">
</div>

<div class="form-group">     	
    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="cargar_alumnos">
        Siguiente
    </button>
</div>

<?php
$validar_incidencia = new ValidarParte();
if (isset($_SESSION["error_grupo"])) {
    $validar_incidencia->getError($_SESSION["error_grupo"]);
    unset($_SESSION["error_grupo"]);
} else {
    if ($_SESSION["error_fichero"]) {
        $validar_incidencia->getError($_SESSION["error_fichero"]);
        unset($_SESSION["error_fichero"]);
    } else {
        if ($_SERVER["alta_correcta"]) {
            $valor = "Los alumnos del curso " .
                    $_SESSION["info_alta_grupo"] .
                    " han sido dados de alta correctamente";
            $validar_incidencia->mostrarInformacion($valor);
            unset($_SESSION["info_alta_grupo"]);
        } else {
            $valor = "Los alumnos del curso " .
                    $_SESSION["info_alta_grupo"] .
                    " no han sido dados de alta correctamente";
            $validar_incidencia->mostrarError($valor);
        }
    }
}
?> 
