<input type="email" class="form-control" name="email" placeholder="Correo" autofocus
    <?php $validar_login->getEmail() ?> >
    <?php $validar_login->getErrorEmail() ?>
<input type="password" class="form-control mimargensuperior5" placeholder="Contraseña" name="password"
    <?php $validar_login->getPassword() ?> >
    <?php $validar_login->getErrorPassword() ?>
<br>
<button class="btn btn-lg  btn-success btn-block miversalita" type="submit" name="enviar_login">Entrar</button>
<br>