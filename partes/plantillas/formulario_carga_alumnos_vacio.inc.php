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
    <input type="file" name="fichero">
  </div>

<div class="form-group">     	
    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="cargar_alumnos">
        Siguiente
    </button>
</div>