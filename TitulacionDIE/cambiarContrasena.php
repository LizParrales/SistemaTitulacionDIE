<?php
 	require_once('CLASSES/class.ConexionBD.php');

	session_start();
	if(!isset($_SESSION['usuarioAlu'])){
		session_destroy();
		header('Location: index.php');
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Sistema de Titulaci&oacute;n</title>
</head>

<body>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<div id="contenido">
		<div id="header">
			<div id="imagen"></div>
	<nav>
		<ul>
			<li><a href="alumno.php">Inicio</a></li>
			<li><a href='salir.php'>Salir</a></li>
			<li style="float:right"><a href="cambiarContrasena.php">Cambiar contrase&ntilde;a</a></li>
		</ul>
	</nav>
		</div>
		<div id="info">
			<form method="post" action="cambioContrasena.php" class="clase-form">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><h3>Cambio de contrase&ntilde;a</h3></div>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Contrase&ntilde;a actual</div>
						<input class="form-control" type="password" name="actual" id="actual" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Nueva contrase&ntilde;a</div>
						<input class="form-control" type="password" name="nueva" id="nueva" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Confirmar nueva contrase&ntilde;a</div>
						<input class="form-control" type="password" name="reNueva" id="reNueva" />
					</div>
				</div><br />
				<input name="cambiarContrasena" type="submit" value="Cambiar contrase&ntilde;a" class="btn btn-default" /> <input name="limpiar" type="reset" value="Limpiar formulario" class="btn btn-default" />
				<br />
				<?php
					if(isset($_SESSION['MSG'])){
						echo($_SESSION['MSG']);
						unset($_SESSION['MSG']);
					}
				?>
			</form>
		</div>
		<div id="footer">
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>
