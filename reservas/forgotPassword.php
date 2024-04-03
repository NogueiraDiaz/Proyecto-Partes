<?php
    session_start();
    include_once('./fragments/headers.php');
    if (!isset($_SESSION['usuario_login'])) {
?>
    <main>
        <p class="display-6 text-center my-3">Reserva de espacios</p>
        <div class="container">
            <h3 class="text-primary fw-normal text-center">Recuperar contraseña</h3>
            <form id="formRecover" class="p-4 mx-2 row shadow-sm rounded-3 border border-primary">

                <div class="form-group col-12 my-2">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ej. tucorreo@gmail.com" required class="form-control">
                </div>
                <p class="text-center"><small>Se enviará una nueva contraseña a tu email</small></p>
                <div class="form-group mt-2 text-center">
                    <button type="submit" class="btn btn-primary my-2">Recuperar</button>
                </div>
            </form>
        </div>
        <div class="container my-2 text-center">
            <a class="btn btn-outline-secondary" href="./login">Iniciar Sesión</a>
        </div>
    </main>
    <script>

        $('#formRecover').submit(function(ev){
            ev.preventDefault();
            sendRecovery()
        });

        function sendRecovery(){
            $.ajax({
                type: "POST",
                data: { email: $('#email').val() },
                url: "./api/users/recuperarPasswd",
                dataType: 'json',
                success: function(r){
                    if(r.isok){
                        showToast(r.data,'success')
                    }
                    else if(r.error){
                        console.log(r);
                        showError(r.error, 15000)
                    }
                },
                error: function(e){
                    console.log(e);
                    showToast(e.responseText,'danger', 25000)
                    showError('ERROR EN LA PETICIÓN<br>Si persiste, contacte con jefatura')
                }
            })
        }
    </script>
<?php 
    } else {        
         header("location: ../index.php");
    }
    include_once('./fragments/footer.php');
?>