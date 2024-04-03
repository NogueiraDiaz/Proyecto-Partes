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
    <title>Patrocinadores</title>
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
            flex-direction: column ;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
        }
        .negrita{
            font-weight: bold;
        }
        .contenedorimagen{
            margin: 50px auto; 
            width: 100%;
            display:flex;
            justify-content: center;
            flex-direction: row;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            gap:10px;
        }

        figure{
                display: flex; 
                justify-content: center;
                flex-direction:column;
                width: 450px;
                margin

         }
        img{
            width: 450px;
            margin: 0 auto;

      
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

    </style>
</head>
<body>
    <header>
        <h1>Patrocinadores</h1>
        <p>¿Quieres colaborar? Ponte en contacto con nosotros a través del correo <a target="_blank" href="mailto:miniolimpiadasfqtoledo@gmail.com"></a><p>
    </header>
    <main>
    <article class="contenedorimagen">
    <figure>
    <img src="img/casio.png" alt="Casio"
    title="Casio">
    <figcaption>Casio</figcaption>
    </figure>    
    <figure>
    <img src="img/soliss.png" alt="Soliss"
    title="Soliss">
    <figcaption>Soliss</figcaption>
    </figure>   
    <figure>
    <img src="img/anaya.jpeg" alt="Anaya"
    title="Anaya">
    <figcaption>Anaya</figcaption>
    </figure>
    <figure>
    <img src="img/servier.png" alt="Servier moved by you"
    title="Servier moved by you">
    <figcaption>Servier moved by you</figcaption>
    </figure>
    <figure>
    <img src="img/stclm.png" alt="Sección Territorial de Castilla-La Mancha"
    title="Sección Territorial de Castilla-La Mancha">
    <figcaption>Sección Territorial de Castilla-La Mancha</figcaption>
    </figure>
    <figure>
    <img src="img/cocacola.jpeg" alt="Coca Cola"
    title="Coca Cola">
    <figcaption>Coca Cola</figcaption>
    </figure>
    <figure>
    <img src="img/alcaliber.png" alt="Alcaliber"
    title="Alcaliber">
    <figcaption>Alcaliber</figcaption>
    </figure>
    </article>
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
