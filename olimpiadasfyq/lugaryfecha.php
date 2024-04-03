<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organización y sedes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>
    <script src="../js/multiselect-dropdown.js"></script>

</head>

<body>
    <?php
    include('navegacion.php');
    ?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lugar y fecha</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 0;
            background-color: #f8f8f8;
            text-align:justify;

        }

        header {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        main{
            display:flex;
            flex: row;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
        }
        .negrita{
            font-weight: bold;
        }
        .contenedorimagen{
            margin: 20px auto; 
            width: 450px;
            display:flex;
            justify-content: center;
            align-items: center;
        }
        figure{
                display: flex; 
                justify-content: center
                ;
                flex-direction:column;
         }
        img{
            width: 500px;
            margin: 0 auto;

      
        }

        section {
            margin: auto 20px;
            width: 950px;
        }

        h2 {
            color: #333;
        }
        h1 {
            color: white;
        }

        footer {
            padding: 10px;
            background-color: #333;
            color: #fff;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            align-items: center;
        }
                    /* Estilos para el icono de Instagram */
        .instagram-icon {
            width: 30px; /* Tamaño del icono */
            height: 30px;
            /* Otros estilos, como color, margen, etc. */
        }
        figcaption{
            color: #5072A7;
            font-size:bold;
            text-align:center;
        }
        @media (max-width: 500px) {
            img{
                width: 300px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Lugar y fecha</h1>
    </header>
    <main>
    <article class="contenedorimagen">
    <figure >
    <img src="img/facultaddecienciasambiemtales2.jpg" alt="Facultas de Ciencias Ambientales y Bioquímica"
    title="FACULTAD DE CIENCIAS AMBIENTALES Y BIOQUÍMICA (Toledo)">
    <figcaption></figcaption>
    <figure>

    </article>
    <section>
    <article>
    Las Miniolimpiadas tendrán lugar en Albacete, Cuenca y Toledo. Las fechas y lugares de las jornadas son las siguientes:
    <ul>
            <li><span class="negrita">Toledo</span>: 17 de mayo de 2024. <span class="negrita">
           aula magna del edificio 37</span> del Campus Tecnológico de la Fábrica de Armas de Toledo. <a target="_blank" href="https://iesbargas.es/olimpiadasfyq/index.php">fyqminiolimpiadas de Toledo</a></li>
            <li><span class="negrita">Albacete</span>: 23 de mayo de 2024. <span class="negrita">Escuela Superior de Ingeniería Informática del campus de Albacete</span>. <a target="_blank" href="https://sites.google.com/view/fyqminiolimpiadas/inicio">fyqminiolimpiadas de Albacete</a></li>
            <li><span class="negrita">Cuenca</span>: 23 de mayo de 2024. <span class="negrita">Villanueva de la Jara</span>.</li>
    </ul>
       
  </article>
    </section>

    </main>
    <footer>
        <p>© 2024 MiniOlimpiadas de Física y Química - APFyQ-CLM. Todos los derechos reservados.</p>
        <a href="https://www.instagram.com/miniolimpiadasclm/" target="_blank" rel="noopener noreferrer">
            <img src="img/instagram.png" alt="Instagram" class="instagram-icon">
        </a>
    </footer>
</body>
</html>
</body>
<html>
