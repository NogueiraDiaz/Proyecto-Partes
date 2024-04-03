<div class="form-group">
    <label class="miversalita micolor mipadding">Alumno: </label>
    <select class="form-control" name="nombre">
        <option value="" disabled selected>Selecciona el nombre de un alumno</option>
		<?php
			foreach ($_SESSION["alumnos_grupo"] as $alumno) {
				echo "<option value=\" " . $alumno[0] . " \">" . $alumno[1] . ", " . $alumno[2] . "</option>";
			}
		?>
    </select>
</div>

<div class="form-group">     	
    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="parte_grupo_nombre">
        Buscar
    </button>
</div>




