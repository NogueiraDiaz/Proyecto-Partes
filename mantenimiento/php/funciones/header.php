<header>
  <nav id="navegador" class="navbar navbar-expand-md navbar-light" style="background-color: rgba(0, 0, 0, 0.2)">
    <div class="container-fluid">
      <a class="navbar-brand" href="funciones/rolApp.php">
        <img src="../images/logoJulioVerne.png" width="65px" height="65px">
        <span class="text-dark" style="font-size: 18px;">
          <?php
          require_once('funciones/bienvenido.php');
          ?>
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav me-auto">
          <?php
              //Inidicamos que header corresponde
              require_once('../../archivosComunes/conexion.php');
              if($_SESSION['usuario_login']['departamento']!=""){
              $referencia = "SELECT referencia FROM Departamentos WHERE codigo = ".$_SESSION['usuario_login']['departamento'];
              $referencia = $db->query($referencia);
              $columna = "";
              // Mostramos los resultados de la consulta en un select
              foreach ($referencia as $row) {
                $columna = $row["referencia"];
              }
              if( $_SESSION['usuario_login']['rol']==0){
              echo '<li style=margin-right:10px><a href="admin.php" class="text-dark">Incidencias Pendientes</a></li>';

              echo '<li style=margin-right:10px><a href="adminFinalizadas.php" class="text-dark">Incidencias Finalizadas</a></li>';
              }
              if( $_SESSION['usuario_login']['rol']==0){
              
                echo '<li style=margin-right:10px><a href="incidenciasAdmin.php" class="text-dark">Incidencias Asignadas</a></li>';
     
              }
              if(( $columna=="inf" && $_SESSION['usuario_login']['rol']==1)){
              
                echo '<li style=margin-right:10px><a href="profesor.php" class="text-dark">Incidencias Asignadas</a></li>';
     
              }
              }?>
             <li><a href="profesorCreadas.php" class="text-dark">Incidencias Creadas</a></li>

        </ul>
        <hr class="text-white-50">
        <i class="bi bi-person-circle"></i>
        <ul class="nav navbar-nav navbar-right">
        <li class="nav-item">
         <a class="text-dark btn btn-outline-secondary me-2" href="../../archivosComunes/actualizarUsuario.php?idusuario=<?php echo $_SESSION['usuario_login']['cod_usuario'] ?>">
         <span class="d-flex">
             <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
             </svg>&nbsp;
              <?php echo $_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos'] ?>
         </span>                 
     </a>
     </li> 
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" id="submenu" role="button" data-bs-toggle="dropdown" href="#" style="margin-right: 100px;"><span class="material-symbols-outlined">
          account_circle
          </span></a>
            <ul class="dropdown-menu" style="background-color: #ECEFF1">
          
              <li><a class="dropdown-item" href="../../archivosComunes/selector.php">Página Principal</a></li>
              <hr>
              <li><a class="dropdown-item" href="../../archivosComunes/logout.php">Cerrar Sesión</a></li>
            </ul>
          </li>
        </ul>
        <hr class="text-white-50">
      </div>
    </div>
  </nav>
</header>