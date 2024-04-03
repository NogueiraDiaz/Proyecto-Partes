<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Articulos No Fungibles</title>
</head>
<body>
<?php

    // INSTALAR composer require mdpf/mdpf
    session_start();
    // Llamamos a los ficheros necesarios
    require_once('../../vendor/autoload.php');
    require_once('../../archivosComunes/conexion.php');
    // Si no se ha iniciado sesion se le devuelve al login
    if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../index.php?redirigido=true");
    };
    

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
    // Cogemos el contenido del css que deseamos poner a la tabla
    $stylesheet = file_get_contents('../css/tablaPDF.css');
    // Insertamos la linea de css en nuestro PDF
    $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    // Si el rol es 0
    if($_SESSION['usuario_login']['rol'] == 0){
        // Obtenemos el nombre del departamento
        $departamento = '';

        // Si esta inicializado el codigo de departamento y es distinto que todos hace
        // la consulta de los usuarios no fungibles por el departamento adecuada
        if (isset($_GET['codDepartamento']) && $_GET['codDepartamento'] !== "todos") {
            $codDepartamento = $_GET['codDepartamento'];
            $query = 'SELECT nombre FROM Departamentos WHERE codigo = ?';
            $pre = $db->prepare($query);
            $pre->execute([$codDepartamento]);
            $departamento = $pre->fetchColumn();
        }

        $titulo = 'ARTICULOS NO FUNGIBLES';
        if (!empty($departamento)) {
            $titulo .= ' DEL ' . $departamento;
        }
        $titulo = 'ARTICULOS NO FUNGIBLES';
    }
    // Si el rol del usuario es 1, es decir, un profesor
    else if($_SESSION['usuario_login']['rol'] == 1) {
        $titulo = 'ARTICULOS NO FUNGIBLES';
        $codigoDepartamento = $_SESSION['usuario_login']['departamento'];
        $query = 'SELECT nombre FROM Departamentos WHERE codigo = ?';
        $pre = $db->prepare($query);
        $pre->execute([$codigoDepartamento]);
        $departamento = $pre->fetchColumn();
    } else {
        $titulo = 'ARTICULOS NO FUNGIBLES';
        $departamento = '';
        if (isset($_GET['codDepartamento']) && $_GET['codDepartamento'] !== "todos") {
            $codDepartamento = $_GET['codDepartamento'];
            $query = 'SELECT nombre FROM Departamentos WHERE codigo = ?';
            $pre = $db->prepare($query);
            $pre->execute([$codDepartamento]);
            $departamento = $pre->fetchColumn();
        }
    }

    if (!empty($departamento)) {
        $titulo .= ' DEL ' .  mb_strtoupper($departamento);
    }

    // Con WriteHTML vamos escribiendo en el nuevo archivo de PDF
    $mpdf->WriteHTML('<h1>' . $titulo . '</h1>');

    $mpdf->WriteHTML('<table>
                        <thead>
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Fecha Alta</th>
                                <th scope="col">Número de Serie</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Unidades</th>
                                <th scope="col">Localización</th>
                                <th scope="col">Procedencia</th>
                                <th scope="col">Motivo de baja</th>
                                <th scope="col">Fecha de baja</th>
                            </tr>
                        </thead>
                        <tbody>');

        // Si el usuario es un administrador
        if($_SESSION['usuario_login']['rol'] == 0){
            // Si es todos sacamos todos los articulos no fungibles de todos los departamentos
            if($_GET['codDepartamento'] == "todos") {
                $consulta = 'SELECT a.codigo, d.nombre, a.fecha_alta, a.num_serie, a.nombre, a.descripcion, a.unidades, a.localizacion, a.procedencia_entrada, a.motivo_baja, a.fecha_baja 
                FROM Departamentos d, Articulos a, Tiene t, Nofungibles nf 
                WHERE d.codigo = t.cod_departamento 
                AND t.cod_articulo = a.codigo 
                AND a.codigo = nf.codigo;';    
            // Si no es todos guardamos el departamento y sacamos los articulos no fungibles del codigo seleccionado
            } else {
                $departamento = $_GET['codDepartamento'];
                $consulta = "SELECT a.codigo, d.nombre, a.fecha_alta, a.num_serie, a.nombre, a.descripcion, a.unidades, a.localizacion, a.procedencia_entrada, a.motivo_baja, a.fecha_baja 
                FROM Departamentos d, Articulos a, Tiene t, Nofungibles nf 
                WHERE d.codigo = t.cod_departamento 
                AND t.cod_articulo = a.codigo 
                AND a.codigo = nf.codigo
                AND t.cod_departamento = $departamento;";
            }

        // Si el usuario es un profesor le sacamos los articulos no fumgibles de su departamento
        } else if ($_SESSION['usuario_login']['rol'] == 1) {
            $departamento = $_SESSION['usuario_login']['departamento'];
            $consulta = "SELECT a.codigo, d.nombre, a.fecha_alta, a.num_serie, a.nombre, a.descripcion, a.unidades, a.localizacion, a.procedencia_entrada, a.motivo_baja, a.fecha_baja 
            FROM Departamentos d, Articulos a, Tiene t, Nofungibles nf 
            WHERE d.codigo = t.cod_departamento 
            AND t.cod_articulo = a.codigo 
            AND a.codigo = nf.codigo
            AND t.cod_departamento = $departamento;";
        }
        
        //Preparo la consulta
        $preparada = $db->prepare($consulta);
        $preparada->execute(array());
        $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);

        // A traves de un bucle vamos escribiendo en el pdf todos los datos necesarios
        foreach ($resultados as $row){
            $mpdf->WriteHTML('<tr><td>'. $row["codigo"] .'</td>');
            $mpdf->writehtml('<td>'. $row["fecha_alta"] .'</td>');
            $mpdf->writehtml('<td>'. $row["num_serie"] .'</td>');
            $mpdf->writehtml('<td>'. $row["nombre"] .'</td>');
            $mpdf->writehtml('<td>'. $row["descripcion"] .'</td>');
            $mpdf->writehtml('<td>'. $row["unidades"] .'</td>');
            $mpdf->writehtml('<td>'. $row["localizacion"] .'</td>');
            $mpdf->writehtml('<td>'. $row["procedencia_entrada"] .'</td>');
            $mpdf->writehtml('<td>'. $row["motivo_baja"] .'</td>');
            $mpdf->writehtml('<td>'. $row["fecha_baja"] .'</td></tr>');
            
        }
    $mpdf->WriteHTML('</tbody>
                    </table>');
    // PRIMER PARAMETRO: nombre que se dara al fichero al darle a guardar por defecto
    // SEGUNDO PARAMETRO: accion que realiza al pulsar el boton
    //      - I -> abre el pdf en otra pestaña con la opcion de descargarlo
    //      - D -> descarga el pdf directamente sin mostrarle
    //      - F -> guarda el fichero en local
    $mpdf->Output('articulos.pdf', 'I');
?>
</body>
</html>