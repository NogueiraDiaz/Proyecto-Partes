<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardias</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/multiselect-dropdown.js"></script>
      <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    include('navguardias.php');


    require_once("../archivosComunes/conexion.php");
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    require_once('../archivosComunes/loginRequerido.php');
    // enviar correo
    require_once('../correo/correo.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $fecha = $_POST['fecha'];
        $periodo = $_POST['periodo'];
        $usuario = $_POST['usuario'];
        $observaciones = $_POST['observaciones'];
        // Consultar la tabla de usuario para obtener el nombre basado en el curso
        $query = "SELECT cod_usuario, cod_delphos  FROM Usuarios WHERE cod_usuario = :usuario";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':usuario', $usuario);        
        $stmt->execute();
        $cod_usuario = $stmt->fetchColumn();
        $stmt->execute();
        $cod_delphos = $stmt->fetchColumn(1);
        for ($i = 0; $i < count($periodo); $i++) {
            $insert = "INSERT INTO Guardias (fecha, periodo, cod_usuario,observaciones)
            VALUES (:fecha, :periodo,  :usuario, :observaciones)";
            $stmt = $db->prepare($insert);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':periodo', $periodo[$i]);
            $stmt->bindParam(':usuario', $cod_usuario);
            $stmt->bindParam(':observaciones', $observaciones);
            $lastID = $stmt->execute();
           
        }
        
        // Consultar la tabla de usuario para obtener el nombre y apellidos del usuario
        $query = "SELECT nombre, apellidos FROM Usuarios WHERE cod_usuario = :cod_usuario";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':cod_usuario', $cod_usuario);
        $stmt->execute();
        $nombre = $stmt->fetch();
        $periodosEmail = "";
        if (count($periodo) == 1) {
            // Consultar la tabla de periodos para obtener el periodo del curso
            $query = "SELECT inicio, fin FROM Periodos WHERE cod_periodo = :periodo";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':periodo', $periodo[0]);
            $stmt->execute();
            $rango = $stmt->fetch();
            parse_str("0=" . substr($rango['inicio'], 0, strlen($rango['inicio']) - 3) . " - " . substr($rango['fin'], 0, strlen($rango['fin']) - 3), $output);
            $dia   = substr($fecha,8,2);
            $mes = substr($fecha,5,2);
            $anio = substr($fecha,0,4); 
            $semana = date('w',  mktime(0,0,0,$mes,$dia,$anio)); 
            $semanaGuardia="";
            if($semana == 1){
                $semanaGuardia="Lunes";
              
            }
            else if($semana == 2){
                $semanaGuardia="Martes";

        
            }else   if($semana == 3){
                $semanaGuardia="Miércoles";

        
            }else  if($semana == 4){
                $semanaGuardia="Jueves";

        
            } else   if($semana == 5){
                $semanaGuardia="Viernes";
            }
            $select1 = "SELECT clase
            FROM Horarios
            WHERE (cod_usuario = ? OR cod_delphos = ?) AND inicio = ? AND fin = ? AND  dia = ?;";
    
            $resul1 = $db->prepare($select1);
            //Pasar a traves de un array los valores escritos en el formulario
            //Los valores se recogen por parametros en la función
            $resul1->execute(array( $usuario, $cod_delphos, $rango['inicio'], $rango['fin'],$semanaGuardia ));  
            if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                $periodosEmail .= $output[0] . ": ".$columna1['clase']."<br>";
            }else{
                $periodosEmail .= $output[0] . ": sin periodo lectivo<br>";
   
            }     

        } else {
            for ($i = 0; $i < count($periodo); $i++) {
                $query = "SELECT inicio, fin FROM Periodos WHERE cod_periodo = :periodo";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':periodo', $periodo[$i]);
                $stmt->execute();
                $rango = $stmt->fetch();
                parse_str("0=" . substr($rango['inicio'], 0, strlen($rango['inicio']) - 3) . " - " . substr($rango['fin'], 0, strlen($rango['fin']) - 3), $output);
                $dia   = substr($fecha,8,2);
                $mes = substr($fecha,5,2);
                $anio = substr($fecha,0,4); 
                $semana = date('w',  mktime(0,0,0,$mes,$dia,$anio));  
                $semanaGuardia="";
                if($semana == 1){
                    $semanaGuardia="Lunes";
                }else if($semana == 2){
                    $semanaGuardia="Martes";

                }else if($semana == 3){
                    $semanaGuardia="Miércoles";
                }else if($semana == 4){
                    $semanaGuardia="Jueves";
                }else if($semana == 5){
                    $semanaGuardia="Viernes";

                }
                $select1 = "SELECT clase
                FROM Horarios
                WHERE (cod_usuario = ? OR cod_delphos = ?)  AND inicio = ? AND fin = ? AND  dia = ?;";
        
                $resul1 = $db->prepare($select1);
                //Pasar a traves de un array los valores escritos en el formulario
                //Los valores se recogen por parametros en la función
                $resul1->execute(array( $usuario,$cod_delphos, $rango['inicio'], $rango['fin'], $semanaGuardia));  
                if ($columna1 = $resul1->fetch(PDO::FETCH_ASSOC)) {
                    $periodosEmail .= $output[0] . ": ".$columna1['clase']."<br>";
                }else{
                    $periodosEmail .= $output[0] . ": sin periodo lectivo<br>";
       
                }
            }
            
        
        }


        $cuerpo =
        "
            <h1>Fecha: {$fecha}</h1>
            <h2>El profesor a ser sustituido es: {$nombre['nombre']} {$nombre['apellidos']}</h2>
            <h3>Observaciones del profesor:  {$observaciones}</h3>
            {$periodosEmail}
            ";
    
        // Enviar correo jefatura@iesbargas.com
        enviarcorreo('jefatura@iesbargas.com', "Nueva guardia " . $fecha, $cuerpo);
        // Redirigir a la página de guardias
        header('Location: guardias.php');
        exit();
    }


    ?>
    <div id="formulario" class="mx-auto mt-3" style="width:400px;">

        <!-- PHP_SELF para enviar al mismo archivo -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <div class="form-floating mb-3">
                    <input type="date" name="fecha" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Fecha</label>
                </div>
            </div>

            <label for="periodo">Periodo:</label>

            <div class="mb-3">
                <div class="form-floating mb-3">
                    <!-- creamos un select -->
                    <select class="form-control" name="periodo[]" id="periodo" required multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" onchange="console.log(this.selectedOptions)">
                        <?php
                        $select = "SELECT cod_periodo, inicio, fin FROM Periodos";
                        $resul = $db->query($select);

                        while ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $columna['cod_periodo'] . "'>" . substr($columna['inicio'], 0, strlen($columna['inicio']) - 3) . " - " . substr($columna['fin'], 0, strlen($columna['fin']) - 3) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <div class="form-floating mb-3">
                        <?php
                        if ($_SESSION['usuario_login']['rol'] == "1") {

                            echo '<input type="text" name="usuario" class="form-control" id="floatingInput" value=' . $_SESSION['usuario_login']['cod_usuario'] . ' hidden required>
                                    ';
                        } else if ($_SESSION['usuario_login']['rol'] == "0") {
                            $select = "SELECT cod_usuario, nombre, apellidos FROM Usuarios ORDER BY nombre, apellidos";
                            $resul = $db->query($select);
                            echo '<select class="form-control" name="usuario" id="floatingInput" >';
                            while ($columna = $resul->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $columna['cod_usuario'] . "'>" . $columna['nombre'] . " " . $columna['apellidos'] . "</option>";
                            }
                            echo '</select>
                    <label for="floatingInput">Usuario</label>';
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones</label>
                        <textarea name="observaciones" cols="50" rows="10"></textarea>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Guardar</button>

        </form>
    </div>
    </div>
    <?php
        include('../archivosComunes/footer.php');
    ?>