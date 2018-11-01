<?php 

include('funciones.php');
include('host.php');
date_default_timezone_set('America/Mexico_City');


$consulta = "SELECT fecha_pago FROM empresa WHERE id = '1'";
if($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
	if($paquete = consultar($con,$consulta)){

		$dato = mysqli_fetch_array($paquete);
		## Fecha base de Datos ##
		$fechaUltimoPago = $dato['fecha_pago'];

		## Fecha ACTUAL ##
		$hoy = date('Y-m-d');
		//$hoy = '2018-11-26';

		## Fecha Próximo mes ## 
		//$time = strtotime($fechaUltimoPago);
		//$proximoMes = date("Y-m-d", strtotime("+1 month", $time));
		$proximoMes = $fechaUltimoPago;

		## 5 días después del proximo mes ##
		$timeday = strtotime($proximoMes);
		$fechaLimite = date("Y-m-d", strtotime("+6 day", $timeday));

		$tolerancia  = date("Y-m-d", strtotime("+5 day", $timeday));


		$fTolStr = strtotime($tolerancia);
		$hoyStr = strtotime($hoy);
		$datediff = $fTolStr - $hoyStr;
		$diasRestantes = round($datediff / (60 * 60 * 24));
	

		if(($hoy >= $proximoMes) && ($hoy <= $tolerancia)) {


			//echo 2; 
			$array[0]=2;## Mensajes de pago ##
			$array[1]=$diasRestantes;
			echo json_encode($array);

		}else if($hoy >= $fechaLimite){

			//echo 0; 
			$array[0]=0;## Servicio Expirado ##
			$array[1]=$diasRestantes;
			echo json_encode($array);

		}else{
			//echo 1;
			$array[0]=1;  ## Servicio Disponible ##
			$array[1]=$diasRestantes;
			echo json_encode($array);
		}
	

	}

}


?>