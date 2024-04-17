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
    include ('./archivosComunes/navPartes.php');
    require_once ("../archivosComunes/conexion.php");
    require_once ('../archivosComunes/loginRequerido.php');
    if ($_SESSION['usuario_login']['rol'] != "0") {
        print "
        <script>
          window.location = 'partes.php';
        </script>";}
    // Para acceder a esta pagina hay que iniciar sesion previamente.
    if (isset($_GET['matricula'])) {
        $select = "SELECT matricula, nombre, apellidos, grupo
    FROM Alumnos
    WHERE matricula = '" . $_GET['matricula'] . "';";
        $resul = $db->query($select);
        $columna = $resul->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <div id="formulario" class="mx-auto mt-3 mb-5" style="width:400px; height:300px;">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php if ($_SESSION["usuario_login"]["rol"] == 0) {
                if (isset($columna['matricula'])) {

                    echo "<input type='text' class='form-control' name='matriculaAntigua' id='matriculaAntigua' value='" . $columna['matricula'] . "' hidden>";

                    echo "<div class='form-group form-floating mb-3'>";
                    echo "<input type='text' class='form-control' name='matricula' id='matricula' value='" . $columna['matricula'] . "' >";

                    echo "<label for='matricula'>Matricula:</label>";
                    echo "</div>";
                } else {
                    echo "<input type='text' class='form-control' name='matriculaAntigua' id='matriculaAntigua'  hidden>";

                    echo "<div class='form-group form-floating mb-3'>";
                    echo "<input type='text' class='form-control' name='matricula' id='matricula'  >";

                    echo "<label for='matricula'>Matricula:</label>";
                    echo "</div>";
                }
                if (isset($columna['nombre'])) {
                    echo "<div class='form-group form-floating mb-3'>";
                    echo "<input type='text' class='form-control' name='nombre' id='nombre' value='" . $columna['nombre'] . "' >";

                    echo "<label for='nombre'>nombre:</label>";
                    echo "</div>";
                } else {
                    echo "<div class='form-group form-floating mb-3'>";
                    echo "<input type='text' class='form-control' name='nombre' id='nombre' >";

                    echo "<label for='nombre'>nombre:</label>";
                    echo "</div>";
                }
                if (isset($columna['apellidos'])) {

                    echo "<div class='form-group form-floating mb-3'>";
                    echo "<input type='text' class='form-control' name='apellidos' id='apellidos'   value='" . $columna['apellidos'] . "'>";

                    echo "<label for='apellidos'>Apellidos:</label>";
                    echo "</div>";
                    echo "<div class='form-group form-floating mb-3'>";
                } else {
                    echo "<div class='form-group form-floating mb-3'>";
                    echo "<input type='text' class='form-control' name='apellidos' id='apellidos'  >";

                    echo "<label for='apellidos'>Apellidos:</label>";
                    echo "</div>";
                    echo "<div class='form-group form-floating mb-3'>";
                }
                if (isset($columna['grupo'])) {

                    echo "<select class='form-control' name='grupo' id='grupo' >";
                    $select = "SELECT grupo FROM Cursos";
                    $resul = $db->query($select);

                    while ($columna1 = $resul->fetch(PDO::FETCH_ASSOC)) {
                        // si tienen el mismo nombre que lo marque como selected y asi aparece como valor principal 
            

                        if ($columna1['grupo'] == $columna['grupo']) {

                            echo "<option value='" . $columna1['grupo'] . "' selected>" . $columna1['grupo'] . "</option>";

                        } else {
                            echo "<option value='" . $columna1['grupo'] . "'>" . $columna1['grupo'] . "</option>";
                        }
                    }
                    ?>
                    </select>
                    <label for="grupo">Grupo:</label>
                    <?php echo "</div>";
                } else {
                }
            } ?>

            <input type="submit" name="guardar" class="btn btn-primary mt-2" value="Guardar cambios">
        </form>
    </div>

    <?php
    // Procesar formulario al enviar
    if (isset($_POST['guardar'])) {
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $grupo = $_POST['grupo'];
        $matriculaAntigua = $_POST['matriculaAntigua'];



        // Actualizar la tabla guardias con la información obtenida
        $stmt = $db->prepare("UPDATE Alumnos SET matricula=?, nombre=?, apellidos=?, grupo=? WHERE matricula = ?");
        $stmt->execute([$matricula, $nombre, $apellidos, $grupo, $matriculaAntigua]);
        print "
        <script>
          window.location = 'gestionaralumnos.php';
        </script>";}
    
    ?>
    <?php
    include ('./archivosComunes/footerPartes.php');
    ?>