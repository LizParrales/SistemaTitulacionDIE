<?php
	session_start();
	require_once("CLASSES/class.ConexionBD.php");
	
	$url = $_SESSION['url'];
	unset($_SESSION['url']);
	
	$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
	$cx = $cbd->crearConexion();

	$id = $_GET['id'];
	$cuenta = $_GET['cuenta'];
	
	if($id > 0){
		$sqlArc = "SELECT nombre, coalesce(archivo, -1) as archivo, tipo_mime, size FROM alumno_ingles WHERE alumno_no_cuenta = ".$cuenta;
		$result = pg_query($cx, $sqlArc);
		if(!$result){
			header('Location: $url');
		}
		$datos = pg_fetch_array($result);
		pg_free_result($result);
		
		#Recuperar archivo oid
		
		pg_query($cx, "begin");
		$file = pg_lo_open($cx, $datos['archivo'], "r");
		
		header("Content-type: ".$datos['tipo_mime']);
		header("Content-lenght: ".$datos['size']);
		
		pg_lo_read_all($file);
		pg_lo_close($file);
		pg_query($cx, "commit");
	}
?>
