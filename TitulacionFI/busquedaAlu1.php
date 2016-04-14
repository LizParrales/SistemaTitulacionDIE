<?php
	require_once('CLASSES/class.ConexionBD.php');
	$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
	$cx = $cbd->crearConexion();

	$sqlSocial = "";
	$sqlEng = "";
	
	if(strlen($_POST['ssocial']) > 0) $sqlSocial = " AND servicio_social = '".$_POST['ssocial']."'";
	if(strlen($_POST['cIngles']) > 0) $sqlEng = " AND comp_ingles = '".$_POST['cIngles']."'";
	
	$fpCSV = fopen("alumnos.csv","w");
	fwrite($fpCSV, "Nombre;No. Cuenta;Semestre de ingreso;Avance de creditos;Promedio;Carrera;Correo;Telefono;Servicio social;Inglés;Opcion de titulacion;Maestria;Doctorado".PHP_EOL);
	
	if(isset($_SESSION['cargo'])){
		if($_SESSION['cargo'] != 'Jefe de Division'){
			# -- Inicio de busqueda de carrera a la que pertenece el profesor
			
			$sqlCarrera = pg_query("SELECT carrera_clave FROM departamento_carrera WHERE departamento_clave_depto = ".$_SESSION['depto']) or die(pg_last_error($cx));
			if($carrRes = pg_fetch_all($sqlCarrera)){
				$aluRes = array();
				foreach($carrRes as $v){
					//echo($v['carrera_clave']);
					if((strlen($_POST['opTitulacion']) > 0)&&($_POST['opTitulacion'] == 't')){
						$sqlAlu = pg_query("SELECT * FROM alumno INNER JOIN alumno_opcion_titulacion ON alumno.no_cuenta = alumno_opcion_titulacion.alumno_no_cuenta WHERE alumno.carrera_clave = ".$v['carrera_clave']." AND alumno.vigente = '1'".$sqlSocial.$sqlEng);
						$OpTrue = 1;
					}
					else if((strlen($_POST['opTitulacion']) > 0)&&($_POST['opTitulacion'] == 'f')) $OpTrue = 0;
					else{
						$sqlAlu = pg_query("SELECT * FROM alumno WHERE carrera_clave = ".$v['carrera_clave']." AND vigente = '1'".$sqlSocial.$sqlEng);
						$OpTrue = 1;
					}
					if($aluRes = pg_fetch_all($sqlAlu)){
						foreach($aluRes as $v){
					   		if($v['avance_creditos'] >= 60){
								$info = "<tr>";
								$info .= "<td>".$v['nombre']."</td>";
								$info .= "<td>".$v['no_cuenta']."</td>";
								$info .= "<td>".$v['sem_registro']."</td>";
								$info .= "<td>".$v['avance_creditos']."</td>";
								$info .= "<td>".$v['promedio']."</td>";
					
								$renglonAlu = "{$v['nombre']};{$v['no_cuenta']};{$v['sem_registro']};{$v['avance_creditos']};{$v['promedio']};";
					
								$sqlCarr = "SELECT nombre FROM carrera WHERE clave = ".$v['carrera_clave'];
								$carrera = pg_query($sqlCarr);
								if($carr = pg_fetch_array($carrera)){
									$info .= "<td>".$carr['nombre']."</td>";
									$renglonAlu .= "{$carr['nombre']};";
								}
						
								$info .= "<td>".$v['correo']."</td>";
								$info .= "<td>".$v['telefono']."</td>";
								
								$renglonAlu .= "{$v['correo']};{$v['telefono']};{$v['servicio_social']};{$v['comp_ingles']};";
								
								$info .= "<td>";
								if($v['servicio_social']!='falta'){
									$sqlSS = "SELECT id_ss, nombre, comentario FROM alumno_ss WHERE alumno_no_cuenta = ".$v['no_cuenta'];
									$res = pg_query($sqlSS);
									if($idSS = pg_fetch_array($res)){
										if(!is_null($idSS['nombre'])){
											$info .= "<a href=\"archivoSS.php?id=".$idSS['id_ss']."&cuenta=".$v['no_cuenta']."\">Carta de terminaci&oacute;n</a>";
										}else $info .= $idSS['comentario'];
									}else $info .= $v['servicio_social'];
								}else $info .= "--";
								$info .= "</td>";
								$info .= "<td>";
								if($v['comp_ingles']=='t'){
									$sqlEN = "SELECT id FROM alumno_ingles WHERE alumno_no_cuenta = ".$v['no_cuenta'];
									$res = pg_query($sqlEN);
									if($idEN = pg_fetch_array($res))
										$info .= "<a href=\"archivoEn.php?id=".$idEN['id']."&cuenta=".$v['no_cuenta']."\">Ingl&eacute;s</a>";
									else $info .= $v['comp_ingles'];
								}else $info .= "--";
								$info .= "</td>";
								//$opT = pg_query("SELECT nombre FROM opcion_titulacion INNER JOIN alumno_opcion_titulacion ON alumno_opcion_titulacion.opcion_titulacion_clave = opcion_titulacion.clave WHERE alumno_opcion_titulacion.alumno_no_cuenta = ".$v['no_cuenta']);
								$opT = pg_query("SELECT opcion_titulacion.nombre, alumno_opcion_titulacion.comentario FROM opcion_titulacion, alumno_opcion_titulacion WHERE alumno_opcion_titulacion.opcion_titulacion_clave = opcion_titulacion.clave AND alumno_opcion_titulacion.alumno_no_cuenta =".$v['no_cuenta']);
								if($res = pg_fetch_array($opT)){
									$opcionT = $res['nombre']."<br />".$res['comentario'];
									$opRegExiste = 1;
								}
								else{
									$opcionT = "--";
									$opRegExiste = 0;
								}
								$info .= "<td>$opcionT</td>";
								
								$renglonAlu .= "{$opcionT};{$v['maestria']};{$v['doctorado']}";
								
								$info .= "<td>".$v['maestria']."</td>";
								$info .= "<td>".$v['doctorado']."</td>";
								$info .= "</tr>";
								
								if(($OpTrue == 0)&&($opRegExiste == 0)) echo($info);
								else if($OpTrue == 1) echo($info);
								
								//echo($renglonAlu);
								fwrite($fpCSV, $renglonAlu.PHP_EOL);
							}
						}
					}
				}
			}
			# -- Fin de busqueda de carrera a la que pertenece el profesor
		}
		else{
			if((strlen($_POST['opTitulacion']) > 0)&&($_POST['opTitulacion'] == 't'))
				$sqlAlu = pg_query("SELECT * FROM alumno INNER JOIN alumno_opcion_titulacion ON alumno.no_cuenta = alumno_opcion_titulacion.alumno_no_cuenta WHERE alumno.vigente = '1'".$sqlSocial.$sqlEng);
			else $sqlAlu = "SELECT * FROM alumno WHERE vigente = '1' ".$sqlSocial.$sqlEng;
			$resultado = pg_query($sqlAlu) or die(pg_last_error($cx));
			if($arr = pg_fetch_all($resultado)){
				foreach($arr as $v){
				   if($v['avance_creditos'] >= 60){
						echo("<tr>");
						echo("<td>".$v['nombre']."</td>");
						echo("<td>".$v['no_cuenta']."</td>");
						echo("<td>".$v['sem_registro']."</td>");
						echo("<td>".$v['avance_creditos']."</td>");
						echo("<td>".$v['promedio']."</td>");
						
						$renglonAlu = "{$v['nombre']};{$v['no_cuenta']};{$v['sem_registro']};{$v['avance_creditos']};{$v['promedio']};";
						
						$sqlCarr = "SELECT nombre FROM carrera WHERE clave = ".$v['carrera_clave'];
						$carrera = pg_query($sqlCarr);
						if($carr = pg_fetch_array($carrera)){
							echo("<td>".$carr['nombre']."</td>");
							$renglonAlu .= "{$carr['nombre']};";
						}
					
						echo("<td>".$v['correo']."</td>");
						echo("<td>".$v['telefono']."</td>");
						
						$renglonAlu .= "{$v['correo']};{$v['telefono']};{$v['servicio_social']};{$v['comp_ingles']};";
						
						echo("<td>");
						if($v['servicio_social']!='falta'){
							$sqlSS = "SELECT id_ss FROM alumno_ss WHERE alumno_no_cuenta = ".$v['no_cuenta'];
							$res = pg_query($sqlSS);
							if($idSS = pg_fetch_array($res))
								echo("<a href=\"archivoSS.php?id=".$idSS['id_ss']."&cuenta=".$v['no_cuenta']."\">Carta de terminaci&oacute;n</a>");
							else echo($v['servicio_social']);
						}else echo("--");
						echo("</td>");
						echo("<td>");
						if($v['comp_ingles']=='t'){
							$sqlEN = "SELECT id FROM alumno_ingles WHERE alumno_no_cuenta = ".$v['no_cuenta'];
							$res = pg_query($sqlEN);
							if($idEN = pg_fetch_array($res))
								echo("<a href=\"archivoEn.php?id=".$idEN['id']."&cuenta=".$v['no_cuenta']."\">Ingl&eacute;s</a>");
							else echo($v['comp_ingles']);
						}else echo("--");
						echo("</td>");
						$opT = pg_query("SELECT nombre FROM opcion_titulacion INNER JOIN alumno_opcion_titulacion ON alumno_opcion_titulacion.opcion_titulacion_clave = opcion_titulacion.clave WHERE alumno_opcion_titulacion.alumno_no_cuenta = ".$v['no_cuenta']);
						if($res = pg_fetch_array($opT))
							$opcionT = $res['nombre'];
						else $opcionT = "--";
						echo("<td>$opcionT</td>");
						
						$renglonAlu .= "{$opcionT};{$v['maestria']};{$v['doctorado']}";
						
						echo("<td>".$v['maestria']."</td>");
						echo("<td>".$v['doctorado']."</td>");
						echo("</tr>");
						
						//echo($renglonAlu);
						fwrite($fpCSV, $renglonAlu.PHP_EOL);
					   }
					}
				}
			}
		}
		fclose($fpCSV);
	?>
