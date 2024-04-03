<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Refresh" content="60;url=guardiaspantalla.php">
    <title>Guardias</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>

  <style>

      .legend {
        display: flex;
        justify-content: center;
        margin: 4px 0 4px 0;
      }

    .legend span {
      display: flex;
      align-items: center;
      margin-right: 5px;
      font-size: 10px;
      font-Weight:bold;
    }

    .legend span.actual {
      width: 15px;
      height: 15px;
      background-color: #008f39;
      border-radius: 50%;

    }

    .legend span.siguiente {
      width: 15px;
      height: 15px;
      background-color: #b8daba;
      border-radius: 50%;
    }

    .legend span.primero {
      width: 15px;
      height: 15px;
      background-color: #00008B;
      border-radius: 50%;
      border: 1px solid black;
    }

    .legend span.segundo {
      width: 15px;
      height: 15px;
      background-color: #1E90FF;
      border-radius: 50%;
    }

    .legend span.tercero{
      width: 15px;
      height: 15px;
      background-color: #00BFFF;
      border-radius: 50%;
    }
    .legend span.cuarto{
      width: 15px;
      height: 15px;
      background-color: #87CEFA;
      border-radius: 50%;
    }
    .legend span.quinto{
      width: 15px;
      height: 15px;
      background-color: #ADD8E6;
      border-radius: 50%;
    }
    .legend span.sexto{
      width: 15px;
      height: 15px;
      background-color: #F0F8FF;
      border-radius: 50%;
    }
    #contenidoTabla{
      font-size: 14px;
    }
    hr{
      margin: 0;
      padding: 0;
    }
</style>
  </head>
<body class="m-auto">

  <?php
    session_start();

 echo'<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none d-lg-block">
 <div class="container-fluid">
 <a class="navbar-brand" href="guardias.php">Guardias</a>
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
     <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse  text-center" id="navbarSupportedContent">
   <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link"  href="agregarguardias.php">Agregar</a>
      </li>
   </ul>
   <ul class="navbar-nav me-right mb-2 mb-lg-0">
   <li class="nav-item">

         <a class="nav-link "  href="../archivosComunes/logout.php">Cerrar Sesion</a>
         </li>
         </ul> 
         </div>
         </div>
       </nav>';
       include("../guardias/leyenda.php")
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" onchange='submit();'>

</form>
    <table class="table  table-bordered table-hover text-center align-middle" id="contenidoTabla">
  <thead>
    <tr>
      <th scope="col" class="col-md-1">Fecha</th>
      <th scope="col" class="col-md-1">Periodo</th>
      <th scope="col" class="col-md-2">Clase</th>
      <th scope="col" class="col-md-2">Profesor</th>
      <th scope="col" class="col-md-6">Observaciones</th>

  
    </tr>
  </thead>
  <tbody>
    <?php

        include("../guardias/horapantalla.php");
     
      ?>
  </tbody>
</table>

<?php
        include('../archivosComunes/footer.php');
        ?>