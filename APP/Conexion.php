<?php


	class Conexion{

		private $cadena = "localhost";
		private $usuario = "root";
		private $clave = "";
		private $database = "tienda_surtidocell";
		private $conexion;

		public function __construct(){
			#Inicia la conexion de la base de datos
			$this->conexion = mysqli_connect($this->cadena, $this->usuario, $this->clave, $this->database);

		}

		public function Ejecuta($query){
			#Ejecucion query en base de datos
			return mysqli_query($this->conexion,$query); #mysql
		
		}

		public function EjecutaId($query){ 
            ## Este metodo devuelve el id de la conslta que se realizo
			mysqli_query($this->conexion,$query);

			$dato = mysqli_query($this->conexion,"SELECT @@identity AS id");

			if ($row = mysqli_fetch_row($dato)){
				$id = trim($row[0]);
			}
			return $id;
		}

		public function __destruct(){
			#Termina la conexion de la base de datos
			//mysqli_close($this->conexion); #mysql
			// odbc_close($this->conexion); #SQL
			#Termina la conexion de la base de datos
		}
	}

?>