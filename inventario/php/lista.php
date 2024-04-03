<?php
    session_start(); 
	// Si no se ha inicializado la sesion se le redirige al login
	if(!isset($_SESSION["usuario_login"])){
        header("Location: ../../index.php?redirigido=true");
    };
    require_once('../../archivosComunes/conexion.php');
	// si se ha inicializado el boton de buscar se recoge el valor y se realiza la consulta
    if(isset($_POST['boton_buscar'])){
        $buscar = $_POST["buscar"];
        $codigo = array();
        $consultaBuscar = "SELECT * FROM Articulos WHERE nombre LIKE '%".$buscar."%' OR descripcion LIKE '%".$buscar."%' OR localizacion LIKE '%".$buscar."%' ";
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Listar Material</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<!-- <link rel="stylesheet" type="text/css" href="../inventario/css/index.css"> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	
	<style>
        
        .form-label {
            margin-bottom: 0;
            margin-top: 10px;
        }

        input {
            margin-top: 0;
        }

        .shadow-blue {
            box-shadow: 0 .5rem 1rem rgba(0, 123, 255, .2) !important;
        }

        input[type="file"]::-webkit-file-upload-button {
            background-color: #0d6efd;
            color: white;

        }

        input[type="file"]:hover {
            color: #0d6efd !important;
            background-color: white;
        }

        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }

        .btn {
            width: 100px;
            height: 40px;
        }

        html {
            min-height: 100%;
            position: relative;
            box-sizing: border-box;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 20px;
        }
		.container-fluid{
			padding: 0px!important;
		}

        .main-content {
            min-height: calc(100vh - 100px);
            /* Resta el tamaño del footer al alto total de la ventana */
            padding-bottom: 100px;
            /* Asegura que el contenido no tape con el footer */
        }

        .main-form {
        min-height: calc(100vh - 180px); /* Resta el tamaño del footer al alto total de la ventana */
        }

		form fieldset {
			display: flex;
		}

		form fieldset ul{
			list-style: none;
			display: flex;
		}

		form fieldset select {
			height: 40px;
			margin-top: 10px;
		}

		form fieldset ul li {
			margin-right: 10px;
			margin-top: 20px;
		}

		form fieldset .btn {
			margin-left: 10px;
			margin-top: 10px;
		}

		.buscador input {
			width: 600px;
		}

		footer .row {
            padding: 0;
        }
        footer p {
            margin-bottom: 0;
        }

        @media screen and (max-width: 768px) {
            .texto-footer {
                font-size: 14px;
            }

			.btn-container {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .btn-container .btn {
                margin-bottom: 10px;
                width: 100%;
            }

			.main-form{
				padding-bottom: 100px;
			}
        }

        
    </style>
</head>

<body>
<header class="gradient-custom ">
		<nav class="navbar navbar-expand navbar-light p-3 me-5 ms-5">
			<a class="navbar-brand text-light" href="../index.php">Inventario</a>
			<ul class="navbar-nav flex-row flex-wrap text-light ms-auto">
			<li class="nav-item">
      <a class="text-light btn btn-outline-secondary me-2"  style="width: 300px;" href="../../archivosComunes/actualizarUsuario.php?idusuario=<?php echo $_SESSION['usuario_login']['cod_usuario']?>">
      <span class="d-flex">
          <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>&nbsp;
                <?php echo $_SESSION['usuario_login']['nombre'].' '.$_SESSION['usuario_login']['apellidos'] ?>
      </span>                 
  </a>
  </li> 
				<li class="nav-item dropdown"><i id="iniciar_sesion" class="bi bi-person
								nav-link dropdown text-light" role="button" data-bs-toggle="dropdown" style="text-align: right;"> Mi
						cuenta</i>
					<ul class="dropdown-menu dropdown-menu-end">

						<a class="dropdown-item" href="../../archivosComunes/selector.php">Página Principal</a>
						<a class="dropdown-item" href="../../archivosComunes/logout.php">Cerrar
							sesión</a>
					</ul>
				</li>
			</ul>
		</nav>
	</header>


	<!-- cuerpo -->
	<div class="container-fluid main-content ">
		<!-- filtros -->
		<div class="main-form">
					<form method="post" action="cookieFiltro.php">
	
						<fieldset name="filtro" id="filtro">
						<div class="row w-75">
							<div class="col-md-6">		
								<!-- FILTRO FUNGIBLE -->
								<ul>
									<li>
										<input type="radio" name="filtro" value="todos" <?php if(!isset($_GET['filtro']) || (isset($_GET['filtro']) && $_GET['filtro'] == "todos")) echo 'checked'; ?>> Todos
									</li>
									<li>
										<input type="radio" name="filtro" value="fungibles" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "fungibles") echo 'checked'; ?>> Fungibles
									</li>
									<li>
										<input type="radio" name="filtro" value="fungiblespedir" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "fungiblespedir") echo 'checked'; ?>> Pedir Fungibles
									</li>
									<li>
										<input type="radio" name="filtro" value="nofungibles" <?php if(isset($_GET['filtro']) && $_GET['filtro'] == "nofungibles") echo 'checked'; ?>> No Fungibles
									</li>
								</ul>
								
							</div>
							<div class="col-md-6 d-flex align-items-center">		
								<!-- FILTRO DEPARTAMENTO -->
								<?php
									// session_start();
									if($_SESSION['usuario_login']['rol'] == 0){
								?>
									<select class="form-control" id="filtro_departamento" name="filtro_departamento" style="width: 300px; margin-left: 2rem;">
										<option value="0">Todos</option>
										<!-- Sacamos todos los departamentos que se encuentren en la base de datos -->
										<?php 
										require_once('../../archivosComunes/conexion.php');
										$consulta = "SELECT * FROM Departamentos";
										$resultado = $db->query($consulta);

										foreach ($resultado as $row) {
											echo '<option value="'.$row['codigo'].'">'.$row['nombre'].'</option>';
										}
										?>
									</select>

									<!-- Si se ha inicializado por metodo get codigo, es decir, el departamento se envia por un input oculto el codigo de departamento -->
									<?php
										if(isset($_GET['codigo'])){
									?>
										<input type="hidden" name="filtro_dpto" id="filtro_dpto" value="<?php echo $_GET['codigo'] ?>">
									<?php } ?>
								<?php } ?>
								
								<input class="btn gradient-custom shadow" style="color: white" name="aplicar_filtros" id="aplicar_filtros" type="submit" value="Filtrar">
							</div>
						</div>
						</fieldset>
					</form>
				
			
			<div class="row container">
				<div class="col-12" style="padding-left: 2rem;">
					<form class="buscador d-flex mt-3 w-25" method="POST" action="buscar.php">
						<input class="form-control me-2" type="search" id="buscar" name="buscar" placeholder="Buscar" aria-label="Buscar">
						<button class="btn btn-outline-light gradient-custom shadow" type="submit" id="boton_buscar" name="boton_buscar"><i class="bi bi-search"></i></button>
					</form>
				</div>
			</div>
			
			
			<!-- tabla -->
			<div  style="padding-left:10px; padding-right: 10px;"  id="tablaArticulos" >
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr class="texto-table">
								<th scope="col">Imagen</th>
								<th scope="col">codigo</th>
								<th scope="col">Fecha Alta</th>
								<th scope="col">Número de Serie</th>
								<th scope="col">Nombre</th>
								<th scope="col">Descripción</th>
								<th scope="col">Unidades</th>
								<th scope="col">Localización</th>
								<th scope="col">Procedencia</th>
								<th scope="col">Motivo baja</th>
								<th scope="col">Fecha baja</th>
								<th scope="col">
									<?php
										// Si el usuario es administrador se añade el boton del pdf mandandole con el codigo de departamento
										if($_SESSION['usuario_login']['rol'] == 0){
									?>
											<a href='exportarPDF.php?codDepartamento=<?php if(isset($_GET['codigo'])){echo $_GET['codigo']; } else { echo "todos"; } ?>' target="_blank">
												<i class="bi bi-filetype-pdf"></i>
											</a>
									<?php 
										// Si el usuario es profesor se añade el boton del pdf mandandole sin el codigo de departamento
										} else if($_SESSION['usuario_login']['rol'] == 1){
									?>
											<a href='exportarPDF.php' target="_blank">
												<i class="bi bi-filetype-pdf"></i>
											</a>
									<?php 
										} 
									?>
								</th>
							</tr>
						</thead>
						<tbody id="tbodyy">
							<?php
							require_once "./funcionesBBDD.php";
							$pagina = isset($_GET['page'])?$_GET['page']:0;

							// Cuando el usuario sea un administrador
							if($_SESSION['usuario_login']['rol'] == 0){
								// Si esta inicializado el filtro de todos los articulos y el de codigo del departamento
								// Mostraremos todos los articulos del departamento especifico 
								if (isset($_GET['filtro']) && $_GET['filtro'] == "todos" && isset($_GET['codigo'])) {
									$codigo_departamento = $_GET['codigo'];
									consultarDatos('SELECT a.* FROM Articulos a
													INNER JOIN Tiene t ON a.codigo = t.cod_articulo
													INNER JOIN Departamentos d ON t.cod_departamento = d.codigo
													WHERE d.codigo = '.$codigo_departamento, $pagina);
								// Si esta inicializado el filtro de fungibles y el de codigo del departamento no esta inicializado
								// Mostraremos todos los articulos fungibles de todos los departamentos
								} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && !isset($_GET['codigo'])) {
									consultarDatos('SELECT a.* FROM Articulos a, Fungibles f WHERE a.codigo = f.codigo', $pagina);
								// Si esta inicializado el filtro de fungibles y el de codigo del departamento
								// Mostraremos todos los articulos fungibles del departamento especificado
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && isset($_GET['codigo'])){
									$codigo_departamento = $_GET['codigo'];
										consultarDatos('SELECT * FROM Articulos
														INNER JOIN Tiene 
														ON Articulos.codigo = Tiene.cod_articulo 
														INNER JOIN Fungibles
														ON Articulos.codigo = Fungibles.codigo
														WHERE Tiene.cod_departamento = '.$codigo_departamento, $pagina);
								// Si esta inicializado el filtro de fungibles a pedir y el de codigo del departamento no esta inicializado
								// Mostraremos todos los articulos fungibles a pedir de todos los departamentos
								} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && !isset($_GET['codigo'])) {
									consultarDatos('SELECT * FROM Articulos 
														INNER JOIN Tiene 
														ON Articulos.codigo = Tiene.cod_articulo 
														INNER JOIN Fungibles
														ON Articulos.codigo = Fungibles.codigo
														WHERE Fungibles.PEDIR = "si"', $pagina);
								// Si esta inicializado el filtro de fungibles a pedir y el de codigo del departamento
								// Mostraremos todos los articulos fungibles a pedir del departamento especificado
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && isset($_GET['codigo'])){
									$codigo_departamento = $_GET['codigo'];
										consultarDatos('SELECT * FROM Articulos
														INNER JOIN Tiene 
														ON Articulo.codigo = Tiene.cod_articulo 
														INNER JOIN Fungibles
														ON Articulos.codigo = Fungibles.codigo
														WHERE Fungibles.pedir = "si"
														AND Tiene.cod_departamento = '.$codigo_departamento, $pagina);
								// Si esta inicializado el filtro de no fungibles y el de codigo del departamento no esta inicializado
								// Mostraremos todos los articulos no fungibles de todos los departamentos
								} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && !isset($_GET['codigo'])) {
									consultarDatos('SELECT a.* FROM Articulos a, Nofungibles f WHERE a.codigo = f.codigo', $pagina);
								// Si esta inicializado el filtro de no fungibles y el de codigo del departamento
								// Mostraremos todos los articulos no fungibles del departamento especificado
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && isset($_GET['codigo'])){
									$codigo_departamento = $_GET['codigo'];
									consultarDatos('SELECT * FROM Articulos 
														INNER JOIN Tiene 
														ON Articulos.codigo = Tiene.cod_articulo 
														INNER JOIN Nofungibles
														ON Articulos.codigo = Nofungibles.codigo
														WHERE Tiene.cod_departamento = '.$codigo_departamento, $pagina);
								// SI no es ninguna de las opciones anteriores, saca todos los articulos de todos los departamentos
								} else {
									consultarDatos('SELECT * FROM Articulos',$pagina);
								}
							
							// Si el usuario es profesor solo podra filtrar por fungibles, no fungibles etc
							} else if($_SESSION['usuario_login']['rol'] == 1) {
								// Si no esta inicializado a traves del metodo get el filtro mostrara todos los articulos del codigo de su departamento
								if(!isset($_GET['filtro'])){
									consultarDatos('SELECT * FROM Articulos INNER JOIN Tiene WHERE Articulos.codigo = Tiene.cod_articulo AND Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],$pagina);
								// Si esta inicializado a traves del metodo get el filtro todos mostrara todos los articulos del codigo de su departamento
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'todos'){
									consultarDatos('SELECT * FROM Articulos INNER JOIN Tiene WHERE Articulos.codigo = Tiene.cod_articulo AND Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],$pagina);
								// Si esta inicializado a traves del metodo get el filtro fungibles mostrara todos los articulos fungibles del codigo de su departamento
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
									consultarDatos('SELECT * FROM Articulos INNER JOIN Tiene ON Articulos.codigo = Tiene.cod_articulo INNER JOIN Fungibles ON Articulos.codigo = Fungibles.codigo WHERE Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],$pagina);
								// Si esta inicializado a traves del metodo get el filtro fungibles a pedir mostrara todos los articulos fungibles a pedir del codigo de su departamento
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir') {
									consultarDatos('SELECT * FROM Articulos INNER JOIN Tiene ON Articulos.codigo = Tiene.cod_articulo INNER JOIN Fungibles ON Articulos.codigo = Fungibles.codigo WHERE Fungibles.pedir = "si" AND Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],$pagina);
								// Si esta inicializado a traves del metodo get el filtro no fungibles a pedir mostrara todos los articulos no fungibles a pedir del codigo de su departamento
								} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
									consultarDatos('SELECT * FROM Articulos INNER JOIN Tiene ON Articulos.codigo = Tiene.cod_articulo INNER JOIN Nofungibles ON Articulos.codigo = Nofungibles.codigo WHERE Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],$pagina);
								}
							}
							?>
						</tbody>
					</table>	
				</div>
				<!-- paginador -->
				<div style="padding-bottom: 200px;">
					<?php
						require_once "./funcionesBBDD.php";
						$pagina = isset($_GET['page'])?$_GET['page']:0;
						// Si el usuario es administrador
						if($_SESSION['usuario_login']['rol'] == 0){
							// SE REALIZAN LAS MISMAS COMPROBACIONES QUE AL CONSULTAR LOS DATOS PERO LLAMANDO A LA FUNCION DE PINTAR PAGINADOR PARA QUE REALICE EL MISMO
							if (isset($_GET['filtro']) && $_GET['filtro'] == "todos" && isset($_GET['codigo'])) {
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(a.codigo) FROM Articulos a 
												INNER JOIN Tiene t 
												ON a.codigo = t.cod_articulo 
												INNER JOIN Departamentos d 
												ON t.cod_departamento = d.codigo 
												WHERE d.codigo = '.$codigo_departamento, 'todos', $pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'todos' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(*) FROM Articulos','todos',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && isset($_GET['codigo'])){
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos 
												INNER JOIN Tiene 
												ON Articulos.codigo = Tiene.cod_articulo 
												INNER JOIN Fungibles
												ON Articulos.codigo = Fungibles.codigo
												WHERE Tiene.cod_departamento = '.$codigo_departamento.';','fungibles',$pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(a.codigo) FROM Articulos a, Fungibles f WHERE a.codigo = f.codigo','fungibles',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && isset($_GET['codigo'])){
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos 
												INNER JOIN Tiene 
												ON Articulos.codigo = Tiene.cod_articulo 
												INNER JOIN Fungibles
												ON Articulos.codigo = Fungibles.codigo
												WHERE Fungibles.PEDIR = "si"
												AND Tiene.cod_departamento = '.$codigo_departamento,'fungiblespedir',$pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos 
												INNER JOIN Tiene 
												ON Articulos.codigo = Tiene.cod_articulo 
												INNER JOIN Fungibles
												ON Articulos.codigo = Fungibles.codigo
												WHERE Fungibles.PEDIR = "si"','fungiblespedir',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && isset($_GET['codigo'])){
								$codigo_departamento = $_GET['codigo'];
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos 
												INNER JOIN Tiene 
												ON Articulos.codigo = Tiene.cod_articulo 
												INNER JOIN Nofungibles
												ON Articulos.codigo = Nofungibles.codigo
												WHERE Tiene.cod_departamento = '.$codigo_departamento.';','nofungibles',$pagina, $codigo_departamento);
							} else if (isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles' && !isset($_GET['codigo'])) {
								pintarPaginador('SELECT COUNT(a.codigo) FROM Articulos a, Nofungibles f WHERE a.codigo = f.codigo','nofungibles',$pagina);
							} else {
								pintarPaginador('SELECT COUNT(*) FROM Articulos','todos',$pagina);
							}
						} else if($_SESSION['usuario_login']['rol'] == 1) {
							// consultarDatos('SELECT * FROM articulo INNER JOIN tiene WHERE ARTICULO.codigo = TIENE.cod_articulo AND tiene.cod_departamento = '.$_SESSION['usuario_login']['DEPARTAMENTO'].';');
							if(!isset($_GET['filtro'])){
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos INNER JOIN Tiene WHERE Articulos.codigo = Tiene.cod_articulo AND Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],'todos', $pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'todos'){
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos INNER JOIN Tiene WHERE Articulos.codigo = Tiene.cod_articulo AND Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],'todos',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungibles') {
								pintarPaginador('SELECT COUNT(Articulos.codigo)  FROM Articulos INNER JOIN Tiene ON Articulos.codigo = Tiene.cod_articulo INNER JOIN Fungibles ON Articulos.codigo = Fungibles.codigo WHERE Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],'fungibles',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'fungiblespedir') {
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos INNER JOIN Tiene ON Articulos.codigo = Tiene.cod_articulo INNER JOIN Fungibles ON Articulos.codigo = Fungibles.codigo WHERE Fungibles.pedir = "si" AND Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],'fungiblespedir',$pagina);
							} else if(isset($_GET['filtro']) && $_GET['filtro'] == 'nofungibles') {
								pintarPaginador('SELECT COUNT(Articulos.codigo) FROM Articulos INNER JOIN Tiene ON Articulos.codigo = Tiene.cod_articulo INNER JOIN Nofungibles ON Articulos.codigo = Nofungibles.codigo WHERE Tiene.cod_departamento = '.$_SESSION['usuario_login']['departamento'],'nofungibles', $pagina);
							} 
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<footer class="gradient-custom p-3">
		<div class="container text-light">
			<div class="row">
				<div class="col-12 text-center">
					<p>IES JULIO VERNE <br>Curso(2022-2023)&#169;</p>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-md-6">
					<p>Creado por: <br> Brenda Serafín Camara <br> Daniel Andrés Bravo</p>
				</div>
				
				<div class="col-md-6">
					<p>Javier Díaz Marcos <br> Nera Domínguez Alcalde <br> Raúl Gómez Hernández</p>
				</div>
			</div>
		</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" 
		crossorigin="anonymous"></script>
	<script src="../js/exportarPDF.js"></script>
</body>

</html>