<?php 
	//include_once '../app/config.php'; #Configuracion
    include_once '../app/Conexion.php';#inclusion de archivo
    
	class Reparacion {

		private $id_reparacion;
		private $id_sucursal;		
    	private $usuario; 
    	private $cod_cliente; 
        private $imei;
        private $marca;
        private $modelo;
        private $color;
        private $precio;
        private $preciomenosAnticipo;
        private $precio_inicial;
        private $precio_final;
        private $abono;
        private $resto;
        private $motivo;
        private $observacion;
        private $fechaIngreso;
        private $fechSalida;
        private $id_comision;
        private $estado;
        private $chip;
        private $memoria;
        private $costo;
        private $nombre_contacto;
        private $ap_contacto;
        private $telefono_contacto;
        private $rfc_curp_contacto;
        private $tecnico;
        private $id_productos;
        private $garantia;
        private $id_garantia;
        private $tipo_precio;
        private $mano_obra;
        private $CostoRefaccion;
        private $correo;
        private $direccion;
        private $total;
        private $pagoResto;
        private $descripliberacion;
        private $comisionCajero;
        private $totalComisionCajero;


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

		public function obtieneClabeInterbancaria(){

			$sql="SELECT * FROM cuenta WHERE id ='{$this->id}'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);


			if($array){
				
				$this->num_cuenta = $array['num_cuenta'];
				$this->banco = $array['banco'];
				$this->clabeInterbancaria = $array['clabeInterbancaria'];
				$this->claveSAT = $array['clave_sat'];
				$this->codigoSantander = $array['codigo_santander'];

				$this->sucursal = $array['sucursal'];
				$this->conveniocie = $array['conveniocie'];
				$this->referenciacie1 = $array['referenciacie1'];
				$this->referenciacie2 = $array['referenciacie2'];
			}


		}
	}
 ?>