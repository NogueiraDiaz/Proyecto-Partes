<label class="miversalita micolor mipadding">Puntos Incidencia: </label>
<div class="form-group">
<select class="form-control" name="puntos">
<option value="" disabled selected>Selecciona el número de puntos</option>
    <?php
        include_once "RepositorioIncidencia.inc.php";
        include_once "Conexion.inc.php";
        Conexion::abrirConexion();
        $puntos = RepositorioIncidencia::getPuntos(Conexion::getConexion());
        foreach($puntos as $punto){
            echo "<option>" . $punto["puntos"] . "</option>";
        }
        Conexion::cerrarConexion();
    ?>
    </select>
</div>

<div class="form-group " >     	
    <button class="btn btn-success miversalita mimargenizquierdo" type="submit" name="parte_puntos_incidencia">Siguiente</button>
</div>

<?php
if (isset($_SESSION["error_puntos"])) {
    $validar_puntos = new ValidarParte();
    $validar_puntos->getError($_SESSION["error_puntos"]);
    unset($_SESSION["error_puntos"]);
}
?> 
