<?php
    // Si no ha iniciado sesion se le redirige para hacer login
    session_start();
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../index.php?redirigido=true");
    };
	//print_r($_POST);
	//print_r($_FILES);
	if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Llamamos al fichero para hacer uso de sus funciones
        require_once("funcionesBBDD.php"); 

        // Cuando el boton de guardar esta inicializado
        if(isset($_POST["btn-guardar"])){

            // Si no añadimos fecha de baja al actualizarlo se dejara como null
            if($_POST["fecha_bj"] == ''){
                $_POST["fecha_bj"] = null;
            }

            // Si no añadimos motivo de baja al actualizarlo se dejara como null
            if($_POST["motivo_bj"] == ''){
                $_POST["motivo_bj"] = null;
            }

            // Si añadimos imagen al actualizarlo se guardara en la variable img
            if (isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])) {
                $img = file_get_contents($_FILES["imagen"]["tmp_name"]);

                actualizarDatos($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["motivo_bj"], $_POST["numero"], $_POST["unidades"], $_POST["fecha_bj"], $img, $_GET['cod'], $_POST['procedencia'], $_POST['selectDepartamento']);

            // Si no ponemos foto actualizara sin foto
            } else {
                actualizarDatos2($_POST["nombre"], $_POST["descripcion"], $_POST["localizacion"], $_POST["motivo_bj"], $_POST["numero"], $_POST["unidades"], $_POST["fecha_bj"], $_GET['cod'], $_POST['procedencia'], $_POST['selectDepartamento']);
            }

            // Redirigimos a lista.php
            header("Location: lista.php");
        }
        
    }
?>
