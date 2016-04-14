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
			<li><a href="mostrarAlumnos.php">Todos los alumnos</a></li>
			<li><a href="busquedaAlumnos.php">Busqueda alumnos</a></li>
			<li><a href='salir.php'>salir</a></li>
		</ul>
	</nav>
		</div>
		<div id="info">
			<table>
				<thead>
				<tr>
					<th>Nombre</th>
					<th>No. Cuenta</th>
					<th>Correo</th>
					<th>Avance de creditos</th>
					<th>Semestre de ingreso</th>
					<th>Promedio</th>
					<th>Servicio social</th>
					<th>Comprensi&oacute;n de lectura del ingl&eacute;s</th>
					<th>Opcion de titulaci&oacute;n</th>
					<th>Maestr&iacute;a</th>
					<th>Doctorado</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
					$cx = $cbd->crearConexion();
	
					$sqlAlu = "SELECT * FROM alumno WHERE vigente = '1'";
					$resultado = pg_query($sqlAlu) or die(pg_last_error($cx));
					if($arr = pg_fetch_all($resultado)){
						foreach($arr as $v){
						   if($v['avance_creditos'] >= 60){
							echo("<tr>");
							echo("<td>".$v['nombre']."</td>");
							echo("<td>".$v['no_cuenta']."</td>");
							echo("<td>".$v['correo']."</td>");
							echo("<td>".$v['avance_creditos']."</td>");
							echo("<td>".$v['sem_registro']."</td>");
							echo("<td>".$v['promedio']."</td>");
							echo("<td>");
							if($v['servicio_social']!='falta'){
								$sqlSS = "SELECT id_ss FROM alumno_ss WHERE alumno_no_cuenta = ".$v['no_cuenta'];
								$res = pg_query($sqlSS);
								if($idSS = pg_fetch_array($res))
									echo("<a href=\"archivoSS.php?id=".$idSS['id_ss']."&cuenta=".$v['no_cuenta']."\">Carta de terminaci&oacute;n</a>");
							}else echo("--");
							echo("</td>");
							echo("<td>");
							if($v['comp_ingles']=='t'){
								$sqlEN = "SELECT id FROM alumno_ingles WHERE alumno_no_cuenta = ".$v['no_cuenta'];
								$res = pg_query($sqlEN);
								if($idEN = pg_fetch_array($res))
								echo("<a href=\"archivoEn.php?id=".$idEN['id']."&cuenta=".$v['no_cuenta']."\">Carta de terminaci&oacute;n</a>");
							}
							echo("</td>");
							$opT = pg_query("SELECT nombre FROM opcion_titulacion INNER JOIN alumno_opcion_titulacion ON alumno_opcion_titulacion.opcion_titulacion_clave = opcion_titulacion.clave WHERE alumno_opcion_titulacion.alumno_no_cuenta = ".$v['no_cuenta']);
							if($res = pg_fetch_array($opT))
								$opcionT = $res['nombre'];
							else $opcionT = "No seleccionada";
							echo("<td>$opcionT</td>");
							
							echo("<td>".$v['maestria']."</td>");
							echo("<td>".$v['doctorado']."</td>");
							echo("</tr>");
						   }
						}
					}
				?>
			</tbody>
		</table>
		</div>
		<div id="footer">
		</div>
	</div>
	
</body>

</html>
