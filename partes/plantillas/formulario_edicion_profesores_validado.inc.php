<label class="form-group col-md-2 micolor miversalita">DNI</label>
<div class="form-group col-md-10"> 
    <input type="text" class="form-control" name="dni" placeholder="xxxxxxxxA"
           <?php $validar_profesor->getDni() ?> >
           <?php $validar_profesor->getErrorDni() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Apellidos</label>
<div class="form-group col-md-10"> 
    <input type="text" class="form-control" name="apellidos" placeholder="Verne"
           <?php $validar_profesor->getApellidos() ?> >
           <?php $validar_profesor->getErrorApellidos() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Nombre</label>
<div class="form-group col-md-10"> 
    <input type="text" class="form-control" name="nombre" placeholder="Julio" 
           <?php $validar_profesor->getNombre() ?> >
           <?php $validar_profesor->getErrorNombre() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Email</label>
<div class="form-group col-md-10"> 
    <input type="email" class="form-control" name="email" 
           placeholder="julioverne@bargas.es"
           <?php $validar_profesor->getEmail() ?> >
           <?php $validar_profesor->getErrorEmail() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Password</label>
<div class="form-group col-md-10"> 
    <input type="password" class="form-control" name="password1" 
           placeholder="Contraseña">
           <?php $validar_profesor->getErrorPassword1() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Password</label>
<div class="form-group col-md-10"> 
    <input type="password" class="form-control" name="password2" 
           placeholder="Repite la Contraseña">
           <?php $validar_profesor->getErrorPassword2() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Tutor</label>
<div class="form-group col-md-10"> 
    <select class="form-control" name="grupo">
        <?php if ($profesor->getTutor_Grupo() != "No.") { ?>
            <option value = "<?php echo $profesor->getNivel_Acceso(); ?>" selected> <?php echo $profesor->getNivel_Acceso() ?></option>
        <?php } else { ?>
            <option>Dejar de ser tutor</option>
        <?php } ?>
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

