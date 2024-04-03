    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ICONO DE LA PESTAÑA DEL NAVEGADOR -->
        <link rel="shortcut icon" href="../img/icono.png">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <title>Restablecer</title>
        <style>
            .gradient-custom {
                /* fallback for old browsers */
                background: #6a11cb;

                /* Chrome 10-25, Safari 5.1-6 */
                background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

                /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
            }
            .error{
                color:red;
            }
        </style>


    </head>
    <header>
    <?php
        $emailEncriptado = $_GET['usuario'];
        // Recuperamos los datos del usuario logueado de la base de datos
        require_once('conexion.php');
        // Seleccionamos todo del usuarios para comprobar quien tiene que restablecer
        $select = "SELECT cod_usuario, nombre, apellidos, email FROM Usuarios";
        $resul = $db->query($select);
        $cod_usuario="";
        //Comprobamos si existe el usuario.
        while ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($columna['email'], $emailEncriptado)) {
                $cod_usuario=$columna['cod_usuario'];
            }
               

        }

        if($cod_usuario==""){
            print "
            <script>
                window.location = '../index.php';
            </script>";
        }
           
    ?>
        </header>
    <body class="gradient-custom">
        
        <section>
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mt-md-2 pb-4">
                                    <h2 class="fw-bold mb-4 text-uppercase">Restablecer Contraseña</h2>
                                    <form method="post">
                                    
                                        <div class="form-floating form-white mb-4 text-dark">
                                            <input type="password" id="password1" name="password1" class="form-control form-control-lg" placeholder="Contraseña nueva" required/>
                                            <label class="form-label" for="password1">Contraseña nueva</label>
                                        </div>
                                        <div class="form-floating form-white mb-4 text-dark">
                                            <input type="password" id="password2" name="password2" class="form-control form-control-lg" placeholder="Confirmar Contraseña" required/>
                                            <label class="form-label" for="password2">Confirmar Contraseña</label>
                                        </div>
                                    
                                        <button name="enviar" id="enviar" class="btn btn-outline-light btn-lg px-5" type="submit">Restablecer</button>
                                        
                                    </form> 
                                <?php
                               
                                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                        try{
                                        if(isset($_POST["enviar"])){
                                            if($_POST["password1"] == $_POST["password2"]){
                                            $password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
                                            $update = "UPDATE Usuarios SET clave = '$password' WHERE cod_usuario = $cod_usuario";
                                            echo $update;
                                            $result = $db->query($update);
                                            print "
                                            <script>
                                                window.location = '../index.php';
                                            </script>";
                                            }else{
                                                echo "<p style='color:red; margin-top:10px'>Las contraseñas deben ser identicas</p>";
 
                                            }
                                        }
                                            }catch (PDOException $e) {
                                                echo "<p class='error'><br>Error en la base de datos ".$e->getMessage()."</p>";
                                            }
                                            
                                        
                                    }
                                    
                                ?>                             
                                </div>
                                
                                <div>
                                    <p class="mb-0">¿Ya tiene cuenta? <a href="../index.php" class="text-white-50 fw-bold">Iniciar Sesión</a></p>
                                    <p class="mb-0">¿No tiene cuenta? <a href="registrar.php" class="text-white-50 fw-bold">Registrar</a></p>

                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>

        <!-- Libreria bootstrap -->
        <script src="../js/rolUsuario.js"></script>
        <?php
            include("footer.php");
        ?>
