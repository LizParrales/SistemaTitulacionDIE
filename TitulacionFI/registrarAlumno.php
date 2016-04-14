<?php
	session_start();
	require_once("CLASSES/class.Registro.php");
	
	$reg = new Registro($_POST['Cuenta'], $_POST['Nombre'], $_POST['Ap_Pat'], $_POST['Ap_Mat']);
	$reg->registrarAlumno($_POST['Creditos'], $_POST['Carrera'], $_POST['Promedio'], $_POST['Correo'], $_POST['semestre'], $_POST['Tel'], $_POST['fecha_nac']);
?>