<?php $time = time(); ?>

<div class="form-group">     	
<label class="miversalita micolor mipadding">Fecha: </label> 
<input class="form-control" type="text" name="fecha" 
value="<?php echo date("d-m-Y", $time);?>" size="4">
</div>

<div class="form-group" >     	
<label class="miversalita micolor mipadding">Hora: </label> 
<input type="time" id="hora" class="form-control" name="hora" min="00:00" max="23:59"
value="<?php echo date("H:i:s", $time);?>" step="1">
</div>

<div class="form-group" >     	
<label class="miversalita micolor mipadding">Materia: </label> 
<input type="text" name="materia" class="form-control">
</div>

<div class="form-group" >     	
<button class="btn btn-success  miversalita mimargenizquierdo" type="submit" name="parte_fecha">Siguiente</button>
</div>

</div>


