<label class="miversalita micolor mipadding">Puntos Incidencia </label>
<div class="form-group">
    <select class="form-control" name="curso">
        <option value="<?php echo $_SESSION["puntos_incidencia"] ?>" disabled selected>
            <?php echo $_SESSION["puntos_incidencia"] ?>
        </option>
    </select>
</div>

<label class="miversalita micolor mipadding">Incidencias </label>
<div class="form-group">
    <select class="form-control" name="nombre">
        <option value="" disabled selected>Selecciona una Incidencia.</option>
        <?php
        foreach ($_SESSION["incidencias"] as $inc) {
            echo "<option>" . $inc["nombre"] . "</option>";
        }
        ?>
    </select>
</div>

<div class="form-group" >     	
    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="parte_incidencia">
        Siguiente
    </button>
</div>

