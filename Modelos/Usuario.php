<?php

define('DOCROOTT', realpath(dirname(__FILE__)).'/'); 
require_once(DOCROOTT . '../APP/config.php');
require_once(DOCROOTT . '../APP/Conexion.php');

    
	class Usuario {

		private $ced;
		private $estado;		
    	private $nom; 
    	private $dir; 
        private $tel;
        private $cel;
        private $cupo;
        private $barrio;
        private $ciudad;
        private $usu;
        private $con;
        private $tipo;
        private $cp;
        private $sueldo;
        private $sexo;
        private $idSucursal;
        private $correo;
        
       


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

        public function obtieneUsuarioPorUsu(){

			$sql="SELECT * FROM usuarios WHERE usu ='{$this->usu}'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);

			if($array){
				
				$this->ced = $array['ced'];
				$this->estado = $array['estado'];
				$this->nom = $array['nom'];
				$this->dir = $array['dir'];
				$this->tel = $array['tel'];
				$this->cel = $array['cel'];
				$this->cupo = $array['cupo'];
				$this->barrio = $array['barrio'];
                $this->ciudad = $array['ciudad'];
                $this->usu = $array['usu'];
                $this->con = $array['con'];
                $this->tipo = $array['tipo'];
                $this->cp = $array['cp'];
                $this->sueldo = $array['sueldo'];
                $this->sexo = $array['sexo'];
                $this->idSucursal = $array['id_sucursal'];
                $this->correo = $array['correo'];
               
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