<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <?php
        require_once "archivosComunes/navPartes.php";
        ?>
    </header>
    <main>
        <div class="container mt-5 g-3" style="max-width: 500px;">
            <h2 class="text-decoration-underline mb-5">Importar Alumnos </h2>
            <p class="mb-5"> Seleccione un archivo de hoja de calculo para importar los alumnos</p>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3 g-3">
                    <label for="archivo" class="form-label">Seleccionar archivo:</label>
                    <input type="file" class="form-control" id="archivo" name="archivo[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary ">Importar</button>
            </form>
        </div>
        <div class="container my-5 py-2" style="max-width: 500px;">
            <!-- PHP_SELF para enviar al mismo archivo -->
            <form method="POST" action="borrarhorarios.php">
                <label for="archivo" class="form-label">Eliminar todos los alumnos importados:</label>

                <button type="submit" class="btn btn-primary ms-4 ">Eliminar alumnos</button>

            </form>

        </div>

    </main>
    <footer>
        <?php
        require_once "./archivosComunes/footerPartes.php";
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>