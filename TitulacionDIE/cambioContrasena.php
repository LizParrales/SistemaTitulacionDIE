<?php
	session_start();
	require_once("CLASSES/class.Usuario.php");
	
	$passActual = $_POST['actual'];
	$passNueva = $_POST['nueva'];
	$confNueva = $_POST['reNueva'];
	
	$noVacio = strlen($passActual) * strlen($passNueva) * strlen($confNueva);
	
	if($noVacio > 0 && (!preg_match("/^\s+$/", $passActual.$passNueva.$confNueva))){
		if($passNueva == $confNueva){
			if(isset($_SESSION['cuenta'])) $nombre = $_SESSION['cuenta'];
			else if(isset($_SESSION['no_t'])) $nombre = $_SESSION['no_t'];
			$usr = new Usuario($nombre, $_POST['actual']);
			$usr->cambiarContrasena($_POST['actual'], $_POST['nueva']);
			$_SESSION['MSG'] = $usr->mensaje;
		}
		else $_SESSION['MSG'] = "Las contrase&ntilde;as no coinciden.";
	}
	else{
		$_SESSION['MSG'] = "Por favor, rellene los campos necesarios.";
	}
	header('Location: cambiarContrasena.php');
?>