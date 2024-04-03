<label class="form-group col-md-2 micolor miversalita">DNI</label>
<div class="form-group col-md-10"> 
    <input type="text" class="form-control" name="dni" placeholder="xxxxxxxxxA"  autofocus>
</div>

<label class="form-group col-md-2 micolor miversalita">Apellidos</label>
<div class="form-group col-md-10"> 
    <input type="text" class="form-control" name="apellidos" placeholder="Verne">
</div>

<label class="form-group col-md-2 micolor miversalita">Nombre</label>
<div class="form-group col-md-10"> 
    <input type="text" class="form-control" name="nombre" placeholder="Julio" >
</div>

<label class="form-group col-md-2 micolor miversalita">Email</label>
<div class="form-group col-md-10"> 
    <input type="email" class="form-control" name="email" placeholder="julioverne@bargas.es">
</div>

<label class="form-group col-md-2 micolor miversalita">Password</label>
<div class="form-group col-md-10"> 
    <input type="password" class="form-control" name="password1" placeholder="Contraseña" >
</div>

<label class="form-group col-md-2 micolor miversalita">Password</label>
<div class="form-group col-md-10"> 
    <input type="password" class="form-control" name="password2" placeholder="Repite la Contraseña">
</div>

<label class="form-group col-md-2 micolor miversalita">Tutor</label>
<div class="form-group col-md-10"> 
    <select class="form-control" name="grupo">
        <!--<option value="No." disabled selected>Sólo si eres tutor. Si no eres tutor NO selecciones nada</option>-->
		<option value="No." selected>Sólo si eres tutor. Si no eres tutor NO selecciones nada</option>
		<option value="B1A">B1A</option>
		<option value="B1B">B1B</option>
		<option value="B1C">B1C</option>
		<option value="B1D">B1D</option>
		<option value="B2A">B2A</option>
		<option value="B2B">B2B</option>
		<option value="B2C">B2C</option>
		<option value="DAM1">DAM1</option>
		<option value="DAM2">DAM2</option>
		<option value="DAW1">DAW1</option>
		<option value="DAW2">DAW2</option>
		<option value="DIV3C">DIV3C</option>
		<option value="DIV3D">DIV3D</option>
		<option value="E1A">E1A</option>
		<option value="E1B">E1B</option>
		<option value="E1C">E1C</option>
		<option value="E1D">E1D</option>
		<option value="E1E">E1E</option>
		<option value="E1F">E1F</option>
		<option value="E2A">E2A</option>
		<option value="E2B">E2B</option>
		<option value="E2C">E2C</option>
		<option value="E2D">E2D</option>
		<option value="E2E">E2E</option>
		<option value="E2F">E2F</option>
		<option value="E3A">E3A</option>
		<option value="E3B">E3B</option>
		<option value="E3C">E3C</option>
		<option value="E3D">E3D</option>
		<option value="E3E">E3E</option>
		<option value="E3F">E3F</option>
		<option value="E4A">E4A</option>
		<option value="E4B">E4B</option>
		<option value="E4C">E4C</option>
		<option value="E4D">E4D</option>
		<option value="E4E">E4E</option>
		<option value="E4F">E4F</option>
		<option value="FPB1">FPB1</option>
		<option value="FPB2">FPB2</option>
		<option value="PEFP1">PEFP1</option>
		<option value="PEFP2">PEFP2</option>
		<option value="PMAR1">PMAR1</option>
		<option value="SMR1">SMR1</option>
		<option value="SMR2">SMR2</option>
        <?php

    /*foreach ($_SESSION["grupos"] as $alu) {
    echo "<option>" . $alu["Grupo"] ."</option>";
    }*/
        ?>
    </select>
</div>

<button type="submit" class="btn btn-lg btn-success btn-block miversalita" 
        name="enviar"> Aceptar</button>  
<button type="reset" class="btn btn-lg btn-primary  btn-block miversalita"
        name="borrar">  Borrar Datos</button>


