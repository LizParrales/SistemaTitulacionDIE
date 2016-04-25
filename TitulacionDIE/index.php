<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
    session_start();
?>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Sistema de Titulaci&oacute;n</title>
</head>
<body>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/login.css" rel="stylesheet" type="text/css" />
	<div id="login">
		<h1>Inicio de Sesi&oacute;n</h1>
		<h3>Por favor ingrese sus datos para iniciar sesi&oacute;n</h3>
		<form method="post" action="inicioSesion.php">
			<label>Usuario</label><input name="usr" type="text" />
			<label>Contrase&ntilde;a</label><input name="pass" type="password" />
			<input name="ingresar" type="submit" value="Ingresar" class="btn btn-default" />
			
		</form>
		<?php
			if(isset($_SESSION['MSG'])){
				echo($_SESSION['MSG']);
				unset($_SESSION['MSG']);
			}
		?>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	
</body>
</html>
