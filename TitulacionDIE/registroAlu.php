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
<title>Sistema de Titulaci&oacute;n</title>
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
				echo("<h2>".$_SESSION['usuarioAdmin']."</h2><br />");
			?>

			<form method="post" action="registrarAlumno.php" class="clase-form">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><h3>Formulario de Registro de Alumnos</h3></div>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Nombre: </div>
						<input name="Nombre" class="form-control" id="Nombre" type="text" onblur="validarNombre()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Apellido Paterno: </div>
						<input name="Ap_Pat" class="form-control" id="Ap_Pat" type="text" onblur="validarPat()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Apellido Materno: </div>
						<input name="Ap_Mat" class="form-control" id="Ap_Mat" type="text" onblur="validarMat()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Correo: </div>
						<input name="Correo" class="form-control" id="Correo" type="text" onblur="validarCorreo()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Tel&eacute;fono: </div>
						<input name="Tel" class="form-control" id="Tel" type="text" onblur="validarTel()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Fecha de Nacimiento</div>
						<input name="fecha_nac" class="form-control" type="date" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Semestre de ingreso</div>
						<input name="semestre" class="form-control" id="semestre" type="text" onblur="validarSemestre()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">No. Cuenta: </div>
						<input name="Cuenta" class="form-control" id="Cuenta" type="text" onblur="validarId()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Promedio: </div>
						<input name="Promedio" class="form-control" id="Promedio" type="text" onblur="validarPromedio()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Carrera: </div>
							<select name="Carrera" class="form-control">
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
							</select>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Avance de Creditos: </div>
						<input name="Creditos" class="form-control" id="Creditos" type="text" onblur="validarAvance()" />
					</div><br />
					<input name="registrar" type="submit" value="Registrar alumno" class="btn btn-default" /> <input name="reset" type="reset" value="Limpiar formulario" class="btn btn-default" />		
				</div>
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
	
</body>

</html>
