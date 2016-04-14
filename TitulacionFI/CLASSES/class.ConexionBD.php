<?php
	class ConexionBD{
	
		private $nombreBase;
		private $host;
		private $usuarioPg;
		private $contrasena;
		private $puerto;
		private $conexion;
		private $cadenaConexion;
		
		function __construct($h, $nBase, $uPg, $c){
			$this->host = $h;
			$this->nombreBase = $nBase;
			$this->usuarioPg = $uPg;
			$this->contrasena = $c;
		}
		
		public function crearConexion(){
			$cadena = "host={$this->host} port=5432 dbname={$this->nombreBase} user={$this->usuarioPg} password={$this->contrasena}";
			$this->cadenaConexion = "host=localhost port=5432 dbname=TitulacionFI user=postgres password=hola123";
			//$this->cadenaConexion = $cadena;
			$this->conexion = pg_connect($this->cadenaConexion) or die("No se realiz&oacute; la conexi&oacute;n");
			return $this->conexion;
		}
		
		public function cerrarConexion(){
			pg_close($this->conexion);
		}
	}
?>