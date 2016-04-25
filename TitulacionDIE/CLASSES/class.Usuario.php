<?php
	require_once("class.ConexionBD.php");
	class Usuario{
		private $nombre;
		private $contrasena;
		private $perfil;
		public $mensaje;
		
		function __construct($nom, $pass){
			$this->nombre = $nom;
			$this->contrasena = $pass;
		}
		
		
		public function iniciaSesion(){
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();
			
			$sqlPerfil = "SELECT nombre FROM perfil INNER JOIN usuario ON usuario.perfil_idperfil = perfil.idperfil WHERE usuario.contrasena = '$this->contrasena' AND usuario.nombre_usuario = '$this->nombre'";
			
			$p = pg_query($sqlPerfil);
			if($array = pg_fetch_array($p)){
				$this->perfil = $array['nombre'];
				//echo($this->perfil);
				
				if($this->perfil == 'Administrador'){
					$query = "SELECT nombre, apellido_paterno, apellido_materno FROM administrador WHERE no_trabajador = '$this->nombre'";
					$consulta = pg_query($cx, $query) or die(pg_last_error($cx));
					if($array = pg_fetch_array($consulta)){
						$_SESSION['usuarioAdmin'] = $array['nombre']." ".$array['apellido_paterno']." ".$array['apellido_materno'];
						$_SESSION['perfil'] = $this->perfil;
						$_SESSION['no_t'] = $this->nombre;
						$cbd->cerrarConexion();
						header("Location: admin.php");
					}else{
						$_SESSION['MSG'] = "Por favor verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos";
						$cbd->cerrarConexion();
						header('Location: index.php');
					}
				}
				else if($this->perfil == 'Profesor'){
					$query = "SELECT nombre, apellido_paterno, apellido_materno, cargo_id, departamento_clave_depto FROM profesor WHERE no_trabajador = '$this->nombre'";
					$consulta = pg_query($cx, $query) or die(pg_last_error($cx));
					if($array = pg_fetch_array($consulta)){
						$_SESSION['usuarioProf'] = $array['nombre']." ".$array['apellido_paterno']." ".$array['apellido_materno'];
						$_SESSION['perfil'] = $this->perfil;
						$_SESSION['no_t'] = $this->nombre;
						
						$cargo = pg_query("SELECT nombre FROM cargo WHERE id = ".$array['cargo_id']) or die(pg_last_error($cx));
						if($resCargo = pg_fetch_array($cargo))
							$_SESSION['cargo'] = $resCargo['nombre'];
						$_SESSION['depto'] = $array['departamento_clave_depto'];
						$cbd->cerrarConexion();
						header('Location: profesor.php');
					}else{
						$_SESSION['MSG'] = "Por favor verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos";
						$cbd->cerrarConexion();
						header('Location: index.php');
					}
				}
				else{
					$query = "SELECT alumno.nombre, usuario.primer_acceso FROM alumno, usuario WHERE usuario.nombre_usuario = '$this->nombre' AND alumno.no_cuenta = '$this->nombre'";
					$consulta = pg_query($cx, $query) or die(pg_last_error($cx));
					if($array = pg_fetch_array($consulta)){
						$_SESSION['primer_acceso'] = $array['primer_acceso'];
						$_SESSION['usuarioAlu'] = $array['nombre'];
						$_SESSION['perfil'] = $this->perfil;
						$_SESSION['cuenta'] = $this->nombre;
						$cbd->cerrarConexion();
						header('Location: alumno.php');
					}else{
						$_SESSION['MSG'] = "Por favor verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos";
						$cbd->cerrarConexion();
						header('Location: index.php');
					}
				}
			}else{
				$_SESSION['MSG'] = "El usuario no existe, verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos";
				$cbd->cerrarConexion();
				header('Location: index.php');
			}
			
			$cbd->cerrarConexion();
		}
		
		public function cambiarContrasena($actual, $nueva){
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();
			
			$buscaPass = pg_query("SELECT contrasena FROM usuario WHERE nombre_usuario = '$this->nombre'");
			if($res = pg_fetch_array($buscaPass))
				if($res['contrasena'] == $actual){
					$sqlCambio = "UPDATE usuario SET contrasena = '$nueva' WHERE nombre_usuario = '$this->nombre'";
					if(pg_query($sqlCambio)){
						$VerifAcceso = pg_query("SELECT primer_acceso FROM usuario WHERE vigente = '1' AND nombre_usuario = '".$this->nombre."'");
						if($vAcc = pg_fetch_array($VerifAcceso)){
							if($vAcc['primer_acceso'] == '1'){
								pg_query("UPDATE usuario SET primer_acceso = '0' WHERE vigente = '1' AND nombre_usuario = '".$this->nombre."'") or die(pg_last_error($cx));
							}
						}
						$this->mensaje = "La contrase&ntildea se cambio con exito";
					}
					else $this->mensaje = pg_last_error($cx);
			
				}
				else $this->mensaje = "La contrase&ntilde;a actual es incorrecta";
			$cbd->cerrarConexion();
		}
		
		public function cerrarSesion(){
			session_destroy();
			header('Location: index.php');
		}
	}
?>
