<?php
	session_start();
	require_once("CLASSES/class.Usuario.php");
	
	$noVacio = strlen($_POST['usr']) * strlen($_POST['pass']);

	if($noVacio > 0 && (!preg_match("/^\s+$/", $_POST['usr'].$_POST['pass']))){
		$usr = new Usuario($_POST['usr'], $_POST['pass']);
		$usr->iniciaSesion();
		//$_SESSION['MSG'] = $usr->mensaje;
	}
	else{ 
	    $_SESSION['MSG'] = "Por favor rellene los campos requeridos.";
	    header('Location: index.php');
	}
?>
