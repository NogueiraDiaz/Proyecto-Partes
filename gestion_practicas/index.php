<?php


    //funcion que retorna una lista de alumnos
    function muestraUsuarios($db, $nombreApellidos, $ciclo, $anio, $pagina, $resultadosPorPagina ){
        try{
             // Cálculo del desplazamiento
            $desplazamiento = ($pagina - 1) * $resultadosPorPagina;
            $consulta = "SELECT * FROM Alumnos ";
            //consulto que valores tienen los parametros, si no son nulos hago una consulta con ellos
            if($nombreApellidos != null){
                if($ciclo != null || $anio != null) $consulta .= "WHERE apellidos LIKE '%$nombreApellidos%' OR nombre LIKE '%$nombreApellidos%' AND " .  consultaCicloAnio($ciclo, $anio) ;
                else $consulta .= "WHERE apellidos LIKE '%$nombreApellidos%' OR nombre LIKE '%$nombreApellidos%'  " .  consultaCicloAnio($ciclo, $anio) ;  
            }
            //sino es que está buscando a todos los usuarios
            elseif($ciclo != null || $anio != null) $consulta .= "WHERE " . consultaCicloAnio($ciclo, $anio);

            $usuarios = $db->query($consulta . "LIMIT $desplazamiento, $resultadosPorPagina");  
            $_SESSION['numeroResultados'] =  $db->query($consulta)->rowCount();                                                     //busqueda normal            
            //variable que retorno con los resultados obtenidos
            $resultados = "";
            


            //aqui compruebo que la consulta devuelve resultados para mostrarlos por pantalla
            if($usuarios->rowCount() > 0){
                $consulta1= $db->query("SELECT * FROM Pertenece");
                $idsAlumnos = Array();
                if($consulta1->rowCount()>0){
                    
                    foreach($consulta1 as $alumno) array_push($idsAlumnos, $alumno["cod_alumno"]);
                }

                foreach($usuarios as $usuario){
                    //variable que uso para asignar un alumno o no
                    $linkAsignar = in_array($usuario["cod_alumno"], $idsAlumnos) ? "<div class='deselected btn btn-secondary'>Asignar Empresa<span class='texto-deselected'>Alumno ya asignado</span></div>":
                                                            "<a class='btn botones' href='php ayuda/paginas/asignarEmpresa.php?cod_alumno=" . $usuario["cod_alumno"] . "&ciclo=" . $usuario["ciclo"] . "'>Asignar Empresa</a>";

                    $resultados .= 
                        "<tr>" .
                        "<td>" . $usuario["nombre"] . "</td>" .
                        "<td>" .  $usuario["apellidos"] . "</td>" . 
                        "<td>" . $usuario["dni_alumno"] . "</td>" .
                        "<td>" .  $usuario["ciclo"] . "</td>" . 
                        "<td>" . $usuario["anio"] . "</td>" .
                        "<td> <a class='btn botones' href='php ayuda/paginas/editarAlumno.php?id=" . $usuario["cod_alumno"] . " '> Editar</a> " .
                        "<td> $linkAsignar</td> " .  //mete un filtro para mirar si está asignado o no, si no lo está aparece este boton, sino mostrar
                        "<td> <a class='btn btn-danger' href='php ayuda/paginas/eliminar.php?cod_alumno=" . $usuario["cod_alumno"] . " '>Eliminar</a> </td>" .
                        "</tr>" ;
                }
            }
            //sino lo hace muestro este mensaje por pantalla
            else{
                $resultados = "<tr><td colspan='8'>No se ha encontrado ningun Alumno</td></tr>";
            }

            //esto es lo que devuelve el metodo, que es o la información que se busca o un mensaje de error
            return $resultados;
        }
        catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            return "Error en la base de datos ".$e->getMessage();
        }
    }


    /*-----------------------------CODIGO FUNCIONAL--------------------------------------------------- */
    session_start();
    //miro si el usuario está loggeado para redirigirlo en caso contrario
    if(!isset($_SESSION["usuario_login"])) header("Location: ../index.php?redirigido=true");

    //Llamo a un archivo con diferentes funciones para el filtrado de alumnos
    require 'php ayuda/Funciones/filtro.php';


    //Aqui hago la conexión a la base de datos y la guardo en una variable llamada "$db"
    try{ require "../archivosComunes/conexion.php"; }
    catch (PDOException $e) {
        return "Error en la base de datos ".$e->getMessage();   
    }

    //utilización del filtro de ciclo y año
    asignarCicloAnio();
    //checkeo si el boton de eliminar los filtros se ha pulsado para llamar a la funcion
    if(isset($_POST["eliminaFiltro"])) resetFiltros();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script type="text/javascript" src="js/bootstrap.bundle.min.js" defer></script>
    <title>Ver Alumnos</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="img/julioverne.png" width="70" height="58" class="d-inline-block align-text-top m-2"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Ver Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php ayuda/paginas/mostrarAsignados.php">Ver Alumnos Asignados</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="php ayuda/paginas/mostrarEmpresas.php">Ver Empresas</a>
                    </li>
                    <li style="padding-left: 3rem"><hr class="dropdown-divider"></li>
                    <li class="nav-item">
                        <a class="nav-link" href="php ayuda/paginas/crearEmpresa.php">Crear Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php ayuda/paginas/crearAlumno.php">Crear Alumno</a></a>
                    </li>
                    <li><hr class="dropdown-divider text-white"></li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
      <a class="text-light btn btn-outline-secondary me-2" href="../archivosComunes/actualizarUsuario.php?idusuario=<?php echo $_SESSION['usuario_login']['cod_usuario']?>">
      <span class="d-flex">
          <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>&nbsp;
                <?php echo $_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos'] ?>
      </span>                 
  </a>
  </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="../archivosComunes/selector.php"><span class="salir">Página Principal</span> <i class="bi bi-back"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../archivosComunes/logout.php"><span class="salir">Salir&nbsp</span> <i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <h3>ALUMNOS</h3>

    <div class="container-fluid buscador">
        <form method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <input type="text" name="nombreApellidos" class="form-control"
                        value="<?php if(isset($_POST["nombreApellidos"])) echo $_POST["nombreApellidos"] ?>" placeholder="Nombre o Apellidos">
                <button type="submit" class="btn botones">Buscar</button>
            </div>
        </form>

        <form method="POST"
                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <select class="form-control" name="CICLO">
                    <?php obtenerCiclosAnios($db, "ciclo");//recojo los diferentes ciclos dentro de la BBDD ?>
                </select>

                <select class="form-control" name="ANIO">
                    <?php obtenerCiclosAnios($db, "anio");//recojo los diferentes ciclos dentro de la BBDD ?>
                </select>
            </div>

            <div>
                <button type="submit" class="btn botones">Aplicar filtros</button>
                <button type="submit" class="btn botones" name="eliminaFiltro">Eliminar filtros</button>
            </div>
        </form>
    </div>

    <hr class="text-white">
    <section class="central">
        <table class="table text-white">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Ciclo</th>
                <th>Año</th>
                <th colspan="3"></th>
              </tr>
            </thead>
            <tbody>
            <?php
                    $nombreSelec = isset($_POST["nombreApellidos"]) && $_POST["nombreApellidos"] != "" ? $_POST["nombreApellidos"]: null;
                    $cicloSelec = isset($_SESSION["ciclo"]) ? $_SESSION["ciclo"] : "";
                    $anioSelec = isset($_SESSION["anio"]) ? $_SESSION["anio"] : "";
                    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1; 

                    
                    $resultadosPorPagina = 6; // Número de resultados por página:
                    echo "<br><br>";
                    echo muestraUsuarios($db, $nombreSelec, $cicloSelec, $anioSelec, $pagina, $resultadosPorPagina);

                ?>
            </tbody>
        </table>
    </section>

    <div class="pagination">
        <?php
            $totalResultados = $_SESSION['numeroResultados'];
            // Número total de páginas
            $totalPaginas = ceil($totalResultados / $resultadosPorPagina);

            // Mostrar enlaces a las diferentes páginas
            if ($totalPaginas > 1) {
             
            // Enlace a la página anterior
            if ($pagina > 1) {
                echo '<a class="antSig" href="index.php?pagina=' . ($pagina - 1) .'&nombreApellidos=' . urlencode($nombreSelec) . '&ciclo=' . urlencode($cicloSelec) . '&anio=' . urlencode($anioSelec) . '">Anterior</a>';
            }

            // Enlaces a las páginas intermedias
            for ($i = 1; $i <= $totalPaginas; $i++) {
                if ($i == $pagina) {
                    echo '<span class="current inter active">' . $i . '</span>';
                } else {
                    echo '<a class="inter" href="index.php?pagina=' . $i .'&nombreApellidos=' . urlencode($nombreSelec) . '&ciclo=' . urlencode($cicloSelec) . '&anio=' . urlencode($anioSelec) .'">' . $i . '</a>';
                }
            }

            // Enlace a la página siguiente
            if ($pagina < $totalPaginas) {
                echo '<a class="antSig" href="index.php?pagina=' . ($pagina + 1) .'&nombreApellidos=' . urlencode($nombreSelec) . '&ciclo=' . urlencode($cicloSelec) . '&anio=' . urlencode($anioSelec) . '">Siguiente</a>';
            }
            }
        ?>
    </div>

    <?php require "php ayuda/Header-Footer/footer.php" ?>
</body>
</html>
