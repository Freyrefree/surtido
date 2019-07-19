<?php 

define('DOCROOT', realpath(dirname(__FILE__)).'/'); 
require_once(DOCROOT . '../APP/config.php');
require_once(DOCROOT . '../APP/Conexion.php');

    
	class Empresa {

		private $id;
		private $empresa;		
    	private $nit; 
    	private $direccion; 
        private $ciudad;
        private $tel1;
        private $tel2;
        private $web;
        private $correo;
        private $iva;
        private $tamano;
        private $fechaPago;
       


		public function __construct(){
			#default conecta con la base de datos
			$this->cmd = new Conexion();
		}

		public function set($atributo, $contenido){
			$this->$atributo = $contenido;
		}

		public function get($atributo){
			return $this->$atributo;
        }

        public function obtieneEmpresa(){

			$sql="SELECT * FROM empresa WHERE id ='{$this->id}'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);


			if($array){
				
				$this->empresa = $array['empresa'];
				$this->nit = $array['nit'];
				$this->direccion = $array['direccion'];
				$this->ciudad = $array['ciudad'];
				$this->tel1 = $array['tel1'];
				$this->tel2 = $array['tel2'];
				$this->web = $array['web'];
				$this->correo = $array['correo'];
                $this->iva = $array['iva'];
                $this->tamano = $array['tamano'];
                $this->fechaPago = $array['fecha_pago'];
			}


		}
        

		public function listarCuentas(){
			$sql="SELECT * FROM cuenta WHERE id_proveedor ='{$this->id}'";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function eliminaCuenta(){
			$sql = "DELETE FROM cuenta WHERE id = '{$this->id}'";
			$datos = $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function registraCuenta(){
			// $sql="INSERT INTO cuenta(id_proveedor,num_cuenta,banco,clabeInterbancaria) VALUES ('{$this->id_proveedor}','{$this->num_cuenta}','{$this->banco}','{$this->clabeInterbancaria}',);";
			
			$sql="INSERT INTO cuenta(id_proveedor,num_cuenta,banco,clabeInterbancaria,clave_sat,codigo_santander,divisa,sucursal,conveniocie,referenciacie1,referenciacie2) 
					VALUES ('{$this->id_proveedor}','{$this->num_cuenta}','{$this->banco}','{$this->clabeInterbancaria}','{$this->claveSAT}','{$this->codigoSantander}','{$this->divisa}','{$this->sucursal}','{$this->conveniocie}','{$this->referenciacie1}','{$this->referenciacie2}');";
			return $this->cmd->Ejecuta($sql);
		}

		
	}
 ?>