<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temario</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>
    <script src="../js/multiselect-dropdown.js"></script>
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

        section {
            margin: 20px 50px;
            display:flex;
            flex: row;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            justify-content: space-around;

        }

   
        h1{
            color: white;
        }

         h2 {
            color: #333;
        }

        ol{
            font-size: 14px;
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
        </style>
</head>

<body>
    <?php
    include('navegacion.php');
    ?>
     <header>
        <h1>Temario de la MiniOlimpiada de Física y Química</h1>
    </header>

    <section>
    <div>
    <h2>QUÍMICA<h2>

    <ol>
    <li>El método científico.</li>
    <li>Sistemas materiales y estados de agregación.</li>
    <li>Mezclas, sustancias puras.</li>
    <li>Elementos y compuestos.</li>
    <li>Modelos atómicos.</li>
    <li>Sistema periódico y uniones entre átomos.</li>
    <li>Las fórmulas químicas y su significado.</li>
    <li>Reacciones químicas: masa y volumen.</li>
    <li>Reacciones químicas: energía y velocidad. </li>
    <li>Importancia de las reacciones químicas y de sus aplicaciones: química y sociedad.</li>
    <li>El laboratorio de química.</li>
</ol>
    </div>
<div>
<h2>FÍSICA</h2>
<ol>
<li>cinemática.</li>
<li>Dinámica.</li>
<li>Trabajo, calor y energía.</li>
</ol>
    </div>
</section>

    <footer>
        <p>© 2024 MiniOlimpiadas de Física y Química - APFyQ-CLM. Todos los derechos reservados.</p>
        <a href="https://www.instagram.com/miniolimpiadasclm/" target="_blank" rel="noopener noreferrer">
            <img src="img/instagram.png" alt="Instagram" class="instagram-icon">
        </a>
    </footer>
</body>
<html>
