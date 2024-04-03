<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>

    <style>
        .disabled {
            pointer-events: none;
            opacity: 0.7;
            border-color: rgba(118, 118, 118, 0.3);
            color: -internal-light-dark(gray, rgb(170, 170, 170));
            background: #dddddd;
        }
</style>
</head>
<body>
    
<?php
include('navguardias.php');
require_once("../archivosComunes/conexion.php");
// Para acceder a esta pagina hay que iniciar sesion previamente.
require_once('../archivosComunes/loginRequerido.php');
if(isset($_GET['cod_guardias'])){
    $select = "SELECT cod_guardias, observaciones, fecha, Guardias.cod_usuario,
    Usuarios.nombre AS usuario, Periodos.inicio AS periodoinicio, Periodos.fin AS periodofin
    FROM Guardias
    JOIN Periodos ON Guardias.periodo = Periodos.cod_periodo
    JOIN Usuarios ON Guardias.cod_usuario = Usuarios.cod_usuario
    WHERE cod_guardias = ".$_GET['cod_guardias'].";";
    $resul = $db->query($select);
    $columna = $resul->fetch(PDO::FETCH_ASSOC);
}
?>

<div id="formulario" class="mx-auto mt-3" style="width:400px; height:300px;">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="cod_guardias" value="<?php  if(isset($_GET['cod_guardias'])) echo   $_GET['cod_guardias']; ?>">
        <?php if($_SESSION["usuario_login"]["rol"]==0){

            echo "<div class='form-group form-floating mb-3'>";
            if(isset($columna['fecha'])){
                echo "<input type='date' class='form-control' name='fecha' id='fecha' value='".$columna['fecha']."' >";
            }else{
                echo "<input type='date' class='form-control' name='fecha' id='fecha'  >";
  
            }
            echo "<label for='fecha'>Fecha:</label>";
            echo "</div>";
         }else{
            echo "<div class='form-group form-floating mb-3'>";
            if(isset($columna['fecha'])){
                echo "<input type='date' class='form-control' name='fecha' id='fecha' value='".$columna['fecha']."' readonly >";
            }else{
                echo "<input type='date' class='form-control' name='fecha' id='fecha' readonly >";
  
            }
            echo "<label for='fecha'>Fecha:</label>";
            echo "</div>";
        }?>
        <div class="form-group form-floating mb-3">
            <!-- creamos un select -->
            <?php if($_SESSION["usuario_login"]["rol"]==0){
               echo "<select class='form-control' name='periodo' id='periodo' >";
            }else{
                echo "<select class='form-control disabled' name='periodo' id='periodo' >";

                }
               
                $select = "SELECT cod_periodo, inicio, fin FROM Periodos";
                $resul = $db->query($select);
                
                while ($columna1 = $resul->fetch(PDO::FETCH_ASSOC)) {
                    // si tienen el mismo nombre que lo marque como selected y asi aparece como valor principal 
                  

                    if ($columna1['inicio'] == $columna['periodoinicio']) {
                        
                        echo "<option value='".$columna1['cod_periodo']."' selected>".substr($columna1['inicio'], 0, strlen($columna1['inicio']) - 3)." - ".substr($columna1['fin'], 0, strlen($columna1['fin']) - 3)."</option>";

                    } else {
                        echo "<option value='".$columna1['cod_periodo']."'>".substr($columna1['inicio'], 0, strlen($columna1['inicio']) - 3)." - ".substr($columna1['fin'], 0, strlen($columna1['fin']) - 3)."</option>";
                    }
                }
                ?>
            </select>
            <label for="periodo">Periodo:</label>
        </div>

        <div class="mb-3">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Observaciones</label>
                        <textarea name="observaciones" cols="50" rows="10"><?php echo $columna['observaciones'] ?></textarea>
                    </div>
                </div>
        <input type="submit" name="guardar" class="btn btn-primary mt-2" value="Guardar cambios">
    </form>
</div>

<?php
// Procesar formulario al enviar
if(isset($_POST['guardar'])) {
    $id = $_POST['cod_guardias'];
    $fecha = $_POST['fecha'];
    $periodo = $_POST['periodo'];
    $observaciones = $_POST['observaciones'];
    
   
    
    // Actualizar la tabla guardias con la información obtenida
    $stmt = $db->prepare("UPDATE Guardias SET fecha=?, periodo=?, observaciones=? WHERE cod_guardias = ?");
    $stmt->execute([$fecha, $periodo,  $observaciones, $id]);
    print "
    <script>
      window.location = 'guardias.php';
    </script>";}
?>
    <?php
        include('../archivosComunes/footer.php');
        ?>