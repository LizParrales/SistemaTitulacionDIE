<?php
	session_start();
	require_once("CLASSES/class.Usuario.php");
	$usr = new Usuario($_POST['usr'], $_POST['pass']);
	$usr->iniciaSesion();
	echo("<br />".$usr->mensaje);
?>
