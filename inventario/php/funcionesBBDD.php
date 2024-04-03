<?php

    // Funcion para añadir en la tabla articulo
    function anadir_img($nombre, $numero, $descripcion, $localizacion, $unidades, $procedencia, $motivo_bj, $fecha_bj, $img){

    	require "../../archivosComunes/conexion.php";

        try {
            $db = new PDO($conexion, $usuario, $password);
            // consulta para insertar en la tabla
            $datos = $db->prepare("INSERT INTO Articulos (fecha_alta, num_serie, nombre, descripcion, unidades, 
           	localizacion, procedencia_entrada, motivo_baja, fecha_baja, ruta_imagen) VALUES     (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $datos->bindParam(1, $numero);
            $datos->bindParam(2, $nombre);
            $datos->bindParam(3, $descripcion);
            $datos->bindParam(4, $unidades);
            $datos->bindParam(5, $localizacion);
            $datos->bindParam(6, $procedencia);
            $datos->bindParam(7, $motivo_bj);
            $datos->bindParam(8, $fecha_bj);
            $datos->bindParam(9, $img, PDO::PARAM_LOB);
            $datos->execute();
            $db = null;
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    // Funcion para actualizar datos con la foto
    function actualizarDatos($nombre, $descripcion, $localizacion, $motivo_bj, $numero, $unidades, $fecha_bj, $img, $codigo, $procedencia, $departamento){
        require "../../archivosComunes/conexion.php";
        $db = new PDO($conexion, $usuario, $password);
        // Consulta para actualizar todos los campos incluida la foto
        $updateQuery = $db->prepare("UPDATE Articulos SET nombre = ?, num_serie = ?, descripcion = ?, localizacion = ?, motivo_baja = ?, unidades = ?, fecha_baja = ?, ruta_imagen = ?, procedencia_entrada = ?  WHERE codigo = ?;");
        $updateQuery->bindParam(1, $nombre);
        $updateQuery->bindParam(2, $numero);
        $updateQuery->bindParam(3, $descripcion);
        $updateQuery->bindParam(4, $localizacion);
        $updateQuery->bindParam(5, $motivo_bj);
        $updateQuery->bindParam(6, $unidades);
        $updateQuery->bindParam(7, $fecha_bj);
        $updateQuery->bindParam(8, $img, PDO::PARAM_LOB);
        $updateQuery->bindParam(9, $procedencia);
        $updateQuery->bindParam(10, $codigo);
        $updateQuery->execute();

        // Si quiere cambiar el departamento buscamos el codigo del nombre que viene a traves del selector
        $queryDepartamento = $db->prepare("select * from Departamentos where nombre = ?");
        $queryDepartamento->execute(array($departamento));

        foreach ($queryDepartamento as $codigoDept) {
            // Actualizamos en la tabla tiene con el nuevo codigo de departamento
            $updateDepartamento = $db->prepare("UPDATE Tiene SET cod_departamento = ? WHERE cod_articulo = ?");
            $updateDepartamento->bindParam(1, $codigoDept['codigo']);
            $updateDepartamento->bindParam(2, $codigo);
            $updateDepartamento->execute();
        }
    }

    // Funcion para actualizar datos sin la foto
    function actualizarDatos2($nombre, $descripcion, $localizacion, $motivo_bj, $numero, $unidades, $fecha_bj, $codigo, $procedencia, $departamento){
        require "../../archivosComunes/conexion.php";
        $db = new PDO($conexion, $usuario, $password);
        // Consulta para actualizar los campos sin incluir la foto
        $updateQuery = $db->prepare("UPDATE Articulos SET nombre = ?, num_serie = ?, descripcion = ?, localizacion = ?, motivo_baja = ?, unidades = ?, fecha_baja = ?, procedencia_entrada = ? WHERE codigo = ?;");
        $updateQuery->bindParam(1, $nombre);
        $updateQuery->bindParam(2, $numero);
        $updateQuery->bindParam(3, $descripcion);
        $updateQuery->bindParam(4, $localizacion);
        $updateQuery->bindParam(5, $motivo_bj);
        $updateQuery->bindParam(6, $unidades);
        $updateQuery->bindParam(7, $fecha_bj);
        $updateQuery->bindParam(8, $procedencia);
        $updateQuery->bindParam(9, $codigo);
        $updateQuery->execute();

        // Si quiere cambiar el departamento buscamos el codigo del nombre que viene a traves del selector
        $queryDepartamento = $db->prepare("select * from Departamentos where nombre = ?");
        $queryDepartamento->execute(array($departamento));

        foreach ($queryDepartamento as $codigoDept) {
            // Actualizamos en la tabla tiene con el nuevo codigo de departamento
            $updateDepartamento = $db->prepare("UPDATE Tiene SET cod_departamento = ? WHERE cod_articulo = ?");
            $updateDepartamento->bindParam(1, $codigoDept['codigo']);
            $updateDepartamento->bindParam(2, $codigo);
            $updateDepartamento->execute();
        }
    }

    // Funcion que muestra los articulos seleccionados
    function consultarDatos($consulta,$numeroPagina=0){
        require "../../archivosComunes/conexion.php";
        try {
            $db = new PDO($conexion, $usuario, $password);
        
            $itemsPagina = 10;
            $consultaFinal=$consulta. ' LIMIT '.$itemsPagina.' OFFSET ' . $numeroPagina * $itemsPagina;
           
            //Preparo la consulta
            $preparada = $db->prepare($consultaFinal);
            $preparada->execute();
            
            /*Utilizamos el método fetchAll() para obtener todos los
            resultados de la consulta como un arreglo. 
            Después, se recorre el arreglo utilizando el foreach
            para mostrar los resultados en forma de imágenes. 
            
            PDO::FETCH_ASSOC se pueden obtener los resultados de la 
            consulta de manera más legible y fácil de manejar*/
            $resultados = $preparada->fetchAll(PDO::FETCH_ASSOC);
            $preparada->closeCursor();

            $hayResultados = !empty($resultados); // Variable para verificar si hay resultados

            foreach ($resultados as $row){
                
                echo "<tr>
                <th scope=\"row\">";
                ?>
                    <!-- Condicional para que cuando no tenga imagen no se pase de binario a foto -->
                    <?php
                        if($row['ruta_imagen'] != NULL){
                    ?>
                            <img src=data:image/jpg;base64,<?php echo base64_encode($row["ruta_imagen"])?>  style="width: 50px;"/>
                    <?php
                        }
                    ?>
                   
                <?php 
                echo "</th>
                <td>". $row["codigo"] ."</td>
                <td>". $row["fecha_alta"] ."</td>
                <td>". $row["num_serie"] ."</td>
                <td>". $row["nombre"] ."</td>
                <td>". $row["descripcion"] ."</td>
                <td>". $row["unidades"] ."</td>
                <td>". $row["localizacion"] ."</td>
                <td>". $row["procedencia_entrada"] ."</td>
                <td>". $row["motivo_baja"] ."</td>
                <td>". $row["fecha_baja"] ."</td>";
                // Botones para poder editar un articulo o borrarlo
                echo '<td>
                        <a href="editarMaterial.php?cod='.$row["codigo"].'" class="text-decoration-none p-1"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    <td>
                        <a href="confirmarDelete.php?cod='.$row["codigo"].'" class="text-decoration-none p-1"><i class="bi bi-trash3"></i></a>
                    </td>';
                    // FUNCIÓN PARA PONER ICONO DE PEDIR O NO PEDIR
                    // SOLO PARA ARTICULOS FUNGIBLES
                    $consulta = "SELECT Articulos.codigo FROM Articulos INNER JOIN Fungibles WHERE Articulos.codigo = Fungibles.codigo;";
                    $consulta = $db->query($consulta);
                    foreach ($consulta as $row01) {
                        if($row01['codigo'] == $row['codigo']) {
                            // CONSULTA PARA SABER SI EN LA BASE DE DATOS ESTA PEDIR A SI O PEDIR A NO
                            $consulta = "SELECT * FROM Fungibles WHERE codigo = ?";
                            $consulta = $db->prepare($consulta);
                            $consulta->execute(array($row01['codigo']));
                            foreach ($consulta as $key) {
                                $pedir = $key['pedir'];
                            }
                            // SI EN LA BASE DE DATOS SE ENCUENTRA EN NO SE PONDRA EL ICONO DE NO PEDIDO
                            if($pedir == 'no') {
                                echo '<td>
                                    <a href="pedirArticulo.php?cod='.$row01['codigo'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue;" id="nopedido" name="nopedido"><i class="bi bi-cart-dash"></i></a>
                                    <a href="pedirArticulo.php?cod='.$row01['codigo'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue; display: none;" id="pedido" name="pedido"><i class="bi bi-cart-check"></i></a>';
                                echo '</td>'; 
                            // SI EN LA BASE DE DATOS SE ENCUENTRA EN SI SE PONDRA EL ICONO DE PEDIDO
                            } else if ($pedir == 'si') {
                                echo '<td>
                                    <a href="pedirArticulo.php?cod='.$row01['codigo'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue; display: none;" id="nopedido" name="nopedido"><i class="bi bi-cart-dash"></i></a>
                                    <a href="pedirArticulo.php?cod='.$row01['codigo'].'" class="text-decoration-none p-1" style="margin-left: 0px; color: blue; " id="pedido" name="pedido"><i class="bi bi-cart-check"></i></a>';
                                echo '</td>'; 
                            }
                            
                        }
                    }

                    // SI SE ENCUENTRA INICIALIZADO A TRAVES DEL METODO GET 'PEDIR' Y A LA VEZ ES IGUAL A NO
                    // EL ICONO DE NO PEDIDO DESAPARECE Y EL DE PEDIDO APARECE
                    if(isset($_GET['pedir']) && $_GET['pedir'] == 'no') {
                    ?>
                        <script type='text/javascript'> 
                            document.getElementById('nopedido').style.display = 'none';
                            document.getElementById('pedido').style.display = 'block';
                        </script>
                    <?php
                    // SI SE ENCUENTRA INICIALIZADO A TRAVES DEL METODO GET 'PEDIR' Y A LA VEZ ES IGUAL A SI
                    // EL ICONO DE NO PEDIDO APARECE Y EL DE PEDIDO DESAPARECE
                    } else if (isset($_GET['pedir']) && $_GET['pedir'] == 'si') {
                    ?>
                        <script type='text/javascript'> 
                            document.getElementById('nopedido').style.display = 'block';
                            document.getElementById('pedido').style.display = 'none';
                        </script>
                    <?php
                    }
                echo '</tr>';
                
            }
            // echo $count;
            // echo $numeroPagina;

            // Si no hay resultado al hacer la consulta se muestra mensaje indicativo
            if (!$hayResultados) {
                echo '
                    <tr>
                        <td colspan="13">
                            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    No se encontró ningún resultado
                                </div>
                            </div>
                        </td>
                    </tr>
                ';
            }
          
            return TRUE;
        } catch (PDOException $e) {
            echo "Error en la base de datos " . $e->getMessage();
            return FALSE;
        }
    }
    
    // Funcion que pinta el paginador al mostrar los articulos
    function pintarPaginador($consultaCount,$filtro,$numeroPagina=0,$dpto_seleccionado=0){
        require "../../archivosComunes/conexion.php";
        try {
            $db = new PDO($conexion, $usuario, $password);
            $preparadaCount = $db->prepare($consultaCount);
            $preparadaCount->execute();
            $count=0;

            // Si la consulta nos devuelve cosas guardamos el total de los articulos
            if($preparadaCount->rowCount() > 0) {
                
                $count = $preparadaCount->fetch()[0];
            }
            
            $preparadaCount->closeCursor();
            $itemsPagina = 10;
            $page_count = ceil(($count)/$itemsPagina);
            echo '<div class="block-27" style="margin-top: 50px; margin-bottom: 50px; display: flex; justify-content: center;">
                <ul class="pagination" id="paginador" style="padding: 0; margin: 0;">';
            // calculamos la primera y última página a mostrar
           
            $primera = ($numeroPagina +1) - (($numeroPagina +1) % 10) + 1;
            if ($primera > ($numeroPagina +1)) { $primera = $primera - 10; }
            $ultima = $primera + 9 > $page_count ? $page_count : $primera + 9; 
            if ($primera > 1){
                   if($dpto_seleccionado != 0) {
                        echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a  href="lista.php?filtro='.$filtro.'&codigo='.$dpto_seleccionado.'&page=' . ($primera-2) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                            display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;"  aria-label="Previous">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                                display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                                box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;"aria-hidden="true">&laquo;</span></a></li>';
                    } else {
                    echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a  href="lista.php?filtro='.$filtro.'&page=' . ($primera-2) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                            display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;" aria-label="Previous">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                                display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                                box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;"aria-hidden="true">&laquo;</span></a></li>';
                    }

            }

             for ($i = $primera - 1; $i < $ultima; $i++) {

                if ($i == $numeroPagina) { // esta es la pagina actual
                    // Si el dpto que nos llega es distinto de cero le mandamos por metodo get que departamento se debe mostrar
                    if($dpto_seleccionado != 0) {
                        echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a  href="lista.php?filtro='.$filtro.'&codigo='.$dpto_seleccionado.'&page=' . ($i) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                            display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                                display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                                box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">'.($i+1).'</span></a></li>';
                    } else {
                    echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a  href="lista.php?filtro='.$filtro.'&page=' . ($i) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                            display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                                display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                                box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;">'.($i+1).'</span></a></li>';
                    }
                } else { // mostrar enlace a otra página
                    if($dpto_seleccionado != 0){
                    echo '<li style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a href="lista.php?filtro='.$filtro.'&codigo='.$dpto_seleccionado.'&page=' .($i) . '" class="page_link" style="text-align: center;
                            margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">'.($i+1).'</span>
                            </a>
                        </li>';
                    } else {
                        echo '<li style="display: inline-block; font-weight: 400; margin-left: 5px;">
                            <a href="lista.php?filtro='.$filtro.'&page=' .($i) . '" class="page_link" style="text-align: center;
                            margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">
                                <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales); display: inline-block;">'.($i+1).'</span>
                            </a>
                        </li>';
                    }
                    // echo '<a href="lista.php?filtro='.$filtro.'&page=' . $i . '">Page ' . $i . '</a><br>';
                }
             }
             if ($numeroPagina < $page_count-1 ) {
                if($dpto_seleccionado != 0) {
                     echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                         <a  href="lista.php?filtro='.$filtro.'&codigo='.$dpto_seleccionado.'&page=' . ($numeroPagina+10) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                         display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                         box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;"  aria-label="Previous">
                             <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                             display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                             box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;"aria-hidden="true">&raquo;</span></a></li>';
                 } else {
                 echo '<li class="active" style="display: inline-block; font-weight: 400; margin-left: 5px;">
                         <a  href="lista.php?filtro='.$filtro.'&page=' . ($numeroPagina+10) . '" class="page_link" style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                         display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                         box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;" aria-label="Previous">
                             <span style="text-align: center; margin: 0; width: 40px; height: auto; line-height: 30px; color: var(--gris-senales);
                             display: inline-block; background-image: linear-gradient(to right, rgba(106, 17, 203, 1) 0%, rgba(37, 117, 252, 1) 100%);
                             box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2); color: white; transition: 0.3s linear;"aria-hidden="true">&raquo;</span></a></li>';
                 }

         }
             echo '</ul> <div>';

            return TRUE;
        } catch (PDOException $e) {
            echo "Error en la base de datos " . $e->getMessage();
            return FALSE;
        }
    }
?>



