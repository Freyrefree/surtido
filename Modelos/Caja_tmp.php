<?php 

define('DOCROOT', realpath(dirname(__FILE__)).'/'); 
require_once(DOCROOT . '../APP/config.php');
require_once(DOCROOT . '../APP/Conexion.php');

    
	class Caja_tmp {

		private $id;
		private $cod;		
    	private $nom; 
    	private $venta; 
        private $cant;
        private $importe;
        private $existencia;
        private $usu;
        private $imei;
        private $iccid;
        private $nombre_chip;
        private $tipo_comision;
       


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

        public function obtieneAllProdByUsu(){

			$sql="SELECT * FROM caja_tmp WHERE usu ='{$this->usu}'";
            $datos= $this->cmd->Ejecuta($sql);
            if(mysqli_num_rows($datos)>0){
                return true;

            }else{

                return false;

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