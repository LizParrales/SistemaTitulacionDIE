<?php
	require_once("class.ConexionBD.php");
	class ConsultaAlumno{
		private $cuenta;
		
		function __construct($c){
			$this->cuenta = $c;
		}
		
		public function consultaInfo(){
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();

			echo("<form enctype=\"multipart/form-data\" method='post' action='modificarAlu.php'>");

			$sqlAlu = "SELECT * FROM alumno WHERE no_cuenta = '$this->cuenta' AND vigente = '1'";
			$ca = pg_query($cx, $sqlAlu) or die("No se realizo la consulta");
			if($arr = pg_fetch_array($ca)){
				echo("<br />Nombre completo: ".$arr['nombre']);
				echo("<br />Avance de creditos: ".$arr['avance_creditos']);
				echo("<br />Promedio: ".$arr['promedio']);

				echo("<br />Carrera: ");
				
				$sqlCarr = "SELECT nombre FROM carrera WHERE clave = ".$arr['carrera_clave'];
				$carrera = pg_query($sqlCarr);
				if($carr = pg_fetch_array($carrera))
					echo($carr['nombre']);
								
				echo("<br />Correo: ".$arr['correo']);
				echo("<br />Servicio social: ");
				echo("<input name='ssocial' type=\"checkbox\" value='t'"); 
				if($arr['servicio_social'] == 't') echo(" checked");
				echo("/>");
				echo("&nbsp;&nbsp;&nbsp;Carta de terminaci&oacute;n: ");
				echo("<input name=\"ssocial_arch\" type=\"file\" />");
				echo("<br />Comprensi&oacute;n de lectura del ingl&eacute;s: ");
				echo("<input name='ingles' type=\"checkbox\" value='t'"); 
				if($arr['servicio_social'] == 't') echo(" checked");
				echo("/>");
				echo("&nbsp;&nbsp;&nbsp;Comprobante: ");
				echo("<input name=\"ingles_arch\" type=\"file\" />");
				echo("<br />Opci&oacute;n de titulaci&oacute;n: ");
				
				$sqlOT = "SELECT clave, nombre FROM opcion_titulacion WHERE vigente = '1'";
				$OpT = pg_query($sqlOT);
				$arrOT = pg_fetch_all($OpT);
				echo("<select name = 'op_t'>");
				foreach($arrOT as $v){
					echo("<option value = ".$v['clave'].">".$v['nombre']."</option>");
				}
				echo("</select>");
				
				echo("<br />Maestr&iacute;a: ");
				echo("<input name= 'maestria' type=\"checkbox\" value='t'"); 
				if($arr['servicio_social'] == 't') echo(" checked");
				echo("/>");
				
				echo("<input name='modificar' type='submit' value='actualizar' />");
				
				echo("</form>");
			}
		}
		
	}
?>