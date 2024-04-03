<?php
    
    echo'<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand ms-xl-5" href="index.php">II Miniolimpiadas Física y Química</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        </ul>
        <ul class="navbar-nav me-right mb-2 mb-lg-0">

          <li class="nav-item">'?>
            <a class="nav-link  <?php if(str_contains($_SERVER['SCRIPT_NAME'],'organizacionysedes.php')) echo 'active' ?>"  href="organizacionysedes.php">Organización y sedes</a>
          <?php echo '</li>';
            echo'  <li class="nav-item">'?>
            <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'formulario.php')) echo 'active' ?>"  href="formulario.php">Formulario de Inscripción</a>
            <?php echo '</li>
          <li class="nav-item">'?>
          <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'temario.php')) echo 'active' ?>"  href="temario.php">Temario</a>
          <?php echo '</li>';
          echo'  <li class="nav-item">'?>
          <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'prueba.php')) echo 'active' ?>"  href="prueba.php">Prueba</a>
          <?php echo '</li>';
            echo'  <li class="nav-item">'?>
            <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'lugaryfecha.php')) echo 'active' ?>"  href="lugaryfecha.php">Lugar y Fecha</a>
            <?php echo '</li>';
                        echo'  <li class="nav-item">'?>
                        <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'patrocinadores.php')) echo 'active' ?>"  href="patrocinadores.php">Patrocinadores</a>
                        <?php echo '</li>
            </ul> 
          </nav>';
?>