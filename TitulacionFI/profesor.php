<?php

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
					<li><a href='salir.php'>salir</a></li>
				</ul>
			</nav>
		</div>
		<div id="info">
			<h2>
				<?php
					echo("Bienvenid@ profesor(a) ".$_SESSION['usuarioProf']);
				?>
			</h2>

		</div>
		<div id="footer">
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
</body>

</html>
