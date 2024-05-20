<!doctype html>
<html lang="en">

<head>
    <title>Detalles de la Expulsión</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        .card-rounded {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <header>
        <?php
            require_once "./archivosComunes/navPartes.php";
        ?>
    </header>
    <main class="p-4 col-11 m-auto">
        <div class=" m-2">
        <?php
            // Incluir el archivo de conexión a la base de datos
            require_once "../archivosComunes/conexion.php";

            // Verificar si se proporcionó el parámetro cod_expulsion en la URL
            if(isset($_GET['cod_expulsion'])) {
                // Obtener el valor del parámetro cod_expulsion
                $cod_expulsion = $_GET['cod_expulsion'];
                
                // Preparar la consulta para obtener los detalles de la expulsión
                $consulta = $db->prepare("SELECT * FROM Expulsiones WHERE cod_expulsion = :cod_expulsion");
                $consulta->bindParam(":cod_expulsion", $cod_expulsion, PDO::PARAM_INT);
                $consulta->execute();
                
                // Obtener los detalles de la expulsión
                $expulsion = $consulta->fetch(PDO::FETCH_ASSOC);
                
                // Verificar si se encontró la expulsión
                if($expulsion) {
                    // Mostrar los detalles de la expulsión en una card de Bootstrap
                    echo "<div class='card card-rounded'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title mb-5 text-decoration-underline'>Detalles de la Expulsión</h5>";
                    echo "<p class='card-text'>Fecha de Inicio: " . $expulsion['fecha_Inicio'] . "</p>";
                    // Agrega aquí el resto de los campos de la tabla Expulsiones según sea necesario
                    echo "</div>";
                    echo "</div>";
                } else {
                    // Mostrar un mensaje si la expulsión no fue encontrada
                    echo '<h3 class="text-black rounded bg-light p-2 px-3">No se encontró la expulsión</h3>';
                }
            } else {
                // Mostrar un mensaje si no se proporcionó el parámetro cod_expulsion
                echo "<p>No se proporcionó el parámetro cod_expulsion en la URL.</p>";
            }

            // Cerrar la conexión a la base de datos
            $db = null;
        ?>
        </div>
    </main>
    <footer>
        <?php
            require_once "./archivosComunes/footerPartes.php";
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
