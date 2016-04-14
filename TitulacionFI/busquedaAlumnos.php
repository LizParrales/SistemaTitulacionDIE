<?php
 	require_once('CLASSES/class.ConexionBD.php');
	session_start();
	if(isset(!isset($_SESSION['usuarioProf']))){
		session_destroy();
		header('Location: index.php');
	}
	
	function getCurrentUrl(){  
  		$domain = $_SERVER['HTTP_HOST'];  
  		$url = "http://" . $domain . $_SERVER['REQUEST_URI'];  
  		return $url;  
 	} 
 	
 	$_SESSION['url'] = getCurrentUrl();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title>Sistema de titulaci&oacute;n</title>
</head>

<body>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />

	<div id="contenido">
		<div id="header">
			<div id="imagen">
				<h1>Sistema de Informaci&oacute;n de Alumnos Proximos a Titularse</h1>
			</div>
			<nav>
				<ul>
					<li><a href="profesor.php">Inicio</a></li>
					<li><a href="busquedaAlumnos.php">Busqueda alumnos</a></li>
					<li><a href="salir.php">salir</a></li>
					<li style="float:right"><a href="alumnos.csv">Descargar archivo</a></li>
				</ul>
			</nav>
		</div>
		<div id="info">
			<h2>
				<?php
					echo("Bienvenid@ profesor(a) ".$_SESSION['usuarioProf']);
				?>
			</h2>
			<h3>Busqueda de alumnos</h3>
				<h4>Filtros</h4>
				<form method="post">
				
					<label>Avance de cr&eacute;ditos</label>
					<select name="avance">
						<option value="">Todo</option>
						<option value = '70'>60 - 70</option>
						<option value = '80'>70 - 80</option>
						<option value = '90'>80 - 90</option>
						<option value = '100'>90 - 100</option>
					</select>
				
					<label>Servicio social</label>
					<select name="ssocial">
						<option value="">Todo</option>
						<option value = 'falta'>No cubierto</option>
						<option value = 'en_curso'>En curso</option>
						<option value = 'terminado'>Terminado</option>
					</select>
					
					<label>Comprension de lectura</label>
					<select name="cIngles">
						<option value="">Todo</option>
						<option value = 'f'>No cubierto</option>
						<option value = 't'>Cubierto</option>
					</select>
					
					<label>Opci&oacute;n de titulaci&oacute;n</label>
					<select name="opTitulacion">
						<option value="">Todo</option>
						<option value = 'f'>No elegida</option>
						<option value = 't'>Elegida</option>
					</select>
					
					<input name="buscar" type="submit" value="buscar" />
				</form>
				<table class="table table-condensed table-bordered table-responsive">
				<thead>
				<tr>
					<th>Nombre</th>
					<th>No. Cuenta</th>
					<th>Semestre de ingreso</th>
					<th>Avance de creditos</th>
					<th>Promedio</th>
					<th>Carrera</th>
					<th>Correo</th>
					<th>Telefono</th>
					<th>Servicio social</th>
					<th>Ingl&eacute;s</th>
					<th>Opcion de titulaci&oacute;n</th>
					<th>Maestr&iacute;a</th>
					<th>Doctorado</th>
				</tr>
			</thead>
			<tbody>

					<?php
						if(isset($_POST['buscar'])){
							require("busquedaAlu.php");
						}
					?>
			</tbody>
		</table>
		</div>
		<div id="footer">
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>
