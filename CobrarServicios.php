<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
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
		$venta = $_GET['MontoServicio'];
		$clientrfc="";
		$IdCajero = $_SESSION['ced'];
		$cod = $_GET['servicio'];//codigo de producto de compania de recarga
		$MontoServicio=$_GET['MontoServicio'];//cantidad entrante de efectivo
		$Extra=$_GET['CampoExtra'];//valor de la venta
		$DestinoServicio=$_GET['DestinoServicio'];
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
		$sent=mysql_query("SELECT * FROM pagoservicios WHERE CodigoProducto ='$cod'");
	        if($data=mysql_fetch_array($sent)){ 
			$nom = "Servicio ".$data['NombreServicio'];
	      }
		//-----------------------------------------------------------------------------
	    //antes de agregar en la base de dato debe verificar que si se realizo con exito la recarga
	      	error_reporting(E_ALL);
			set_time_limit(0);
			error_reporting(E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING));

			$ClaveCanal = 'SURCELPROD';
			$PassCanal = 'Ejks258Rf25rsA5';

			$fecha = date_create();
			$TimeStamp = date_timestamp_get($fecha);
			$Longitud=strlen($str);

			if($Longitud<12){
			$TimeStamp = $TimeStamp."00";
			}


			$can=mysql_query("SELECT * FROM webservice");
			$ContaService = mysql_num_rows($can);

			if($ContaService==0){	

			 	$can=mysql_query("INSERT INTO webservice (IdWebService) VALUES ('$TimeStamp')");	

				 	$can=mysql_query("SELECT MAX(IdWebService) AS id FROM webservice");
					if($dato=mysql_fetch_row($can)){
						$IdWebService = $dato[0];
						$IdWebService=$IdWebService+1;	
					}
			    
			}else{
					$can=mysql_query("SELECT MAX(IdWebService) AS id FROM webservice");
					if($dato=mysql_fetch_row($can)){
						$IdWebService = $dato[0];
						$IdWebService=$IdWebService+1;
					} 

				$can=mysql_query("INSERT INTO webservice (IdWebService) VALUES ('$IdWebService')");	

			}
			
			$Terminal = '';
			$Producto = $cod; //codigo de producto compania
			$Producto = utf8_encode($Producto);
			$Destino = $DestinoServicio;
			$MontoServicio = $MontoServicio;
			$MontoServicio = (double)$MontoServicio;
			$MontoServicio = sprintf("%.2f", $MontoServicio);
			$Nodo = '';
			$params = array(
				'id' => $IdWebService, 
				'claveCanal' => $ClaveCanal, 
				'passCanal' => $PassCanal, 
				'terminal' => $Terminal,
				'producto' => $Producto, 
				'destino' => $Destino, 
				'monto' => $MontoServicio,
				'extra' => $Extra 
			);
			// Valores de nodo padre 
			// $Nodo = "reverso";   //Modulo Reverso
			// $Nodo = "datos";     //Modulo datos
			// $Nodo = "consulta";  //Modulo saldoExterno
			// $Nodo = "status";    //Modulo statusVenta
			$Nodo = "venta";     //Modulo venta

			$arrayName = array( $Nodo => $params); // Este valor
			$liga='https://www.movivendor.com/wsmovivendor.wsdl';

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
					'<h2>Error</h2><pre>' . $err . '</pre>';
					$rcode = $result['rcode'];
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

			//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
			//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	    //-----------------------------------------------------------------------------------------
		//-------------------guarda tabla factura---------------------------------------------------------
		if ($rcode == "00" AND !empty($confirm)) {

			$importe=$importe+12;
			$MontoServicio = $MontoServicio + 12;

			$factura_sql="INSERT INTO factura (factura, cajera, fecha, estado, tipo_pago, id_sucursal) 
			VALUES ('$cfactura','$usuario','$hoy','s','$fpago','$id_sucursal')";
			mysql_query($factura_sql) or die(print("Error en consulta 1 de Servicios"));
			//------------------------------------------------------------------------------------------------
			$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, fecha_op,usu,id_sucursal)
			VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe','$tipo',NOW(),'$usuario','$id_sucursal')";
			mysql_query($detalle_sql) or die(print("Error en consulta 2 de Servicios"));

			$sqla = mysql_query("SELECT * FROM caja WHERE id_cajero='$IdCajero'");/*,horainicio='$hora'*/
			if($datos=mysql_fetch_array($sqla)){

				$CantidadActual=$datos['cantidad'];
				$NuevaCantidad = $CantidadActual + $MontoServicio;

				$sqla = "UPDATE caja SET cantidad = '$NuevaCantidad' WHERE id_cajero='$IdCajero'";
				mysql_query($sqla) or die("Error en Consulta de Servicios No.3 ".mysql_error());

			}	

			/* Descuenta saldo virtual para servicios

			$sqla2 = mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal=$id_sucursal") or die("Error en Consulta de Servicios No.5 ".mysql_error());
			if($datos2=mysql_fetch_array($sqla2)){
      		$CanActVirtual=$datos2['Saldo'];
			$NewCantVirtual = $CanActVirtual - $MontoServicio;

			$sqla3 = "UPDATE recargassucursal SET Saldo = $NewCantVirtual WHERE IdSucursal=$id_sucursal";
            mysql_query($sqla3) or die("Error en Consulta de Servicios No.5 ".mysql_error());
			}	

			Fin de descuenta saldo virtual para servicios */

			

                
			$ServicioSql="INSERT INTO servicio (
				    Monto, 
					Referencia, 
					NombreServicio, 
					Estatus,
					IdSucursal, 
					Usuario, 
					Fechahora, 
					Extra) 
			VALUES ( $MontoServicio, 
					'$DestinoServicio',
					'$cod',
					's',
					'$id_sucursal',
					'$usuario',
					 now(),
					'$Extra')";
			mysql_query($ServicioSql) or die("Error en Consulta de Servicios No.3 ".mysql_error());

			$confirm = "$confirm - $IdWebService";

			header('location:ContadoServicios.php?tpagar='.$MontoServicio.'&ccpago='.$MontoServicio.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc.'&numero='.$DestinoServicio.'&confirm='.'&confirm='.$confirm);
		}else{
				if($rcode=="01"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Usuario no Existe
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="03"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Destino no Existe
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="04"){
				echo "
					
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Monto no válido
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="05"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Fondos insuficientes
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="09"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Datos inconsistentes
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="14"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Operación no permitda
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="15"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Usuario bloqueado
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="16"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Límite de transferencia excedido
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="20"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Sistema de prepago no responde
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="21"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Sistema de prepago no disponible
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="22"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Destino no es teléfono prepago
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="22"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Destino no es teléfono prepago
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="24"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Destino está en uso
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="25"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Destino está bloqueado
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="26"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Venta repetida
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="27"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br>Máximo de venta diaria rebasado
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="28"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Límite de crédito excedido
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="29"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Inventario insuficiente
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="30"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Operación fuera de horario
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="31"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Producto no válido
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="32"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Producto irreversible
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="33"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Producto no asignado
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="34"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Producto no disponible
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="36"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Servicio no disponible
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="50"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Error interno del webservice
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="51"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Base de datos no disponible
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="53"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Destino no ha pasado periodo mínimo de activación
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="55"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Producto temporalmente no disponible
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			
			if($rcode=="56"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Venta muy reciente
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="60"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Retener tarjeta
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="61"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Llamar a banco emisor
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="86"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Operación previamente revertida
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="87"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Operación no procesada
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="88"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Operación en progreso
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="89"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Operación no encontrada
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="90"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Mensaje incompleto
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
			if($rcode=="91"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Datos faltantes
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}

			if($rcode=="99"){
				echo "
					<div class='alert alert-warning' role='alert' style='font-size: 20px; margin-top: 10%;'>
					<strong>¡Error!</strong><br><br> Mensaje inválido
					<br><br><a href='caja.php' class='btn btn-lg btn-danger'>Volver a caja</a><br><br> Si tienes alguna duda contacta a tu administrador
					</div>
					";
			}
		}
		
		
?>