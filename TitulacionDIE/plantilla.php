<?php
 	require_once('CLASSES/class.ConexionBD.php');

	session_start();
	if($_SESSION['perfil']!='Profesor'){
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
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<div id="contenido">
		<div id="header">
			<div id="imagen"></div>
	<nav>
		<ul>
			<li><a href='salir.php'>salir</a></li>
		</ul>
	</nav>
		</div>
		<div id="info">
			<form method="post" action="cambioContrasena.php">
				<label>Contrase&ntilde;a actual</label><input type="text" name="actual" id="actual" />
				<label>Nueva contrase&ntilde;a</label><input type="text" name="nueva" id="nueva" />
				<label>Confirmar nueva contrase&ntilde;a</label><input type="text" name="reNueva" id="reNueva" />
				<input name="cambiarContrasena" type="submit" value="Cambiar contrase&ntilde;a" /><input name="limpiar" type="reset" value="Limpiar formulario" />
			</form>
		</div>
		<div id="footer">
		</div>
	</div>
	
</body>

</html>
