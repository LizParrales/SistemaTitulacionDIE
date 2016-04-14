<?php
	require_once('CLASSES/class.ConexionBD.php');
	session_start();
	
	$cbd = new ConexionBD('localhost', '5432', 'TitulacionFI', 'postgres', 'hola123');
	$cx = $cbd->crearConexion();
	
	if(isset($_POST['ssocial'])){
		$sqlSS = "UPDATE alumno SET servicio_social = '".$_POST['ssocial']."' WHERE no_cuenta = ".$_SESSION['cuenta'];
		pg_query($cx, $sqlSS);
		
		if(!empty($_FILES['ssocial_arch']['name'])){
			$dir = './tmp/';
			$size = $_FILES['ssocial_arch']['size'];
			$archivo = $dir.basename($_FILES['ssocial_arch']['name']);
			$nombre = $_FILES['ssocial_arch']['name'];
			$subir = 1;
			$tipo = $_FILES['ssocial_arch']['type'];
			echo($tipo);
			
			//if(move_uploaded_file($_FILES['ssocial_arch']['tmp_name'], $archivo)) echo("Subida de archivo exitosa");
			
			$arch = fopen($_FILES['ssocial_arch']['tmp_name'], "rb");
			$buffer = fread($arch, filesize($_FILES['ssocial_arch']['tmp_name']));
			fclose($arch);			
			
			#creacion de objeto blob
			
			pg_query($cx, "begin");
			$oid = pg_lo_create($cx);
			
			if($regAluSS = pg_fetch_array(pg_query("SELECT id_ss FROM alumno_ss WHERE alumno_no_cuenta = ".$_SESSION['cuenta'])))
				$sqlSSa = "UPDATE alumno_ss SET archivo_ss = '$oid', tipo_mime = '$tipo', size = '$size' WHERE alumno_no_cuenta = ".$_SESSION['cuenta'];
			else $sqlSSa = "INSERT INTO alumno_ss (nombre, archivo_ss, tipo_mime, size, alumno_no_cuenta) VALUES ('$nombre', '$oid', '$tipo', '$size', ".$_SESSION['cuenta'].")";
			
			pg_query($cx, $sqlSSa);
			
			$blob = pg_lo_open($cx, $oid, "w");
			pg_lo_write($blob, $buffer);
			pg_lo_close($blob);
			pg_query($cx, "commit");
		}
		
		if(isset($_POST['ssocial_com'])){
			if($regAluSS = pg_fetch_array(pg_query("SELECT id_ss FROM alumno_ss WHERE alumno_no_cuenta = ".$_SESSION['cuenta'])))
				$sqlSScom = "UPDATE alumno_ss SET comentario = '".$_POST['ssocial_com']."' WHERE alumno_no_cuenta = ".$_SESSION['cuenta'];
			else $sqlSScom = "INSERT INTO alumno_ss (comentario, alumno_no_cuenta) VALUES ('".$_POST['ssocial_com']."', ".$_SESSION['cuenta'].")";
			
			pg_query($sqlSScom) or die(pg_last_error($cx));
		}
	}
	
	if(isset($_POST['ingles'])){
		$sqlSS = "UPDATE alumno SET comp_ingles = 't' WHERE no_cuenta = ".$_SESSION['cuenta'];
		pg_query($cx, $sqlSS);

		if(!empty($_FILES['ingles_arch']['name'])){
			$dir = './tmp/';
			$size = $_FILES['ingles_arch']['size'];
			$nombre = $_FILES['ingles_arch']['name'];
			$archivo = $dir.basename($_FILES['ingles_arch']['name']);
			$subir = 1;
			$tipo = $_FILES['ingles_arch']['type'];
			$anio = $_POST['anio_en'];
			
			//if(move_uploaded_file($_FILES['ssocial_arch']['tmp_name'], $archivo)) echo("Subida de archivo exitosa");
			
			$arch = fopen($_FILES['ingles_arch']['tmp_name'], "rb");
			$buffer = fread($arch, filesize($_FILES['ingles_arch']['tmp_name']));
			fclose($arch);			
						
			#creacion de objeto blob
			
			pg_query($cx, "begin");
			$oid = pg_lo_create($cx);
			
			$sqlSSa = "INSERT INTO alumno_ingles (nombre, archivo, anio_exp, tipo_mime, size, alumno_no_cuenta) VALUES ('$nombre', '$oid', '$anio', '$tipo', '$size' ".$_SESSION['cuenta'].")";
			
			pg_query($cx, $sqlSSa);
			
			$blob = pg_lo_open($cx, $oid, "w");
			pg_lo_write($blob, $buffer);
			pg_lo_close($blob);
			pg_query($cx, "commit");
		}
	}
	
	if(isset($_POST['op_t'])&&($_POST['op_t'] != "")){
		$opAnt = "SELECT id FROM alumno_opcion_titulacion WHERE alumno_no_cuenta = ".$_SESSION['cuenta']." AND vigente = '1'";
		$res = pg_query($opAnt);
		if($f = pg_fetch_array($res)){
			$vigOp = "UPDATE alumno_opcion_titulacion SET vigente = '0' WHERE alumno_no_cuenta = ".$_SESSION['cuenta'];
			pg_query($vigOp);
		}
		
		$sqlOpT = "INSERT INTO alumno_opcion_titulacion (alumno_no_cuenta, opcion_titulacion_clave, comentario, vigente) VALUES (".$_SESSION['cuenta'].", ".$_POST['op_t'].", ".$_POST['opTit_com'].", '1')";
		pg_query($sqlOpT) or die("No se puede registrar la opci&oacute;n de titulaci&oacute;n");
		
		$sqlMaestria = pg_query("SELECT nombre FROM opcion_titulacion WHERE clave = ".$_POST['op_t']);
		$resMaestria = pg_fetch_array($sqlMaestria);
		
		if($resMaestria['nombre'] == 'Estudios de posgrado'){
			pg_query($cx, "UPDATE alumno SET maestria = 't' WHERE no_cuenta = ".$_SESSION['cuenta']) or die(pg_last_error($cx));
		}
		
		if(isset($_POST['opTit_com'])){
			if($regAluOT = pg_fetch_array(pg_query("SELECT id FROM alumno_opcion_titulacion WHERE vigente = '1' AND alumno_no_cuenta = ".$_SESSION['cuenta'])))
				$sqlOTcom = "UPDATE alumno_opcion_titulacion SET comentario = '".$_POST['opTit_com']."' WHERE vigente = '1' AND alumno_no_cuenta = ".$_SESSION['cuenta'];
			else $sqlOTcom = "INSERT INTO alumno_opcion_titulacion (comentario, alumno_no_cuenta) VALUES ('".$_POST['opTit_com']."', ".$_SESSION['cuenta'].")";
		
			pg_query($sqlOTcom) or die(pg_last_error($cx));
		}

	}
	
	if(isset($_POST['maestria'])){
		pg_query($cx, "UPDATE alumno SET maestria = 't' WHERE no_cuenta = ".$_SESSION['cuenta']) or die(pg_last_error($cx));
	}
	
	header("Location: alumno.php");

?>