<?php
 	require_once('CLASSES/class.ConexionBD.php');

	session_start();
	if($_SESSION['perfil']!='Alumno'){
		session_destroy();
		header('Location: </td><td style=\"font-size:medium\">index.php');
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
	<nav>
		<ul>
			<li><a href='salir.php'>salir</a></li>
		</ul>
	</nav>
		</div>
		<div id="info">
			<form enctype="multipart/form-data" method="post" action="modificarAlu.php">
			
			<table class="table table-condensed table-bordered">
			<?php
				echo("<h1>Bienvenid@ ".$_SESSION['usuarioAlu']."</h1>");
				
				$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
				$cx = $cbd->crearConexion();
	
				$sqlAlu = "SELECT * FROM alumno WHERE no_cuenta = ".$_SESSION['cuenta']." AND vigente = '1'";
				$ca = pg_query($cx, $sqlAlu) or die("No se realizo la consulta");
				if($arr = pg_fetch_array($ca)){
					echo("<tr>");
					echo("<td style=\"font-size:medium\">Nombre completo: </td><td style=\"font-size:medium\">".$arr['nombre']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td style=\"font-size:medium\">Avance de creditos: </td><td style=\"font-size:medium\">".$arr['avance_creditos']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td style=\"font-size:medium\">Promedio: </td><td style=\"font-size:medium\">".$arr['promedio']."</td>");
					echo("</tr>");
					echo("<tr>");

					echo("<td style=\"font-size:medium\">Carrera: </td><td style=\"font-size:medium\">");
					
					$sqlCarr = "SELECT nombre FROM carrera WHERE clave = ".$arr['carrera_clave'];
					$carrera = pg_query($sqlCarr);
					if($carr = pg_fetch_array($carrera))
						echo($carr['nombre']);
					echo("</td></tr>");
					echo("<tr>");
					echo("<td style=\"font-size:medium\">Semestre de ingreso: </td><td style=\"font-size:medium\">".$arr['sem_registro']."</td>");
					echo("</tr>");
					echo("<tr>");
					echo("<td style=\"font-size:medium\">Correo: </td><td style=\"font-size:medium\">".$arr['correo']."</td>");
					echo("</tr>");
					echo("</table><table class=\"table table-condensed table-bordered\">");
					echo("<tr>");
					echo("<td style=\"font-size:medium\">Servicio social: </td><td style=\"font-size:medium\">");
					echo("<select name=\"ssocial\">");
						echo("<option value = 'falta'");
						if($arr['servicio_social'] == 'falta') echo(" selected");
						echo(">No cubierto</option>");
						echo("<option value = 'en_curso'");
						if($arr['servicio_social'] == 'en_curso') echo(" selected");
						echo(">En curso</option>");
						echo("<option value = 'terminado'");
						if($arr['servicio_social'] == 'terminado') echo(" selected");
						echo(">Terminado</option>");
					echo("</select></td><td style=\"font-size:medium\">");
					$sqlSS = "SELECT id_ss, nombre, comentario FROM alumno_ss WHERE alumno_no_cuenta = ".$_SESSION['cuenta'];
					$ssArch = pg_query($sqlSS);
					if($arrSSArch = pg_fetch_array($ssArch)){
						$id = $arrSSArch['id_ss'];
						echo("<a href=\"archivoSS.php?id=$id&cuenta=".$_SESSION['cuenta']."\">Carta de terminaci&oacute;n</a>");
					}
					else{
						echo("Carta de terminaci&oacute;n: ");
						echo("<input name=\"ssocial_arch\" type=\"file\" />");
						echo("<br />");
						echo("Comentarios");
						echo("<br /><textarea name=\"ssocial_com\" cols=\"20\" rows=\"2\"></textarea>");
					}
					echo("</td></tr>");
					echo("<tr>");

					$sqlEn = "SELECT id, anio_exp, archivo FROM alumno_ingles WHERE alumno_no_cuenta = ".$_SESSION['cuenta']."ORDER BY anio_exp DESC";
					$enArch = pg_query($sqlEn);
				
					echo("<td style=\"font-size:medium\">Comprensi&oacute;n de lectura del ingl&eacute;s: </td><td style=\"font-size:medium\">");
					echo("<input name=\"ingles\" type=\"checkbox\" value='t'"); 
					
					if($arrEn = pg_fetch_array($enArch)){
						$anioEn = date('Y')-$arrEn['anio_exp'];
						if($anioEn < 5)
							echo(" checked");
					}
					echo("/></td><td style=\"font-size:medium\">");
					
					if(!$arrEn['archivo']){
						echo("Comprobante: ");
						echo("<input name=\"ingles_arch\" type=\"file\" />");
						echo("<br />Año de expedici&oacute;n");
						echo("<select name=\"anio_en\">");
						for($i=(date("Y")-5);$i<date("Y");$i++){
							echo("<option value = $i>$i</option>");
						}
						echo("</select>");
					}
					else{
						$idEn = $arrEn['id'];
						echo("<a href=\"archivoEn.php?id=$idEn\">Comprensi&oacute;n de lectura</a>");
					}
					echo("</td></tr>");
					echo("<tr>");
					echo("</table><table class=\"table table-condensed table-bordered\">");
					echo("<td style=\"font-size:medium\">Opci&oacute;n de titulaci&oacute;n: </td><td style=\"font-size:medium\">");
			
					$sqlOT = "SELECT clave, nombre FROM opcion_titulacion WHERE vigente = '1'";
					$OpT = pg_query($sqlOT);
					$arrOT = pg_fetch_all($OpT);
					
					$sqlOpAlu = pg_fetch_array(pg_query("SELECT opcion_titulacion_clave FROM alumno_opcion_titulacion WHERE vigente = '1' AND alumno_no_cuenta = ".$_SESSION['cuenta']));
					
					echo("<select name = 'op_t'>");
						echo("<option value = \"\"></option>");
					foreach($arrOT as $v){
						echo("<option value = ".$v['clave']);
						if($sqlOpAlu)	
							if($sqlOpAlu['opcion_titulacion_clave'] == $v['clave']){
								echo(" selected");
							}
						echo(">".$v['nombre']."</option>");
					}
					echo("</select>");
					echo("<br /><br />");
					echo("Comentarios");
					echo("<br /><textarea name=\"opTit_com\" cols=\"20\" rows=\"2\"></textarea>");
					echo("</td></tr>");
					echo("<tr>");

					echo("<td style=\"font-size:medium\">Maestr&iacute;a: </td><td style=\"font-size:medium\">");
					echo("<input name= 'maestria' type=\"checkbox\" value='t'"); 
					if($arr['maestria'] == 't') echo(" checked");
					echo("/>");
					echo("</td></tr>");
				}
				?>
				</table>
				<input name='modificar' type='submit' value='actualizar' />
			</form>
		</div>
		<div id="footer">
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>

</html>
