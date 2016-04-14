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
					<li><a href="mostrarAlumnos.php">Alumnos asignados</a></li>
					<li><a href="busquedaAlumnos.php">Busqueda alumnos</a></li>
					<li><a href='salir.php'>salir</a></li>
					<li style="float:right"><a href='alumnos.csv'>Descargar archivo</a></li>
				</ul>
			</nav>
		</div>
		<div id="info">
			<h2>
				<?php
					echo("Bienvenid@ profesor(a) ".$_SESSION['usuarioProf']);
				?>
			</h2>

			<h3>Alumnos asignados</h3>

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
				
					$fpCSV = fopen("alumnos.csv","w");
					fwrite($fpCSV, "Nombre;No. Cuenta;Semestre de ingreso;Avance de creditos;Promedio;Carrera;Correo;Telefono;Servicio social;Inglés;Opcion de titulacion;Maestria;Doctorado".PHP_EOL);
				
					$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
					$cx = $cbd->crearConexion();
	
					$sqlAlu = "SELECT * FROM alumno WHERE vigente = '1' AND profesor_no_trabajador = ".$_SESSION['no_t'];
					$resultado = pg_query($sqlAlu) or die(pg_last_error($cx));
					if($arr = pg_fetch_all($resultado)){
						foreach($arr as $v){
						   if($v['avance_creditos'] >= 60){
							echo("<tr>");
							echo("<td>".$v['nombre']."</td>");
							echo("<td>".$v['no_cuenta']."</td>");
							echo("<td>".$v['sem_registro']."</td>");
							echo("<td>".$v['avance_creditos']."</td>");
							echo("<td>".$v['promedio']."</td>");
							
							$renglonAlu = "{$v['nombre']};{$v['no_cuenta']};{$v['sem_registro']};{$v['avance_creditos']};{$v['promedio']};";
							
							$sqlCarr = "SELECT nombre FROM carrera WHERE clave = ".$v['carrera_clave'];
							$carrera = pg_query($sqlCarr);
							if($carr = pg_fetch_array($carrera)){
								echo("<td>".$carr['nombre']."</td>");
								$renglonAlu += "{$carr['nombre']};";
							}
							
							echo("<td>".$v['correo']."</td>");
							echo("<td>".$v['telefono']."</td>");
							
							$renglonAlu += "{$v['correo']};{$v['telefono']};{$v['servicio_social']};{$v['comp_ingles']};";
							
							echo("<td>");
							if($v['servicio_social']!='falta'){
								$sqlSS = "SELECT id_ss FROM alumno_ss WHERE alumno_no_cuenta = ".$v['no_cuenta'];
								$res = pg_query($sqlSS);
								if($idSS = pg_fetch_array($res))
									echo("<a href=\"archivoSS.php?id=".$idSS['id_ss']."&cuenta=".$v['no_cuenta']."\">Carta de terminaci&oacute;n</a>");
								else echo($v['servicio_social']);
							}else echo("--");
							echo("</td>");
							echo("<td>");
							if($v['comp_ingles']=='t'){
								$sqlEN = "SELECT id FROM alumno_ingles WHERE alumno_no_cuenta = ".$v['no_cuenta'];
								$res = pg_query($sqlEN);
								if($idEN = pg_fetch_array($res))
									echo("<a href=\"archivoEn.php?id=".$idEN['id']."&cuenta=".$v['no_cuenta']."\">Ingl&eacute;s</a>");
								else echo($v['comp_ingles']);
							}else echo("--");
							echo("</td>");
							$opT = pg_query("SELECT nombre FROM opcion_titulacion INNER JOIN alumno_opcion_titulacion ON alumno_opcion_titulacion.opcion_titulacion_clave = opcion_titulacion.clave WHERE alumno_opcion_titulacion.alumno_no_cuenta = ".$v['no_cuenta']);
							if($res = pg_fetch_array($opT))
								$opcionT = $res['nombre'];
							else $opcionT = "--";
							echo("<td>$opcionT</td>");
							
							$renglonAlu += "{$opcionT};{$v['maestria']};{$v['doctorado']}";
							
							echo("<td>".$v['maestria']."</td>");
							echo("<td>".$v['doctorado']."</td>");
							echo("</tr>");
							//echo($renglonAlu);
							fwrite($fpCSV, $renglonAlu.PHP_EOL);
						   }
						}
					}
					
					fclose($fpCSV);
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
