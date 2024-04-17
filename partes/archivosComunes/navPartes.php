<?php
  session_start();
    
    echo'<nav class="col-12 navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container-fluid">
    <a class="navbar-brand ms-xl-5" href="partes.php">Partes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse  text-center" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item ms-lg-4">'?>
            <a class="nav-link  <?php if(str_contains($_SERVER['SCRIPT_NAME'],'ponerParte.php')) echo 'active' ?>"  href="ponerParte.php">Poner Parte</a>
          <?php echo '</li>';
          echo'  <li class="nav-item">'?>
          <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'verPartes.php')) echo 'active' ?>"  href="verPartes.php">Ver Partes</a>
          <?php echo '</li>';
          
          if ($_SESSION['usuario_login']['rol'] == "0") {
            
             echo '<li class="nav-item">'?>
          <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'verExpulsiones.php')) echo 'active' ?>"  href="verExpulsiones.php">Ver Expulsiones</a>
          <?php echo '</li>';

          echo '<li class="nav-item">'?>
          <a class="nav-link   <?php if(str_contains($_SERVER['SCRIPT_NAME'],'gestionarAlumnos.php')) echo 'active' ?>"  href="gestionarAlumnos.php">Gestionar Alumnos</a>
          <?php echo '</li>';
          
          }
        echo '</ul>       
         <ul class="navbar-nav me-right mb-2 mb-lg-0">
         <li class="nav-item">
         <a class="text-light btn btn-outline-secondary me-2" href="../archivosComunes/actualizarUsuario.php?idusuario='.$_SESSION['usuario_login']['cod_usuario'].'">
         <span class="d-flex">
             <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
             </svg>&nbsp;
             '.$_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos'].'
         </span>                 
     </a>
     </li> 
         <li class="nav-item">
        <a class="nav-link"  href="../archivosComunes/selector.php"><span class="salir">Página Principal</span> <i class="bi bi-back"></i></a>
        </li>

        <li class="nav-item">
            <a class="nav-link"  href="../archivosComunes/logout.php">Cerrar Sesion</a>
            </li>
            </div>
            </div>
            </ul> 
          </nav>';
?>