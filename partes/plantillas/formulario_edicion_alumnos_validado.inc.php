<label class="form-group col-md-3 micolor miversalita">Apellidos</label>
<div class="form-group col-md-9"> 
    <input type="text" class="form-control" name="apellidos" 
           placeholder="Apellidos Alumno"  
           <?php $validar_alumno->getApellidos() ?> >
           <?php $validar_alumno->getErrorApellidos() ?>
</div>

<label class="form-group col-md-3 micolor miversalita">Nombre</label>
<div class="form-group col-md-9"> 
    <input type="text" class="form-control" name="nombre" placeholder="Nombre Alumno" 
           <?php $validar_alumno->getNombre() ?> >
           <?php $validar_alumno->getErrorNombre() ?>
</div>

<label class="form-group col-md-3 micolor miversalita">Grupo</label>
<div class="form-group col-md-9"> 
    <select class="form-control" name="grupo">
        <option value="" selected>
           
        </option>
        <?php

    foreach ($_SESSION["grupos"] as $alu) {
    echo "<option>" . $alu["grupo"] ."</option>";
    }
        ?>
    </select>
</div>

<button type="submit" class="btn btn-lg btn-success btn-primary btn-block miversalita" 
        name="enviar"> 
    Aceptar
</button>  

<button type="reset" class="btn btn-lg btn-default btn-primary btn-block miversalita"
        name="borrar">  
    Borrar Datos
</button>





