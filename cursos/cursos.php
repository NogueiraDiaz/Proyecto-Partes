<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clase</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d7bc41fc30.js" crossorigin="anonymous"></script>

    <style>
      .aniadirdiv{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        width: 200px;
        height: 200px;
        border: 1px solid black;
        text-align:center;
        background-color: black;
        color:white ;
        display: none;
      }
      @media (max-width: 600px) {
      .guardarcurso, .guardaraula{
        width: 90%;
      }
    }
    </style>
</head>
<body >
  <?php
      include('nav.php');
  ?>
  <div style="  position: fixed; bottom: 20px; right: 20px;">
    <a href="#" onclick="aniadir();"><i class="fa-solid fa-address-book fa-2xl"></i></a>
  </div>
<table class="table table-bordered table-striped table-hover text-center">
  <thead>
    <tr>
      <th scope="col">Grupo</th>
      <th scope="col">Aula</th>
      <th scope="col">Editar</th>
      <th scope="col">Borrar</th>
    </tr>
  </thead>
  <tbody>
<?php
include("mostarcursos.php");
?>
  </tbody>
</table>

<script>
function editar(grupo){
  // si ya existe uno guardandose no deje guardar otro a la vez
  if(document.querySelector('.fa-solid.fa-floppy-disk') == null){
    var tdaula=document.getElementById("aula"+grupo);
    var tdgrupo=document.getElementById("grupo"+grupo);
    var tdgrupoA=document.getElementById("grupoA"+grupo);
    var grupoA = tdgrupoA.textContent;
    const inputaula = document.createElement('input');
    inputaula.value = tdaula.textContent;
    inputaula.className="guardaraula";
    tdaula.innerHTML = '';
    tdaula.appendChild(inputaula);

    const inputgrupo = document.createElement('input');
    inputgrupo.value = tdgrupo.textContent;
    inputgrupo.className="guardarcurso";
    tdgrupo.innerHTML = '';
    tdgrupo.appendChild(inputgrupo);

    // agregar un botón "Guardar" al lado del nuevo input
    var tdeditar=document.getElementById("editar"+grupo);
  
      tdeditar.className = "fa-solid fa-floppy-disk";
      
      var guardarconf = document.querySelector(".fa-floppy-disk");
      
      guardarconf.addEventListener("click", function() {
        var guardaraula = document.querySelector(".guardaraula").value;
        var guardarcurso = document.querySelector(".guardarcurso").value;
        if(guardaraula != "" && guardarcurso != ""){
          var url = "editarcursos.php?grupo=" + guardarcurso+"&aula=" + guardaraula+"&grupoA=" + grupoA;
          window.location.href = url;
        }
      })
    }
}

    
    function borrar(grupo){
    if (confirm("¿Está seguro de que desea borrar el curso "+grupo+" ?")) {
      var url = "borrarcursos.php?grupo=" + grupo;
      window.location.href = url;
    }
  }

  function aniadir(){

    var div = document.querySelector(".aniadirdiv");
    if(div.style.display == "none"){
      div.style.display = "block";
    }else if(div.style.display == ""){
      div.style.display = "block";

    }else{
      div.style.display = "none";

    }

  }

  function insertar(){
    var nuevoaula = document.querySelector(".nuevoaula").value;
    var nuevocurso = document.querySelector(".nuevocurso").value;
    if (nuevoaula != "" && nuevocurso != "") {
      var url = "aniadircursos.php?aula=" + nuevoaula+"&grupo=" + nuevocurso;
      window.location.href = url;
      }
  }
</script>

<div class="aniadirdiv">
  <label for="">Introducir aula</label>
  <input class="nuevoaula" type="text">
  <label for="">Introducir curso</label>
  <input class="nuevocurso" type="text"><br><br>
  <input type="button" value="Guardar" onclick="insertar()">
</div>

<?php
  include('../archivosComunes/footer.php');
?>