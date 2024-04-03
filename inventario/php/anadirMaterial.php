<?php
    // Si no ha iniciado sesion se le redirige para hacer login
    session_start();
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../index.php?redirigido=true");
    };

    // Si los datos llegan por metodo POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Llamamos al fichero para acceder a sus funciones
        require("funcionesBBDD.php"); 
        // Hacemos la conexion a la base de datos
        require_once('../../archivosComunes/conexion.php');
        
        if(isset($_POST["btn-guardar"])){
            // Si el rol del usuario es 1 se guarda el nombre del departamento
            if($_SESSION["usuario_login"]['rol'] == 1){
                $nombreDepartamento = $_POST['nombreDepartamento'];
            // Si el rol del usuario es 0 se guarda el nombre del departamento seleccionado en el selector
            } else if($_SESSION["usuario_login"]['rol'] == 0){
                $nombreDepartamento = $_POST['selectDepartamento'];
            }

            // Si el nombre no es ningun departamento te envia al formulario con error
            if($nombreDepartamento == '- Seleccione su departamento -'){
                header("Location: formulario.php?error=true");
            } else {
                if($_POST["fecha_bj"] == ''){
                    $_POST["fecha_bj"] = null;
                }

                if($_POST["motivo_bj"] == ''){
                    $_POST["motivo_bj"] = null;
                }

                if(isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])){
                    $img = file_get_contents($_FILES["imagen"]["tmp_name"]);
                } else {
                    $img = null;
                }

                // Llamamos a la función "anadir_img" para añadir los datos a la base de datos
                anadir_img($_POST["nombre"], $_POST["numero"], $_POST["descripcion"], $_POST["localizacion"], 
                $_POST["unidades"], $_POST["procedencia"], $_POST["motivo_bj"],  $_POST["fecha_bj"], $img);

                // INSERT EN LA TABLA "TIENE", TABLA INTERMEDIA ENTRE ARTICULO Y DEPARTAMENTO
                $consultaArticulo = "SELECT MAX(codigo) as id FROM Articulos";
                $consultaArticulo = $db->query($consultaArticulo);
                $codigoArticulo = $consultaArticulo->fetch();

                // Se coge el valor que se encuentra en id ya que al hacer la consulta devuelve dos valores
                $codArticulo = $codigoArticulo['id'];

                if($_SESSION['usuario_login']['rol'] != 0){
                    $codigoDepartamento = $_SESSION['usuario_login']['departamento'];
                    $consulta = "INSERT INTO Tiene(cod_articulo,cod_departamento) VALUES (?,?);";
                    $consulta = $db->prepare($consulta);
                    $consulta->execute(array($codArticulo, $codigoDepartamento));
                    header("Location: lista.php");
                } else {                    
                        $consulta = "SELECT * FROM Departamentos WHERE nombre = ?;";
                        $consulta = $db->prepare($consulta);
                        $consulta->execute(array($nombreDepartamento));
                        foreach($consulta as $row) {
                            $codigoDepartamento = $row['codigo'];
                        }

                        $consultaInsert = "INSERT INTO Tiene(cod_articulo,cod_departamento) VALUES (?,?);";
                        $consultaInsert = $db->prepare($consultaInsert);
                        $consultaInsert->execute(array($codArticulo, $codigoDepartamento));
                        header("Location: lista.php");
                    }

                // FUNGIBLES
                if($_POST['fungible'] == 1){
                    $consultaFungibles = "INSERT INTO Fungibles(codigo, pedir) VALUES (?,?);";
                    $consultaFungibles = $db->prepare($consultaFungibles);
                    $consultaFungibles->execute(array($codArticulo, 'no'));
                } // NO FUNGIBLES
                else if($_POST['fungible'] == 0){
                    $consultaNoFungibles = "INSERT INTO Nofungibles(codigo, fecha) VALUES (?,?);";
                    $consultaNoFungibles = $db->prepare($consultaNoFungibles);
                    $consultaNoFungibles->execute(array($codArticulo, date('Y')));
                }
            }
        }
    }
?>