<div class="form-group">
    <label class="miversalita micolor mipadding">Grupo: </label>
    <input type="text" name="grupo" class="form-control" value="<?php echo $_SESSION["grupo"] ?>" disabled size="4">
</div>


<div class="form-group">
    <label class="miversalita micolor mipadding">Alumno: </label>
    <input type="text" name="grupo" class="form-control" value="<?php echo $_SESSION["nombre_alumno"] ?>" disabled>
</div>
<!-- Meterlo aqui, pero haciendo una nueva pantalla de carga parte_tipoexpulsion -->
<label class="miversalita micolor mipadding">Tipo de parte: </label>
<div class="form-group">
    <select class="form-control" name="tipo_es_expulsion">
        <option value="" disabled selected>Selecciona el tipo de parte</option>
        <!--<option>Expulsion</option>-->
        <option>Puntos</option>
    </select>
</div>

<div class="form-group">     	
    <button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="parte_tipo_es_expulsion">
        Siguiente
    </button>
</div>