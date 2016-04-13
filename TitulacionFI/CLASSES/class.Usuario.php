<?php
	require_once("class.ConexionBD.php");
	class Usuario{
		private $nombre;
		private $contrasena;
		private $perfil;
		
		function __construct($nom, $pass){
			$this->nombre = $nom;
			$this->contrasena = $pass;
		}
		
		
		public function iniciaSesion(){
			$cbd = new ConexionBD('132.248.59.4', 'titulacionDIE', 'postgres', 'p0o9swt5gtr4e3sw');
			$cx = $cbd->crearConexion();
			
			$sqlPerfil = "SELECT nombre FROM perfil INNER JOIN usuario ON usuario.perfil_idperfil = perfil.idperfil WHERE usuario.contrasena = '$this->contrasena'";
			
			$p = pg_query($sqlPerfil);
			if($array = pg_fetch_array($p)){
				$this->perfil = $array['nombre'];
				echo($this->perfil);
			}else echo("El usuario no existe");
			
			
			if($this->perfil == 'Administrador'){
				$query = "SELECT nombre, apellido_paterno, apellido_materno FROM administrador WHERE no_trabajador = '$this->nombre'";
				$consulta = pg_query($cx, $query) or die("No fue posible realizar la consulta.");
				if($array = pg_fetch_array($consulta)){
					$_SESSION['usuarioAdmin'] = $array['nombre']." ".$array['apellido_paterno']." ".$array['apellido_materno'];
					$_SESSION['perfil'] = $this->perfil;
					$_SESSION['no_t'] = $this->nombre;
					header('Location: admin.php');
				}else echo("Por favor verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos");
			}
			else if($this->perfil == 'Profesor'){
				$query = "SELECT nombre, apellido_paterno, apellido_materno, cargo_id, departamento_clave_depto FROM profesor WHERE no_trabajador = '$this->nombre'";
				$consulta = pg_query($cx, $query) or die("No fue posible realizar la consulta.");
				if($array = pg_fetch_array($consulta)){
					$_SESSION['usuarioProf'] = $array['nombre']." ".$array['apellido_paterno']." ".$array['apellido_materno'];
					$_SESSION['perfil'] = $this->perfil;
					$_SESSION['no_t'] = $this->nombre;
					
					$cargo = pg_query("SELECT nombre FROM cargo WHERE id = ".$array['cargo_id']) or die(pg_last_error($cx));
					if($resCargo = pg_fetch_array($cargo))
						$_SESSION['cargo'] = $resCargo['nombre'];
					$_SESSION['depto'] = $array['departamento_clave_depto'];
					header('Location: profesor.php');
				}else echo("Por favor verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos");
			}
			else{
				$query = "SELECT nombre FROM alumno WHERE no_cuenta = '$this->nombre'";
				$consulta = pg_query($cx, $query) or die("No fue posible realizar la consulta.");
				if($array = pg_fetch_array($consulta)){
					$_SESSION['usuarioAlu'] = $array['nombre'];
					$_SESSION['perfil'] = $this->perfil;
					$_SESSION['cuenta'] = $this->nombre;
					header('Location: alumno.php');
				}else echo("Por favor verifique que el usuario y contrase&ntilde;a que proporcion&oacute; sean correctos");
			}
			$cbd->cerrarConexion();
		}
		
		public function cerrarSesion(){
			session_destroy();
			header('Location: index.php');
		}
	}
?>
