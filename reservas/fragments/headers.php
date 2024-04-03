<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>ReservApp - IES Julio Verne</title>

    <!-- Bootstrap https://getbootstrap.com -->
    <link href="./static/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="./static/js/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <!-- jQuery https://jquery.com/ -->
    <script type="text/javascript" src="./static/js/jquery-3.6.0.min.js"></script>

    <!-- DataTable https://datatables.net/ -->
    <link rel="stylesheet" href="./static/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="./static/css/dataTables.responsive.min.css"/>
    <script type="text/javascript" src="./static/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./static/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="./static/js/dataTables.responsive.min.js"></script>

    <!-- Datepicker-bootstrap https://bootstrap-datepicker.readthedocs.io/en/latest/ -->
    <link rel="stylesheet" href="./static/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="./static/css/bootstrap-datepicker3.min.css"/>
    <script type="text/javascript" src="./static/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="./static/js/bootstrap-datepicker.es.min.js"></script>
    
    <!-- FullCalendar https://fullcalendar.io/ -->
    <script type="text/javascript" src="./static/js/fullcalendar.main.min.js"></script>
    <script type="text/javascript" src="./static/js/fullcalendar.locales-all.min.js"></script>
    <link rel="stylesheet" href="./static/css/fullcalendar.main.min.css"/>

    <!-- Estilos propios -->
    <link href="./static/css/estilos.css" rel="stylesheet">

</head>

<body class="bg-dark bg-opacity-10">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand navLogo" href="./misreservas.php">
                <div class="d-flex nowrap gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" id="logo" style="height: 30px;" class="my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    <div class="d-flex flex-column text-center">
                        <span style="font-weight: bold; font-size: 16px;">IES Julio Verne</span>
                        <em style="font-size: 15px;">Reservapp</em>
                    </div>
                </div>
            </a>
            <?php if (isset($_SESSION['usuario_login'])) { ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-center" id="navbarCollapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item mb-1 mb-lg-0">
                        <a class="nav-link <?php if(str_contains($_SERVER['SCRIPT_NAME'],'misreservas.php')) echo 'active' ?>" aria-current="page" href="./misreservas">Mis reservas</a>
                    </li>
                    <li class="nav-item mb-1 mb-lg-0">
                        <a class="nav-link <?php if(str_contains($_SERVER['SCRIPT_NAME'],'reservar.php')) echo 'active' ?>" href="./reservar">Reservar</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link <?php if(str_contains($_SERVER['SCRIPT_NAME'],'calendario.php')) echo 'active' ?>" href="./calendario">Calendario Aulas</a>
                    </li>
                    <?php if($_SESSION['usuario_login']['rol'] == '0'){ ?>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link <?php if(str_contains($_SERVER['SCRIPT_NAME'],'calendarioUsuarios.php')) echo 'active' ?>" href="./calendarioUsuarios">Calendario Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(str_contains($_SERVER['SCRIPT_NAME'],'admins.php')) echo 'active' ?>" href="./admins">Administración</a>
                    </li>
                    <?php } ?>
                </ul>

                    <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item">
                        <div class="d-inline-flex my-3 my-lg-0">
                        <a class="text-light btn btn-outline-secondary me-2" href="../archivosComunes/actualizarUsuario.php?idusuario=  <?php echo $_SESSION['usuario_login']['cod_usuario']?>">
                        <span class="d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>&nbsp;
                            <?php echo $_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos']?>
                        </span>                 
                    </a>
                    </div>
                    </li>            
                                
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="submenu" role="button" data-bs-toggle="dropdown" href="#" style="margin: 0 20px;"><span class="material-symbols-outlined">
                    Opciones
                    </span></a>
                        <ul class="dropdown-menu" style="background-color: #ECEFF1">
                        <li><a class="dropdown-item" href="../archivosComunes/selector.php">Página Principal</a></li>
                        <hr>
                        <li><a class="dropdown-item" href="../archivosComunes/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
               
            </div>
            <?php } ?>
        </div>
    </nav>
    