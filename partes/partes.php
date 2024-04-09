<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="../css/principal.css">
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
        <div class="row col-12 m-auto g-4 p-4">

            <div class="card col-7 g-3 m-auto my-4 bg-dark text-light">
                <div class="card-body">
                    <h4 class="card-title text-decoration-underline">Poner Partes</h4>
                    <p class="card-text">Apartado de poner partes</p>
                    <a href="./inserciones/ponerParte.php"><button type="button" class="btn btn-light">Poner Parte</button></a>
                </div>
            </div>
            <div class="card col-7 g-3 m-auto my-4 bg-dark text-light">
                <div class="card-body">
                    <h4 class="card-title text-decoration-underline">Ver Partes</h4>
                    <p class="card-text">Apartado para visualizar los partes que han sido puestos</p>
                    <a href="./inserciones/verParte.php"><button type="button" class="btn btn-light">Ver Partes</button></a>
                </div>
            </div>

        </div>




    </main>
    <footer>
        <?php
        require_once "../archivosComunes/footer.php";
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>