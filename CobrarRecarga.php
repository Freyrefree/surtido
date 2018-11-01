<?php 
		session_start();
		include('php_conexion.php'); 
		$usuario=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
		$can=mysql_query("SELECT MAX(factura) as maximo FROM factura  WHERE id_sucursal = '$id_sucursal'");//codigo de la factura	
        if($dato=mysql_fetch_array($can)){	$cfactura=$dato['maximo']+1;	}
		if($cfactura==1){$cfactura=1000;}//si es primera factura colocar que empieze en 1000
		
		$hoy=$fechay=date("Y-m-d");
		$venta = $_GET['monto'];
		$clientrfc="";
		$cod = $_GET['compania'];//codigo de producto de compania de recarga
		$ccpago=$_GET['monto'];//cantidad entrante de efectivo
		$tpagar=$_GET['monto'];//valor de la venta
		$numero=$_GET['numero'];
		$tipo="CONTADO";
		$fpago="CONTADO";
		$cant = 1;
		$importe = $venta;
	#resultados de la peticion
		$rcode = "";
		$confirm = "";
	#fin resultados de la peticion
		/*echo "<script>alert('$fechapago');</script>";*/
		//----------------obtiene compania---------------------------------------------
		$sent=mysql_query("SELECT * FROM compania_tl WHERE codigo ='$cod'");
	        if($data=mysql_fetch_array($sent)){ 
			$nom = "TAE ".$data['nombre'];
	      }
		//-----------------------------------------------------------------------------
	    //antes de agregar en la base de dato debe verificar que si se realizo con exito la recarga
	      	error_reporting(E_ALL);
			set_time_limit(0);
			error_reporting(E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING));

			$ClaveCanal = 'SURTEST';
			$PassCanal = 'prueba';
			$Id = '123456789037';
			$Terminal = '';
			$Producto = $cod; //codigo de producto compania
			$Producto = utf8_encode($Producto);
			$Destino = $numero;
			$Monto = $ccpago;
			$Monto = (double)$Monto;
			$Monto = sprintf("%.2f", $Monto);
			$Extra = '';
			$Nodo = '';
			$params = array('id' => $Id, 'claveCanal' => $ClaveCanal, 'passCanal' => $PassCanal, 'terminal' => $Terminal,'producto' => $Producto, 'destino' => $Destino, 'monto' => $Monto,'extra' => $Extra );
			// Valores de nodo padre 
			// $Nodo = "reverso";   //Modulo Reverso
			// $Nodo = "datos";     //Modulo datos
			// $Nodo = "consulta";  //Modulo saldoExterno
			// $Nodo = "status";    //Modulo statusVenta
			$Nodo = "venta";     //Modulo venta

			$arrayName = array( $Nodo => $params); // Este valor
			$liga='http://desarrollo.movivendor.com/wschan.wsdl';

			require_once('lib/nusoap.php');

			 $client = new nusoap_client($liga,'wsdl');
			 $client->soap_defencoding = 'UTF-8'; 
			 $client->decode_utf8 = false;

			$err = $client->getError();
			if ($err) {
				echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			}
			// Doc/lit parameters get wrapped
			$result = $client->call('venta',$arrayName);
			// Check for a fault
			if ($client->fault) {
				echo '<h2>Fault</h2><pre>';
				print_r($result);
				echo '</pre>';
			} else {
				// Check for errors
				$err = $client->getError();
				if ($err) {
					// Display the error
					echo '<h2>Error</h2><pre>' . $err . '</pre>';
				} else {
					// Display the result
					/*echo '<h2>Result</h2><pre>';
					print_r($result);
					echo '</pre>';*/
					/*echo '<h2> Rcode'.$result['rcode'].'</h2>';
					echo '<h2> Cconfirmacion'.$result['confirma'].'</h2>';*/
					$rcode = $result['rcode'];
					$confirm = $result['confirma'];
				}
			}

			/*echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
			echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';*/
	    //-----------------------------------------------------------------------------------------
		//-------------------guarda tabla factura---------------------------------------------------------
		if ($rcode == "00" AND !empty($confirm)) {
			$factura_sql="INSERT INTO factura (factura, cajera, fecha, estado, tipo_pago, id_sucursal) 
			VALUES ('$cfactura','$usuario','$hoy','s','$fpago','$id_sucursal')";
			mysql_query($factura_sql);
			//------------------------------------------------------------------------------------------------
			$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, fecha_op,usu,id_sucursal)
					VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe','$tipo',NOW(),'$usuario','$id_sucursal')";
			mysql_query($detalle_sql);
			$recarga_sql="INSERT INTO recarga (monto, numero, compania, estatus, id_sucursal, usuario, fecha_hora)
					VALUES ('$ccpago','$numero','$cod','s','$id_sucursal','$usuario',NOW())";
			mysql_query($recarga_sql);
			header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc.'&numero='.$numero.'&confirm='.$confirm);
		}else{
			echo "Error en la operacion";
		}
		
		
?>