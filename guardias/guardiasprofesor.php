<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardias</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>

</head>
<body>
    <?php
        include('navguardias.php');
    ?>
    <table class="table  table-bordered table-striped text-center ">
  <thead>
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Periodo</th>
      <th scope="col">Clase</th>
      <th scope="col">Profesor</th>
      <th scope="col">Observaciones</th>
      <th scope="col">Editar</th>
      <?php if ($_SESSION['usuario_login']['rol'] == "0") {
      echo '<th scope="col">Borrar</th>';
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
        include("../guardias/listaguardiasprofesores.php");
      
    
      ?>
  </tbody>
</table>

<script>
  function editarGuardia(cod_guardias) {
    var url = "editandoguardia.php?cod_guardias=" + cod_guardias;
      window.location.href = url;
  }
  
  function eliminarGuardia(codguardia){
    if (confirm("¿Está seguro de que desea borrar esta guardia?")) {
      var url = "borrarguardias.php?cod_guardias=" + codguardia;
      window.location.href = url;
    }
  }

</script>
<?php
        include('../archivosComunes/footer.php');
        ?>