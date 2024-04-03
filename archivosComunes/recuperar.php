    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ICONO DE LA PESTAÑA DEL NAVEGADOR -->
        <link rel="shortcut icon" href="../img/icono.png">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <title>Recuperar</title>
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
    <body class="gradient-custom">
        
        <section>
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mt-md-2 pb-4">
                                    <h2 class="fw-bold mb-4 text-uppercase">Recuperar Contraseña</h2>
                                    <form method="post">
                                    
                                        <div class="form-floating form-white mb-4 text-dark">
                                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="EMAIL" required/>
                                            <label class="form-label" for="email">EMAIL</label>
                                        </div>

                                    
                                        <button name="enviar" id="enviar" class="btn btn-outline-light btn-lg px-5" type="submit">Recuperar</button>
                                        
                                    </form> 
                                <?php
                                $insert2="";
                                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                        try{
                                        if(isset($_POST["enviar"])){
                                            $db = require_once('conexion.php');
                                            $email = $_POST['email'];
                                            $select = "SELECT nombre, apellidos, email FROM Usuarios WHERE email = '$email'";
                                                
                                            $resul = $db->query($select);

                                            // Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
                                            if ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {

                                                        require_once("../correo/correo.php");
                                                        $cuerpo =
                                                        "Si desea restablecer la contraseña del usuario {$columna['nombre']} {$columna['apellidos']},
                                                        pulse en el siguiente enlace: <a href='https://iesbargas.es/archivosComunes/restablecerPassword.php?usuario=".password_hash($email, PASSWORD_DEFAULT)."'>Restablecer contraseña</a>";
                                                        
                                                        // Enviar correo incidenciasiesbargas@gmail.com
                                                        enviarcorreo($email, "Restablecer Contraseña", $cuerpo);

                                                        /*print "
                                                        <script>
                                                            window.location = '../index.php';
                                                        </script>";*/

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
