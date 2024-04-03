<?php
require "../../../archivosComunes/conexion.php";

require "../Funciones/anexos.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_FILES["anexo3"])){
        // Obtener los valores del formulario
        $cod_empresa = $_GET["COD_EMPRESA"];
        $cod_usuario = $_GET["COD_USUARIO"];
        $cod_alumno = $_GET["COD_ALUMNO"];
        $ciclo = $_GET["CICLO"];

        try{
            // Obtener el nombre del alumno y el ciclo
            $fila = $db->query("SELECT NOMBRE FROM alumno WHERE COD_ALUMNO = '$cod_alumno'")->fetch();
            $nombre_alumno = $fila["NOMBRE"];

            // Insertar los anexos en la base de datos
            for($i = 0; $i < count($_FILES["anexo3"]["name"]) ; $i++) {

                $rutaArchivo = subirAnexo3($nombre_alumno, $ciclo, $_FILES["anexo3"]["name"][$i], $_FILES["anexo3"]["tmp_name"][$i]);

                if ($rutaArchivo) {
                    $sql = "INSERT INTO anexoiii_pertenece (COD_EMPRESA, COD_USUARIO, COD_ALUMNO, ANEXO_III)
                            VALUES ('$cod_empresa', '$cod_usuario', '$cod_alumno', '$rutaArchivo')";
                    $consulta = $db->query($sql);

                } else {
                    echo "Error al mover el archivo $i a la carpeta del alumno";
                }
            }
        }
        catch(Exception $e){
            echo "Error en la base de datos ".$e->getMessage();
        }
    }
    // Cerrar la conexión
    $db = null;
    header("Location: editarAlumnoAsignado.php?COD_ALUMNO=" . $_GET["COD_ALUMNO"] . "&COD_EMPRESA=" . $_GET["COD_EMPRESA"] . "&CICLO=" . $_GET["CICLO"] . "&COD_USUARIO=" . $_GET["COD_USUARIO"]);
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' href='../../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../../css/custom.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>

    <script type='text/javascript' src='../../js/bootstrap.bundle.min.js' defer></script>
    <title>Añadir Anexos 3</title>
</head>

<body>
    <?php require "../Header-Footer/header.php"; ?>
    <!-- Llamo a la función para mostrar los datos: -->

    <h3>Añadir Anexos 3</h3>

    <form class="pb-5" method="post" action="<?php echo "insertarAnexos.php?COD_ALUMNO=" . $_GET["COD_ALUMNO"] . "&COD_EMPRESA=" . $_GET["COD_EMPRESA"] . "&CICLO=" . $_GET["CICLO"] . "&COD_USUARIO=" . $_GET["COD_USUARIO"]?>"
          enctype="multipart/form-data" class="text-white" style="width: 50%; margin: auto;">
      <label for="cantidad" class="form-label text-white">Cantidad de archivos:</label>
      <input type="number" id="cantidad" name="cantidad" min="1" class="form-control">
      <br><br>
      <div id="archivos"></div>
      <br>
      <button type="submit" class="btn botones-guardar">Subir Anexos</button>
    </form>

    <script>
        window.onload = function() {
                var cantidadInput = document.getElementById('cantidad');
                cantidadInput.addEventListener('input', function() {
                    var cantidad = parseInt(cantidadInput.value);
                    var archivosDiv = document.getElementById('archivos');
                    archivosDiv.innerHTML = ''; 

                    for (var i = 1; i <= cantidad; i++) {
                    var label = document.createElement('label');
                    label.textContent = 'Archivo ' + i + ': ';
                    label.classList.add("text-white");
                    archivosDiv.appendChild(label); 

                    var fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'anexo3[]';
                    fileInput.classList.add("form-control");
                    archivosDiv.appendChild(fileInput);
                    
                    archivosDiv.appendChild(document.createElement('br'));
                }
            });
        };
    </script>

<?php require "../Header-Footer/footer.php"; ?>
</body>
</html>


