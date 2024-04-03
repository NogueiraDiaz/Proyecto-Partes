<?php
    /*-----------------------------------------------------FUNCIONES------------------------------------------------------------------------------------ */

    function muestraUsuarios($db, $nombre, $ciclo, $pagina, $resultadosPorPagina){
        try{
            // Cálculo del desplazamiento
            $desplazamiento = ($pagina - 1) * $resultadosPorPagina;
            //realizo la conexión a la base de datos
            $usuarios = $db->query("SELECT * FROM Pertenece");

            //compruebo que hay usuarios en la tabla
            if($usuarios->rowCount() > 0){

                //para sacar el nombre del alumno y la empresa y el tutor
                //primero obtengo una lista con los ids
                $idsAlumnos = "WHERE COD_ALUMNO = ";    //aqui almaceno los datos para hacer la próxima consulta
                $idsEmpresa = "WHERE COD_EMPRESA = ";
                $idsProfesor = "WHERE COD_USUARIO = ";
                $i = 1;
                foreach($usuarios as $row){             //recorro los resultados y guardo los ids dentro de las variables
                    $idsAlumnos .= "'" . $row["COD_ALUMNO"] . "'";      
                    $idsEmpresa .= "'" . $row["COD_EMPRESA"] . "'"; 
                    $idsProfesor .= "'" . $row["COD_USUARIO"] . "'";     
                    if($usuarios->rowCount() != $i){    //compruebo si no está al final del array para que no imprime datos erroneos en la consulta
                        $idsAlumnos .= " OR COD_ALUMNO = ";
                        $idsEmpresa .= " OR COD_EMPRESA = ";
                        $idsProfesor .= " OR COD_USUARIO = ";
                    }
                    $i++;
                }

                //Ahora hago una consulta para almacenar los nombres con las Ids que he recogido
                $nombreAlumnos = array();
                $consultaAlumnos = $db->query("SELECT NOMBRE, COD_ALUMNO FROM Alumno $idsAlumnos");                 //hago la consulta y recorro los datos
                foreach($consultaAlumnos as $alumno) $nombreAlumnos[$alumno["COD_ALUMNO"]] = $alumno["NOMBRE"];      //aqui almaceno cada nombre dentro de un array 

                //hago el mismo proceso pero con las empresas
                $nombreEmpresas = array();
                $consultaEmpresa = $db->query("SELECT NOMBRE_EMPRESA, COD_EMPRESA FROM Empresa $idsEmpresa");
                foreach($consultaEmpresa as $empresa) $nombreEmpresas[$empresa["COD_EMPRESA"]] = $empresa["NOMBRE_EMPRESA"]; 

                 //y otra vez pero con usuarios para sacar el nombre del profesor
                 $nombreProfesor = array();
                 $consultaProfesor = $db->query("SELECT NOMBRE, COD_USUARIO FROM Usuario $idsProfesor");
                 foreach($consultaProfesor as $profesor) $nombreProfesor[$profesor["COD_USUARIO"]] = $profesor["NOMBRE"]; 


                //variable que retorno con los resultados obtenidos
                $resultados = "";
                
                $filtroCiclo = $ciclo != "" ? "WHERE CICLO = '$ciclo'" : ""; 

                $_SESSION['numeroResultados'] = $db->query("SELECT * FROM Pertenece $filtroCiclo")->rowCount();

                $usuarios = $db->query("SELECT * FROM Pertenece $filtroCiclo LIMIT $desplazamiento, $resultadosPorPagina");
                foreach($usuarios as $usuario){
                    if($nombre == ""){
                        
                        $resultados .=
                        "<tr>
                        <td> " . $nombreAlumnos[$usuario["COD_ALUMNO"]]  . "</td>" .
                        "<td>" . $nombreProfesor[$usuario["COD_USUARIO"]]  . "</td>" .
                        "<td>" . $nombreEmpresas[$usuario["COD_EMPRESA"]] . "</td>" .
                        "<td>" . $usuario["TUTOR_PRACTICAS"] . "</td>" .
                        "<td>" . $usuario["CICLO"] . "</td>" .
                        "<td>" . $usuario["F_INICIO_BECA"] . "</td>" . 
                        "<td>" . $usuario["F_FIN_BECA"] . "</td>" .
                        "<td> <a class='btn botones' href='editarAlumnoAsignado.php?COD_ALUMNO=" . $usuario["COD_ALUMNO"] . "&COD_EMPRESA=".$usuario["COD_EMPRESA"]."&CICLO=".$usuario["CICLO"]."'>Editar datos</a> </td>" .
                        "<td> <a class='btn btn-danger' href='eliminar.php?COD_ALUMNO=". $usuario["COD_ALUMNO"]."&COD_EMPRESA=".$usuario["COD_EMPRESA"]."'>Desemparejar</a> </td>" .
                        "</tr>" ;
                    }
                    else{
                        if( str_contains(strtolower($nombreAlumnos[$usuario["COD_ALUMNO"]]), strtolower($nombre)) || 
                            str_contains(strtolower($nombreProfesor[$usuario["COD_USUARIO"]]), strtolower($nombre)) ||
                            str_contains(strtolower($nombreEmpresas[$usuario["COD_EMPRESA"]]), strtolower($nombre))){
                                $resultados .=
                            "<tr>
                            <td> " . $nombreAlumnos[$usuario["COD_ALUMNO"]]  . "</td>" .
                            "<td>" . $nombreProfesor[$usuario["COD_USUARIO"]]  . "</td>" .
                            "<td>" . $nombreEmpresas[$usuario["COD_EMPRESA"]] . "</td>" .
                            "<td>" . $usuario["TUTOR_PRACTICAS"] . "</td>" .
                            "<td>" . $usuario["CICLO"] . "</td>" .
                            "<td>" . $usuario["F_INICIO_BECA"] . "</td>" . 
                            "<td>" . $usuario["F_FIN_BECA"] . "</td>" .
                            "<td> <a class='btn botones' href='editarAlumnoAsignado.php?COD_ALUMNO=" . $usuario["COD_ALUMNO"] . "&COD_EMPRESA=".$usuario["COD_EMPRESA"]."&CICLO=".$usuario["CICLO"]."'>Editar datos</a> </td>" .
                            "<td> <a class='btn btn-danger' href='eliminar.php?COD_ALUMNO=". $usuario["COD_ALUMNO"]."&COD_EMPRESA=".$usuario["COD_EMPRESA"]."'>Desemparejar</a> </td>" .
                            "</tr>" ;
                            }
                    }
                    
                }
                

            }
            //sino lo hace muestro este mensaje por pantalla
            else $resultados = "<tr><td colspan='9'>No se ha encontrado ningun alumno</td></tr>";

            //esto es lo que devuelve el metodo, que es o la información que se busca o un mensaje de error
            return $resultados;
        }
        catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
            return "Error en la base de datos ".$e->getMessage();
        }
    }


    /*-----------------------------------------------------CODIGO FUNCIONAL------------------------------------------------------------------------------------ */

    session_start();
    //miro si el usuario está loggeado para redirigirlo en caso contrario
    require_once("../Funciones/loginRequerido.php"); 

    require '../Funciones/filtro.php';
    
    try{
        require "../../../archivosComunes/conexion.php";
    }
    catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
        return "Error en la base de datos ".$e->getMessage();
    }



    //utilización del filtro de ciclo
    asignarCicloAnio();
    //checkeo si el boton de eliminar los filtros se ha pulsado para llamar a la funcion
    if(isset($_POST["eliminaFiltro"])) resetFiltros();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


    <script type="text/javascript" src="../../js/bootstrap.bundle.min.js" defer></script>

    <title>Ver Alumnos Asignados</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php"><img src="../../img/julioverne.png" width="70" height="58" class="d-inline-block align-text-top m-2"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Ver Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mostrarAsignados.php">Ver Alumnos Asignados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrarEmpresas.php">Ver Empresas</a>
                    </li>

                    <li style="padding-left: 3rem"><hr class="dropdown-divider"></li>
                    <li class="nav-item">
                        <a class="nav-link" href="crearEmpresa.php">Crear Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="crearAlumno.php">Crear Alumno</a></a>
                    </li>
                    <li><hr class="dropdown-divider text-white"></li>
                </ul>

                <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
      <a class="text-light btn btn-outline-secondary me-2" href="../../../archivosComunes/actualizarUsuario.php?idusuario=<?php echo $_SESSION['usuario_login']['cod_usuario']?>">
      <span class="d-flex">
          <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>&nbsp;
                <?php echo $_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos'] ?>
      </span>                 
  </a>
  </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="../../../archivosComunes/selector.php"><span class="salir">Página Principal</span> <i class="bi bi-back"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../../archivosComunes/logout.php"><span class="salir">Salir&nbsp</span> <i class="bi bi-box-arrow-right"></i></a>
                    </li>
            </div>
        </div>
    </nav>

    <h3>ALUMNOS ASIGNADOS</h3>

    <div class="buscador">
        <form method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="">
                <input type="text" name="nombre" class="form-control"
                        value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"] ?>" placeholder="Alumno/Empresa/Tutor"><!--buscador con este campo, le tengo que poner un placeholder-->
                <button type="submit" class="btn botones">Buscar</button>
            </div>
        </form>

        <form method="POST"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div>
                    <select class="form-control" name="CICLO">
                        <?php obtenerCiclosAnios($db, "CICLO");//recojo los diferentes ciclos dentro de la BBDD ?>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn botones">Aplicar filtro</button>
                    <button type="submit" class="btn botones" name="eliminaFiltro">Eliminar filtro</button>
                </div>
            </div>
        </form>
    </div>		


    <section class="container-fluid central">
        <table class="table text-white">
                    <thead>
                      <tr>
                        <th scope="col">Nombre alumno</th> 
                        <th scope="col">Nombre Profesor</th> 
                        <th scope="col">Nombre empresa</th>
                        <th scope="col">Nombre tutor practicas</th>
                        <th scope="col">Ciclo</th>
                        <th scope="col">Fecha inicio beca</th>
                        <th scope="col">Fecha fin de beca</th>
                        <th scope="col">Editar datos</th>
                        <th scope="col">Desemparejar</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nombre = isset($_POST["nombre"]) && $_POST["nombre"] != "" ? $_POST["nombre"]: null;
                        $ciclo = isset($_SESSION["CICLO"]) ? $_SESSION["CICLO"] : "";
                        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1; 
                        $resultadosPorPagina = 6; // Número de resultados por página:
                        echo muestraUsuarios($db, $nombre, $ciclo, $pagina, $resultadosPorPagina);                        
                        ?>
                    </tbody>
                </table>
		    </div> 
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
                    echo '<a class="antSig" href="mostrarAsignados.php?pagina=' . ($pagina - 1) . '&nombre=' . urlencode($nombre) . '&ciclo=' . urlencode($ciclo) . '">Anterior</a>';
                }
            
        // Enlaces a las páginas intermedias
                for ($i = 1; $i <= $totalPaginas; $i++) {
                    if ($i == $pagina) {
                        echo '<span class="current inter active">' . $i . '</span>';
                    } else {
                        echo '<a class="inter" href="mostrarAsignados.php?pagina=' . $i . '&nombre=' . urlencode($nombre) . '&ciclo=' . urlencode($ciclo) . '">' . $i . '</a>';
                    }
                }
            
        // Enlace a la página siguiente
                if ($pagina < $totalPaginas) {
                    echo '<a class="antSig" href="mostrarAsignados.php?pagina=' . ($pagina + 1) . '&nombre=' . urlencode($nombre) . '&ciclo=' . urlencode($ciclo) . '">Siguiente</a>';
                }
                }
        ?>
    </div>

    
    <?php require "../Header-Footer/footer.php" ?>
 
</body>
</html>