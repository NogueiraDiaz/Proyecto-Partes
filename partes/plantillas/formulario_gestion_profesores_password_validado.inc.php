<label class="form-group col-md-2 micolor miversalita">Password</label>
<div class="form-group col-md-10"> 
    <input type="password" class="form-control" name="password1" placeholder="Contraseña"  
           <?php $validar_password->getPassword1() ?> >
           <?php $validar_password->getErrorPassword1() ?>
</div>

<label class="form-group col-md-2 micolor miversalita">Password</label>
<div class="form-group col-md-10"> 
    <input type="password" class="form-control" name="password2" placeholder="Repite la Contraseña"
           <?php $validar_password->getPassword2() ?> >
           <?php $validar_password->getErrorPassword2() ?>
</div>

<button type="submit" class="btn btn-lg btn-success btn-primary btn-block miversalita" 
        name="enviar"> Aceptar</button>  
<button type="reset" class="btn btn-lg btn-default btn-primary btn-block miversalita"
        name="borrar">  Borrar Datos</button>

