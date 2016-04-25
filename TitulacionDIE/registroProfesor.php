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
				echo("<h2>".$_SESSION['usuarioAdmin']."</h2>");
			?>

			<form method="post" action="registrarProfesor.php" class="clase-form">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"><h3>Formulario de Registro de Profesores</h3></div>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Nombre: </div>
						<input class="form-control"name="Nombre" id="Nombre" type="text" onblur="validarNombre()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Apellido Paterno: </div>
						<input class="form-control"name="Ap_Pat" id="Ap_Pat" type="text" onblur="validarPat()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Apellido Materno: </div>
						<input class="form-control"name="Ap_Mat" id="Ap_Mat" type="text" onblur="validarMat()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">RFC: </div>
						<input class="form-control"name="RFC" id="RFC" type="text" onblur="validarRFC()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">No. Trabajador: </div>
						<input class="form-control"name="Cuenta" id="Cuenta" onblur="validarId()" type="text" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Adscripci&oacute;n: </div>
						<select class="form-control" name="Adscrip">
							<?php
								require_once("CLASSES/class.ConexionBD.php");
								$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
								$cx = $cbd->crearConexion();
								$ads = pg_query("SELECT clave_depto, nombre_depto FROM departamento WHERE vigente = '1' ORDER BY clave_depto ASC") or die("No se pudo realizar la consulta");
								if(!$ads) echo("El catalogo esta vac&iacute;o");
								else{
									$arr = pg_fetch_all($ads);
									foreach($arr as $i){
										echo("<option value=".$i['clave_depto'].">".$i['nombre_depto']."</option>");
									}
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Categor&iacute;a: </div>
						<select class="form-control" name="Cat">
							<?php
								$cat = pg_query("SELECT id, categoria FROM categoria ORDER BY id ASC") or die("No se pudo realizar la consulta");
								if(!$cat) echo("El catalogo esta vac&iacute;o");
								else{
									$arr = pg_fetch_all($cat);
									foreach($arr as $i){
										echo("<option value=".$i['id'].">".$i['categoria']."</option>");
									}
								}						
							?>
						</select>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Cargo</div>
							<select class="form-control" name="cargo">
								<?php
									$cargo = pg_query("SELECT id, nombre FROM cargo ORDER BY id ASC") or die("No se pudo realizar la consulta");
									if(!$cargo) echo("El catalogo esta vac&iacute;o");
									else{
										$arr = pg_fetch_all($cargo);
										foreach($arr as $i){
											echo("<option value=".$i['id'].">".$i['nombre']."</option>");
										}
									}
				
									$cbd->cerrarConexion();
								?>
							</select>
					</div>
					<div class="input-group">
						<div class="input-group-addon">Ubicaci&oacute;n: </div>
						<input class="form-control"name="Ubic" id="Ubic" type="text" onblur="validarUbicacion()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Correo: </div>
						<input class="form-control"name="Correo" id="Correo" type="text" onblur="validarCorreo()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">Tel&eacute;fono: </div>
						<input class="form-control"name="Tel" id="Tel" type="text" onblur="validarTel()" />
					</div>
					<div class="input-group">
						<div class="input-group-addon">P&aacute;gina del Profesor: </div>
						<input class="form-control"name="Pag" id="Pag" type="text" onblur="" />
					</div><br />
					<input name="registrar" type="submit" value="Registrar Profesor" class="btn btn-default" /> <input name="reset" type="reset" value="Limpiar formulario" class="btn btn-default" />
			</div>
			<?php
				if(isset($_SESSION['MSG'])){
					echo("<br />".$_SESSION['MSG']);
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
