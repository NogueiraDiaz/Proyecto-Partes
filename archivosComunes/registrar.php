<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ICONO DE LA PESTAÑA DEL NAVEGADOR -->
    <link rel="shortcut icon" href="../img/icono.png">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <title>Registro</title>
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
                                <h2 class="fw-bold mb-4 text-uppercase">REGISTRARSE</h2>
                                <form method="post">
                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="text" id="dni" name="dni" class="form-control form-control-lg" placeholder="DNI" required/>
                                        <label class="form-label" for="dni">DNI</label>
                                    </div>
                    
                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="text" id="nombre" name="nombre" class="form-control form-control-lg" placeholder="Nombre" required/>
                                        <label class="form-label" for="nombre">NOMBRE</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="text" id="apellidos" name="apellidos" class="form-control form-control-lg" placeholder="Apellidos" required/>
                                        <label class="form-label" for="apellidos">APELLIDOS</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="EMAIL" required/>
                                        <label class="form-label" for="email">EMAIL</label>
                                    </div>

                                    <div class="form-floating form-white mb-4 text-dark">
                                        <input type="password" id="clave" name="clave" class="form-control form-control-lg" placeholder="Contraseña" required/>
                                        <label class="form-label" for="clave">CONTRASEÑA</label>
                                    </div>
                                   
                                    <div class="form-floating form-white mb-4 text-white">
                                    <input type="radio" id="profesorRadio" name="personal" value="PROFESOR" checked>PROFESOR
                                    <input type="radio" id="personalRadio" name="personal" value="MANTENIMIENTO" class="mb-3">MANTENIMIENTO
                                    <input type="radio" id="conserjeRadio" name="personal" value="CONSERJE">CONSERJE<br><br>

                                    <div class="form-floating form-white mb-4 text-dark" id="delphos">
                                        <input type="number"  name="delphos" class="form-control form-control-lg" placeholder="Delphos"/>
                                        <label class="form-label" id="delphosLabel" for="delphos">CÓDIGO DELPHOS</label>
                                    </div>   

                                    <div class="selectPersonal form-floating form-white mb-2 text-dark" >
                                        <select name="selectPersonal" id="selectPersonal" class="selectPersonal form-control form-control-lg">
                                            <option name="dpto_no_valido" id="dpto_no_valido">- Seleccione su departamento -</option>
                                            
                                            <?php
                                                $db = require_once('conexion.php');

                                                    $select = "SELECT codigo, nombre
                                                    FROM Departamentos";
                                            
                                                $resul = $db->query($select);

                                                    // Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
                                                    while ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value='.$columna['codigo'].'>'.$columna['nombre'].'</option>';

                                                    }

                                                    $select = "SELECT grupo
                                                    FROM Cursos";
                                            
                                                $resul = $db->query($select);

                                                    // Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
                                                   
                                            ?>
                                            
                                        </select>
                                        <label class="form-label" id="selectPersonalLabel" for="selectPersonal">DEPARTAMENTO</label>
                                    </div>
                                        <div class="selectPersonal form-floating form-white mb-2 text-dark" >
                                        <select name="tutor" id="tutor" class="selectPersonal form-control form-control-lg">
                            
                                           
                                            <option value="No." selected>Sólo si eres tutor. Si no eres tutor NO selecciones nada</option>
                                            <?php
                                                while ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value='.$columna['grupo'].'>'.$columna['grupo'].'</option>';

                                                }
                                            ?>
                                        </select>
                                        <label class="form-label" id="tutorLabel" for="tutor">Tutor</label>

                                    </div>

                                    <button name="enviar" id="enviar" class="btn btn-outline-light btn-lg px-5" type="submit">Registrar</button>
                                    
                                </form> 
                            <?php
                            $insert2="";
                                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                    
                                    if(isset($_POST["enviar"])){
                                        $rol = null;
                                        try {
                                            //$db = require_once('conexion.php');
                                            $rol = null;
                                            if($_POST['personal'] == 'PROFESOR'){
                                                $rol = 1;
                                            } else if($_POST['personal'] == 'MANTENIMIENTO'){
                                                $rol = 2;
                                            } else if($_POST['personal'] == 'CONSERJE'){
                                                $rol = 3;
                                            } else {
                                                $rol = 0;
                                            }

                                            
                                            if($rol == 1 && $_POST["selectPersonal"] == "- Seleccione su departamento -"){
                                                echo "Seleccione su departamento";
                                            } else {
                                                if($rol == 2 || $rol == 3){
                                                     

                                                     $select = "SELECT count(*) AS contador FROM Usuarios WHERE rol = $rol";
                                            
                                                     $resul = $db->query($select);
 
                                                     // Utilizamos un bucle while para recorrer todas las filas que devuelve la consulta
                                                     if ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
                                                         if($columna['contador']>0 && $rol=='2'){
                                                             echo "<br><p class='error'>No se pueden registrar más usuarios de mantenimiento<p>";
                                                         }else if($columna['contador']>2 && $rol=='3'){
                                                             echo "<br><p class='error'>No se pueden registrar más usuarios de conserjería<p>";
                                                         }else if(($columna['contador']==0 && $rol=='2')||($columna['contador']<3 && $rol=='3')){
                                                            
                                                            $insert = 'insert into Usuarios(dni,nombre, apellidos, email, clave, rol, validar)
                                                            values(?,?,?,?,?,?,?);';
                                                            $insert2 = $db->prepare($insert);
                                                            $insert2->execute(array($_POST['dni'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], password_hash($_POST['clave'], PASSWORD_DEFAULT), $rol, 'no'));
                                         
                                                         }
                                                     }
                                                           } else {
                                                   
                                                    $insert = 'insert into Usuarios(dni,nombre, apellidos, email, clave, cod_delphos, rol, validar, departamento, tutor_grupo)
                                                            values(?,?,?,?,?,?,?,?,?,?);';
                                                    $insert2 = $db->prepare($insert);
                                                    $insert2->execute(array($_POST['dni'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], password_hash($_POST['clave'], PASSWORD_DEFAULT),$_POST['delphos'], $rol, 'no', $_POST['selectPersonal'], $_POST['tutor']));
                                                }

                                            
                                                if($insert2){
                                                    //require_once("email.php");
                                                    require_once('../correo/correo.php');
                                                    $rolEmail="";
                                                    if($rol==1){
                                                        $rolEmail="Profesor";
                                                    }else if($rol==2){
                                                        $rolEmail="Mantenimiento";
                                                    }else if($rol==3){
                                                            $rolEmail="Conserje";
                                                        }
                                                    
                                                    $cuerpo =
                                                    "Un nuevo usuario ha sido registrado, por favor acceda a la aplicación para validarlo. Los datos son los siguientes:
                                                    <ul>
                                                        <li>Nombre: {$_POST['nombre']}</li>
                                                        <li>Apellidos: {$_POST['apellidos']}</li>
                                                        <li>Email: {$_POST['email']}</li>
                                                        <li>DNI: {$_POST['dni']}</li>
                                                        <li>Clave Delphos: {$_POST['delphos']}</li>
                                                        <li>Rol: {$rolEmail}</li>
                                                        <li>Tutor: {$_POST['tutor']}</li>
                                                    <ul>
                                                   
                                                        ";
                                                
                                                    // Enviar correo incidenciasiesbargas@gmail.com
                                                    enviarcorreo('incidenciasiesbargas@gmail.com', "Nuevo usuario registrado", $cuerpo);
                                                     print "
                                                     <script>
                                                         window.location = '../index.php';
                                                     </script>";

                                                }
                                                
                                            }
                                            
                                        }catch (PDOException $e) {
                                            echo "<p class='error'><br>Error en la base de datos ".$e->getMessage()."</p>";
                                        }
                                        
                                    }
                                }
                            ?>                             
                            </div>
                            
                            <div>
                                <p class="mb-0">¿Ya tiene cuenta? <a href="../index.php" class="text-white-50 fw-bold">Iniciar Sesión</a></p>
                                <p class="mb-0">¿Has olvidado tu contraseña? <a href="recuperar.php" class="text-white-50 fw-bold">Recuperar</a></p>

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
