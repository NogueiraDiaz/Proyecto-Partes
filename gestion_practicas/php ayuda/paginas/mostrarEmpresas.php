<?php
   try{
    require "../../../archivosComunes/conexion.php";
}
catch (PDOException $e) {//en caso de fallo devuelve el mensaje de error de BBDD
    echo "Error en la base de datos ".$e->getMessage();
}
//funcion que retorna una lista de alumnos
function muestraUsuarios($db, $nombreCod, $pagina, $resultadosPorPagina ){
    try{
         // Cálculo del desplazamiento
        $desplazamiento = ($pagina - 1) * $resultadosPorPagina;
        $consulta = "SELECT * FROM Empresas ";
        //consulto que valores tienen los parametros, si no son nulos hago una consulta con ellos
        if($nombreCod != null){
            $consulta .= "WHERE cod_empresa LIKE '%$nombreCod%'" ;  
        }
        //sino es que está buscando a todos los usuarios

        $empresas = $db->query($consulta . "LIMIT $desplazamiento, $resultadosPorPagina");  
        $_SESSION['numeroResultados'] =  $db->query($consulta)->rowCount();                                                     //busqueda normal            
        //variable que retorno con los resultados obtenidos
        $resultados = "";
        


        //aqui compruebo que la consulta devuelve resultados para mostrarlos por pantalla
        if($empresas->rowCount() > 0){
          

            foreach($empresas as $empresa){
                //variable que uso para asignar un alumno o no
                    $resultados .= 
                    "<tr>" .
                    "<td>" . $empresa["cod_empresa"] . "</td>" .
                    "<td>" .  $empresa["tipo"] . "</td>" . 
                    "<td>" . $empresa["respo_empresa"] . "</td>" .
                    "<td>" .  $empresa["dni_responsable"] . "</td>" . 
                    "<td>" . $empresa["nombre_empresa"] . "</td>" .
                    "<td>" . $empresa["localidad_empresa"] . "</td>" .
                    "<td>" .  $empresa["provincia_empresa"] . "</td>" . 
                    "<td>" . $empresa["direcc_empresa"] . "</td>" .
                    "<td>" . $empresa["cp_empresa"] . "</td>" .
                    "<td>" .  $empresa["cif_empresa"] . "</td>" . 
                    "<td>" . $empresa["localidad_firma"] . "</td>" .
                    "<td>" . $empresa["fecha_firma"] . "</td>" .
                    "<td> <a class='btn botones' href='" . $empresa["anexo_0"] . " '> Anexo0</a> " .
                    "<td> <a class='btn botones' href='" . $empresa["anexo_0a"] . " '> Anexo0a</a> " .
                    "<td> <a class='btn botones' href='" . $empresa["anexo_0b"] . " '> Anexo0b</a> " .
                    "<td> <a class='btn botones' href='" . $empresa["anexo_xvi"] . " '> Anexoxvi</a> " .
                    "<td> <a class='btn botones' href='./editarEmpresa.php?cod_empresa=" . $empresa["cod_empresa"] . " '> Editar</a> " .
                    "<td> <a class='btn btn-danger' href='./eliminar.php?cod_empresa=" . $empresa["cod_empresa"] . " '>Eliminar</a> </td>" .
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script type="text/javascript" src="../../js/paginacion.js" defer></script>
    <script type="text/javascript" src="../../js/bootstrap.bundle.min.js" defer></script>
    <title>Ver empresas</title>
</head>

<body class="cuerpo">
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
                        <a class="nav-link" href="mostrarAsignados.php">Ver Alumnos Asignados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mostrarEmpresas.php">Ver Empresas</a>
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
                </ul>
            </div>
        </div>
    </nav>

    <h3 class=" col-12 text-white">EMPRESAS</h3>
    <div class="buscador">
        <form>
        <input type="text" name="nombreCod" value="" placeholder="Nombre/Cod Empresa" class="form-control" id="buscador">
        </form>
    </div>

    <section class="container-fluid central"> 
        <table class="table text-white">
            <thead>
                <tr>
                    <th>Código empresa:</th>
                    <th>Tipo:</th>
                    <th>Responsable:</th>
                    <th>DNI del responsable:</th>
                    <th>Nombre:</th>
                    <th>Localidad:</th>
                    <th>Provincia:</th>
                    <th>Dirección:</th>
                    <th>Código postal:</th>
                    <th>CIF:</th>
                    <th>Localidad firma:</th>
                    <th>Fecha firma:</th>
                    <th>Anexo 0:</th>
                    <th>Anexo 0A:</th>
                    <th>Anexo 0B:</th>
                    <th>Anexo XVI:</th>
                    <th colspan=2></th>
                </tr>
            </thead>
            <tbody id="contenedor-tabla">
            <?php
                    $nombreCod = isset($_SESSION["nombreCod"]) ? $_SESSION["ciclo"] : "";

                    
                    $resultadosPorPagina = 6; // Número de resultados por página:
                    echo "<br><br>";
                    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1; 

                    echo muestraUsuarios($db, $nombreCod, $pagina , $resultadosPorPagina);

                ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul id="pagination-list" class="pagination">
                
            </ul>
        </nav>
    </section>

    <?php require "../Header-Footer/footer.php" ?>
</body>
</html>