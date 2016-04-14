<?php
	session_start();
	require_once('CLASSES/class.ConexionBD.php');

	$cbd = new ConexionBD("132.248.59.4", "titulacionDIE", "postgres", "p0o9swt5gtr4e3sw");
	$cx = $cbd->crearConexion();

	if(!empty($_FILES['fileCSV']['name'])){

		$archivo = fopen($_FILES['fileCSV']['tmp_name'], "r");
		
		$header = fgetcsv($archivo, ",");
		$tam = count($header);
		
		pg_query("set client_encoding ='LATIN1'");
		
		for($i=0;$i<$tam;$i++){
			$header[$i] = strtolower($header[$i]);
			
			switch($header[$i]){
				case "cuenta":
					$header[$i] = "no_cuenta";
					$cuenta = $i;
					break;
				
				case "carrera":
					$header[$i] = "carrera_clave";
					break;
				
				case "avance":
					$header[$i] = "avance_creditos";
					break;
				
				case "registro":
					$header[$i] = "sem_registro";
					break;
				
				case "fecha_nacimiento":
					$header[$i] = "fecha_nac";
					$pass = $i;
					break;
			}
			
			//echo($header[$i]." ");
		}
		$tiempo = set_time_limit(0);
		while(!feof($archivo)){
			$contenido = fgetcsv($archivo, ",");
			if(!is_null($contenido[0])){
				$usuarios = pg_fetch_array(pg_query("SELECT fecha_nac FROM alumno WHERE no_cuenta = ".$contenido[$cuenta])) or die(pg_last_error());
				if($usuarios){
					$actualiza = "UPDATE alumno SET ";
					$actUsuario = "UPDATE usuario SET ";
	
					$j = 1;
	
					for($i=0;$i<$tam;$i++){
						if($i != $cuenta){
							switch($header[$i]){
								case "avance_creditos":
								case "promedio":
								case "correo":
								case "telefono":
								case "fecha_nac":
									$j++;
									
									if($header[$i] == "correo"){
										$actualiza .= $header[$i]."='".$contenido[$i]."'";
									}else{
										$actualiza .= $header[$i]."='".strtoupper($contenido[$i])."'";
									}
									
									if($j <= 5) $actualiza .= ", ";
									
									if($header[$i] == "fecha_nac"){
										$actUsuario .= "contrasena = '".$contenido[$i]."'";
									}
									
									break;
							}
						}
					}
					$actualiza .= " WHERE vigente = '1' AND no_cuenta = ".$contenido[$cuenta];
					$actUsuario .= " WHERE vigente = '1' AND nombre_usuario = '".$contenido[$cuenta]."'";
					//echo($actualiza."<br />");
					$actUsuario = str_replace("/","",$actUsuario);
					//echo($actUsuario."<br />");
					pg_query($actualiza) or die(pg_last_error($cx));
					pg_query($actUsuario) or die(pg_last_error($cx));
				}
				
				else{
					$registra = "INSERT INTO alumno(";
					$regUsuario = "INSERT INTO usuario(nombre_usuario, contrasena, perfil_idperfil) values('".$contenido[$cuenta]."', '".$contenido[$pass]."','2')";
					for($i=0;$i<$tam;$i++){
						$registra .= $header[$i];
						if($i != $tam-1) $registra .= ", ";
					}
					$registra .= ") values(";
					for($i=0;$i<$tam;$i++){
						$registra .= "'".$contenido[$i]."'";
						if($i != $tam-1) $registra .= ", ";
					}
					$registra .= ")";
					//echo($registra."<br />");
					$regUsuario = str_replace("/","",$regUsuario);
					//echo($regUsuario."<br />");
					pg_query($registra) or die(pg_last_error($cx));
					pg_query($regUsuario) or die(pg_last_error($cx));
				}
			}
		}
		$_SESSION['MSG'] = "Carga de datos de alumnos completa";
		fclose($archivo);
	}else $_SESSION['MSG'] = "Error al abrir el archivo";
	
	$cbd->cerrarConexion();
	header("Location: archivoAluCSV.php");
?>