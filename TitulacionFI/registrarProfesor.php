<?php
	session_start();
	require_once("CLASSES/class.Registro.php");
	
	$reg = new Registro($_POST['Cuenta'], $_POST['Nombre'], $_POST['Ap_Pat'], $_POST['Ap_Mat']);
	$rfc = strtoupper($_POST['RFC']);
	$reg->registrarProfesor($_POST['Adscrip'], $_POST['Ubic'], $_POST['Correo'], $_POST['Tel'], $_POST['Pag'], $_POST['Cat'], $rfc, $_POST['cargo']);
?>