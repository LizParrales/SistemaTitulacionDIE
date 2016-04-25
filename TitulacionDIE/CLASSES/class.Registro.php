<?php
	require_once("class.ConexionBD.php");
	class Registro{
		private $usuario;
		private $nombre;
		private $ap_pat;
		private $ap_mat;
		
		function __construct($usr, $nom, $app, $apm){
			$this->usuario = $usr;
			$this->nombre = $nom;
			$this->ap_pat = $app;
			$this->ap_mat = $apm;
		}
				
		public function validaRegistro($cx, $query){
			$ok = 1;
			pg_send_query($cx, $query) or die(pg_last_error($cx));
			$res = pg_get_result($cx);
			if(pg_result_error($res)){
				$_SESSION['MSG'] = pg_result_error($res);
				//echo($_SESSION['MSG']);
				$ok = 0;
			}
			return $ok;
		}
		
		public function registrarUsuario($perfil, $pass){
			
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();
			
			$verif = pg_query("SELECT nombre_usuario FROM Usuario WHERE contrasena = '$pass'");
			
			if($usr = pg_fetch_array($verif)) $_SESSION['MSG'] = "El nombre de usuario ya existe en el sistema";
			else{
				$regUsr = "INSERT INTO Usuario (nombre_usuario, contrasena, vigente, perfil_idperfil) values ('$this->usuario', '$pass', '1', '$perfil')";
				if($this->validaRegistro($cx, $regUsr)) $_SESSION['MSG'] = "Registro de usuario exitoso";
				else $_SESSION['MSG'] = "Error al registrar al usuario ".$this->usuario."con contraseña ".$pass;
			}
			
		}
		
		public function registrarAlumno($avc, $carrera, $prom, $correo, $semestre, $tel, $fecha_nac){
						
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();
			
			list($anio, $mes, $dia) = explode("-", $fecha_nac);
			$fecha = "{$dia}/{$mes}/{$anio}";
			//echo($fecha);	
			
			$nombre = $this->ap_pat." ".$this->ap_mat." ".$this->nombre;
			$nombre = strtoupper($nombre);
			
			$regAlu = "INSERT INTO alumno (no_cuenta, nombre, correo, avance_creditos, promedio, carrera_clave, vigente, sem_registro, telefono, fecha_nac) values ('$this->usuario', '$nombre', '$correo', '$avc', '$prom', '$carrera', '1', '$semestre', '$tel', '$fecha')";
			if($this->validaRegistro($cx, $regAlu)){
				$this->registrarUsuario('2', str_replace("/","",$fecha));
				$_SESSION['MSG'] = "Registro exitoso";
			}
			else $_SESSION['MSG'] = "Error al registrar al alumno";
			$cbd->cerrarConexion();
			header("Location: registroAlu.php");
		}
		
		public function registrarProfesor($depto, $ubic, $mail, $tel, $pag, $cat, $rfc, $cargo){
				
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();
			
			$regProf = "INSERT INTO Profesor (no_trabajador, nombre, apellido_paterno, apellido_materno, departamento_clave_depto, ubicacion, e_mail, telefono, pagina_personal, categoria_id, vigente, cargo_id) values ('$this->usuario', '$this->nombre', '$this->ap_pat', '$this->ap_mat', '$depto', '$ubic', '$mail', '$tel', '$pag', '$cat', '1', '$cargo')";
			if($this->validaRegistro($cx, $regProf)){ 
				$this->registrarUsuario('3', $rfc);
				$_SESSION['MSG'] = "Registro exitoso";
			}
			else $_SESSION['MSG'] = "Error al registrar al profesor";
			$cbd->cerrarConexion();
			header("Location: registroProfesor.php");
			
			
		}

	}
?>
