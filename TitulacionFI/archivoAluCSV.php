<?php
	session_start();
 	require_once('CLASSES/class.ConexionBD.php');
	if(!isset($_SESSION['usuarioAdmin'])){
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
			<div id="imagen"></div>
			<?php
				require("menuAdmin.php");
			?>
		</div>
		<div id="info">
			<?php
				echo("<h2>Bienvenid@ ".$_SESSION['usuarioAdmin']."</h2>");
			?>

			<form enctype="multipart/form-data" method="post" action="subirAlumnosCSV.php">
				<table>
					<tr>
						<td style="font-size:medium">Archivo</td>
						<td style="font-size:medium"><input name="fileCSV" type="file" /></td>
					</tr>
				</table>
				<br /><input name="archivoCSV" type="submit" value="Cargar datos" class="btn btn-default"/>
			</form>
			<?php
				if(isset($_SESSION['MSG'])){
					echo("<br /><p>".$_SESSION['MSG']."</p>");
					unset($_SESSION['MSG']);
				}
			?>
		</div>
		<div id="footer">
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>

</html>
