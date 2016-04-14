<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	session_start();
	if(!isset($_SESSION['usuarioAdmin'])){
		session_destroy();
		header('Location: index.php');
	}
?>	

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Sistema de titulaci&oacute;n</title>
</head>

<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/validaForm.js"></script>
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

			<h1>Formulario de Registro de Alumnos</h1>
			<form method="post" action="registrarAlumno.php">
				<label>Nombre: </label><input name="Nombre" id="Nombre" type="text" onblur="validarNombre()" /><br />
				<label>Apellido Paterno: </label><input name="Ap_Pat" id="Ap_Pat" type="text" onblur="validarPat()" /><br />
				<label>Apellido Materno: </label><input name="Ap_Mat" id="Ap_Mat" type="text" onblur="validarMat()" /><br />
				<label>Correo: </label><input name="Correo" id="Correo" type="text" onblur="validarCorreo()" /><br />
				<label>Tel&eacute;fono: </label><input name="Tel" id="Tel" type="text" onblur="validarTel()" /><br />
				<label>Fecha de Nacimiento</label><input name="fecha_nac" type="date" /><br />
				<label>Semestre de ingreso</label><input name="semestre" id="semestre" type="text" onblur="validarSemestre()" /><br />
				<label>No. Cuenta: </label><input name="Cuenta" id="Cuenta" type="text" onblur="validarId()" /><br />
				<label>Promedio: </label><input name="Promedio" id="Promedio" type="text" onblur="validarPromedio()" /><br />
				<label>Carrera: </label>
				<select name="Carrera">
				<?php
					require_once("CLASSES/class.ConexionBD.php");
					$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
					$cx = $cbd->crearConexion();
					$cat = pg_query("SELECT clave, nombre FROM carrera WHERE vigente = '1' ORDER BY clave ASC") or die("No se pudo realizar la consulta");
					if(!$cat) echo("El catalogo esta vac&iacute;o");
					else{
						$arr = pg_fetch_all($cat);
						foreach($arr as $i){
							echo("<option value=".$i['clave'].">".$i['nombre']."</option>");
						}
					}
				?>
				</select><br />
				<label>Avance de Creditos: </label><input name="Creditos" id="Creditos" type="text" onblur="validarAvance()" /><br />
				<input name="registrar" type="submit" value="Registrar Alumno" />		
			</form>

			<?php
				if(isset($_SESSION['MSG'])){
					echo($_SESSION['MSG']);
					unset($_SESSION['MSG']);
				}
			?>


		</div>
		<div id="footer">
		</div>
	</div>
	
</body>

</html>
