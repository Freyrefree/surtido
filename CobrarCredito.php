<script src="includes/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="includes/sweetalert/dist/sweetalert.css">

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
		
if($_GET['button']=='Cobrar Dinero Recibido'){ //contado
$ccpago=$_GET['ccpago'];
$tpagar=$_GET['tpagar'];
$tipo=$_GET['tipocompra'];

$tipsis=$_GET['tipsis'];

#sacar el rfc del cliente a partir del nombre
$client= $_GET['client'];
$u_sql=mysql_query("SELECT * FROM cliente where empresa='$client'");
if($udat=mysql_fetch_array($u_sql)){
   $clientrfc=$udat['rfc'];
}


if(($clientrfc=="" || $clientrfc==NULL) && $tipo=="CREDITO"){
		  header('location:contado.php?OtrosMensajes=sinusuario');
}else{
			
			#sacar el rfc del cliente a partir del nombre
			$fechapago=$_GET['fecha'];
			$fpago=$_GET['fpago'];
			$resto=$tpagar-$ccpago;
			$ExMachineCount=0;
			/*echo "<script>alert('$fechapago');</script>";*/
			$t_importe=0;
			if($tpagar<=$ccpago || $_GET['tipocompra'] == 'CREDITO'){
				//guarda tabla factura
				$factura_sql="INSERT INTO factura (factura, cajera, fecha, estado, tipo_pago, id_sucursal) VALUES ('$cfactura','$usuario','$hoy','s','$fpago','$id_sucursal')";
				mysql_query($factura_sql);	
				//codigo de la factura / guarda en detalles
				$can=mysql_query("SELECT * FROM caja_tmp where usu='$usuario'");	
				while($dato=mysql_fetch_array($can)){
					  $cod=$dato['cod'];			
					  $nom=$dato['nom'];			
					  $cant=$dato['cant'];
					  $venta=$dato['venta'];		
					  $importe=$dato['importe'];	
					  $t_importe=$t_importe+$importe;
					  $imei=$dato['imei'];		
					  $iccid = $dato['iccid'];	
					  $n_ficha=$dato['n_ficha'];

					  $tipo_comision = $dato['tipo_comision'];
					
//$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, ICCID, IMEI, fecha_op,usu,id_sucursal, tipo_comision)VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe','$tipo','$iccid','$imei',NOW(),'$usuario','$id_sucursal',
								   //'$tipo_comision')";
					 //mysql_query($detalle_sql);
					//-----------------AGREGAR CANTIDAD A CAJA-----------------------------------------------------
					//obtener el id de usuario
					$u_sql=mysql_query("SELECT ced FROM usuarios where usu='$usuario'");
					if($udat=mysql_fetch_array($u_sql)){
						$cedula=$udat['ced']; //numero de cedula del ususario actual
					}
					//obtener la cantidad actual de caja referente al usuario actual
					$c_sql=mysql_query("SELECT cantidad FROM caja where id_cajero='$cedula'");
					if($cdat=mysql_fetch_array($c_sql)){
						$cantidad=$cdat['cantidad']; //numero de cedula del ususario actual
					}

					$importe = $_SESSION['neto'];
					$suma = $cantidad+$ccpago;

					if($ExMachineCount==0){
					//actualizar la cantidad encaja en cada venta debe aumentar
					$a_sql="UPDATE caja SET cantidad='$suma' where id_cajero = '$cedula' AND estado = '1'";
					mysql_query($a_sql);
					$ExMachineCount++;
					}
					//---------------------------------------------------------------------------------------------

					////ACTUALIZAR LA EXISTENCIA//////////////////
					$ca=mysql_query("SELECT * FROM producto where cod='$cod' AND id_sucursal = '$id_sucursal'");
					if($date=mysql_fetch_array($ca)){
						$e_actual=$date['cantidad'];
						$comision = $date['id_comision'];
						$compania = $date['compania'];
			            $quer=mysql_query("SELECT * FROM comision where id_comision = '$comision'");
			            if($row=mysql_fetch_array($quer)){
			              $tipo_pro = $row['tipo'];
			            }
					}
					$n_cantidad=$e_actual-$cant;
					if($n_cantidad<0){	$n_cantidad=0;	}// si la cantidad da negativo ponerlo en 0
					$sql="UPDATE producto SET cantidad='$n_cantidad' WHERE cod='$cod' AND id_sucursal = '$id_sucursal'";
					mysql_query($sql);

				#proceso cambio de producto iccid de celular a chip simple
					if ($tipo_pro == "TELEFONO" AND empty($iccid)) {
	                    //comision tipo chip
	                    $q=mysql_query("SELECT * FROM comision WHERE tipo = 'CHIP'");
	                    if($r=mysql_fetch_array($q)){$id_com = $r['id_comision'];}
	                    //fin comision chip
	                    $id_pro = $cod;
	                    $qu=mysql_query("SELECT * FROM codigo_producto WHERE identificador = '$imei'");
	                    if($ro=mysql_fetch_array($qu)){
	                      $numero = $ro['numero'];
	                      $qu1=mysql_query("SELECT * FROM codigo_producto WHERE id_producto='$id_pro' AND numero = '$numero'");
	                      if($ro1=mysql_fetch_array($qu1)){
	                        $id_iccid = $ro1['identificador'];
	                        //nuevo producto
	                        //-----------------------------------poner tipo de compañia telefonica
	                        $qu2=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_com' AND compania = '$compania' AND id_sucursal = '$id_sucursal'");
	                        //-----------------------------------poner tipo de compañia telefonica
	                        if($ro2=mysql_fetch_array($qu2)){
	                          $cod_pro = $ro2['cod'];
	                          $ncantidad = $ro2['cantidad']+1;
	                          //$sqll="UPDATE codigo_producto SET id_producto='$cod_pro',numero='0' WHERE identificador='$id_iccid'";mysql_query($sqll);
	                          $sqlm="UPDATE producto SET cantidad='$ncantidad' WHERE cod='$cod_pro' AND id_sucursal = '$id_sucursal'";mysql_query($sqlm);
	                        }
	                        //fin nuevo producto
	                      }
	                    }
	                }
				#fin proceso cambio de producto iccid de celular a chip simple

				//Eliminar IMEI de codigo_Producto				
					$imup = "DELETE FROM codigo_producto WHERE identificador  =  '$imei'";mysql_query($imup);

				//Si va con chip elimianr ICCID de codigo_producto

				if($iccid != ""){
					$cantidadICCID = 1;

					//obtener codigo prodeucto de iccid
					$consulta = "SELECT id_producto FROM codigo_producto WHERE identificador  = '$iccid'";
					$ejecutar = mysql_query($consulta);

					if(mysql_num_rows($ejecutar) > 0){
						$dato = mysql_fetch_array($ejecutar);
						$id_prodcuto = $dato['id_producto'];

						$update = "UPDATE producto SET cantidad = cantidad - '$cantidadICCID' WHERE cod = '$id_prodcuto' AND id_sucursal = '$id_sucursal'";
						mysql_query($update);
						$icup = "DELETE FROM codigo_producto WHERE identificador  =  '$iccid'";mysql_query($icup);
					}
					/////////////////////////////////////////////

				}


				}

				//-----------------AGREGAR NUEVA VENTA A CREDITO CON SALDO A FAVOR-----------------------------------------------
				if ($ccpago>$tpagar) {


					echo $TotalMenosCredito = $ccpago - $tpagar;

					$QuerySum    ="SELECT * FROM afavor WHERE RfcCliente='$clientrfc'";
					$ResQuerySum = mysql_query($QuerySum) or die(print("Error en insercción de saldo a favor".mysql_error()));
					 if($campo=mysql_fetch_array($ResQuerySum)){
	                	$CreditoGuardado = $campo['TotalMenosCredito'];
					 }

					 $SumCredito = $ContarCredito + $CreditoGuardado;

					$QueryExist      ="SELECT * FROM afavor WHERE RfcCliente='$clientrfc'";
					$ResQuery   = mysql_query($QueryExist) or die(print("Error en CONSULTA de saldo a favor".mysql_error()));
					$CuentaCuantos = mysql_num_rows($ResQuery);

					if($CuentaCuantos==0){
						echo "Insertado";
						$QueryLa="INSERT INTO afavor (RfcCliente, PrecioProducto, CantidadRecibida, Sobrante, FechaVenta, Tipo,IdSucursal)
								  VALUES ('$clientrfc',$tpagar,$ccpago,$TotalMenosCredito,'$hoy', '$tipsis','$id_sucursal')";
						mysql_query($QueryLa) or die(print("Error en insercción de saldo a favor".mysql_error()));
					}else{
						echo "Actualizando";
						$QueryLa="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=Sobrante+$TotalMenosCredito, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
						mysql_query($QueryLa) or die(print("Error actualización de saldo a favor PAGO MAYOR".mysql_error()));	
					}

						header('location:Afavor.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
					}

					//-----------------AGREGAR NUEVA VENTA A CREDITO-----------------------------------------------
		
				//---------------------------------------------------------------------------------------------

				//-----------------AGREGAR NUEVA VENTA A CREDITO REVISANDO EL CREDITO ACTUAL-----------------------------------------------
				if ($ccpago<$tpagar) {


					//echo $ContarCredito = $ccpago - $tpagar;

					$QuerySum    ="SELECT * FROM afavor WHERE RfcCliente='$clientrfc'";
					$ResQuerySum = mysql_query($QuerySum) or die(print("Error en insercción de saldo a favor".mysql_error()));
					 if($campo=mysql_fetch_array($ResQuerySum)){
	                	$CreditoGuardado = $campo['Sobrante'];
					 }else{
						 $CreditoGuardado=0;
					 }

					 if($CreditoGuardado>0){
					    $SumCredito = $ccpago + $CreditoGuardado;
					    $TotalMenosCredito = $tpagar - $SumCredito;	
					}else{
						$TotalMenosCredito = 0;
					}

					$QueryExist      ="SELECT * FROM afavor WHERE RfcCliente='$clientrfc'";
					$ResQuery   = mysql_query($QueryExist) or die(print("Error en insercción de saldo a favor".mysql_error()));
					$CuentaCuantos = mysql_num_rows($ResQuery);

					if($CuentaCuantos==0){
						echo "Insertado";
						$QueryLa="INSERT INTO afavor (RfcCliente, PrecioProducto, CantidadRecibida, Sobrante, FechaVenta, Tipo,IdSucursal)
								  VALUES ('$clientrfc',$tpagar,$ccpago,$TotalMenosCredito,'$hoy', '$tipsis','$id_sucursal')";
						mysql_query($QueryLa) or die(print("Error en insercción de saldo a favor".mysql_error()));

						if ($CreditoGuardado==0 && $ccpago!=0 && $tpagar>$ccpago) {
						echo "cumplida 4";	
							$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
									VALUES ('$cfactura','$clientrfc','$tpagar','$ccpago','$resto','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
							mysql_query($credito_sql);
						}	

					}else{
						echo "Actualizando";
						//echo $tpagar;
						//echo $ccpago;
						//echo $TotalMenosCredito;

						if($TotalMenosCredito==0){
						    $QueryLan="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=$TotalMenosCredito, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
						    mysql_query($QueryLan) or die(print("Error actualización de saldo a favor PAGO MENOR".mysql_error()));
						}

						if($CreditoGuardado>$tpagar && $TotalMenosCredito<0)
						{
							echo "condicion negativa";
							$Sosobra=($TotalMenosCredito)*-1;
						    $QueryLan="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=$Sosobra, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
						    mysql_query($QueryLan) or die(print("Error actualización de saldo a favor PAGO MENOR".mysql_error()));

							$borrar_sql="DELETE FROM caja_tmp WHERE usu='$usuario'";
							mysql_query($borrar_sql);

							header('location:Afavor.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
							exit();	
						}

						if($TotalMenosCredito>0){
							echo "Cumplida condicion de TotalMenosCredito";
							$QueryLan="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=Sobrante+$TotalMenosCredito, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
							mysql_query($QueryLan) or die(print("Error actualización de saldo a favor PAGO MENOR".mysql_error()));	
						}

						if($CreditoGuardado<$TotalMenosCredito && $TotalMenosCredito!=0){
							$QueryLan="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=0, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
							mysql_query($QueryLan) or die(print("Error actualización de saldo a favor PAGO MENOR".mysql_error()));	
						}

						if($tpagar>$TotalMenosCredito  && $TotalMenosCredito!=0){
							$CreditoRestante = $SumCredito-$TotalMenosCredito;
							$QueryLan="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=0, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
							mysql_query($QueryLan) or die(print("Error actualización de saldo a favor PAGO MENOR".mysql_error()));	

							$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
									VALUES ('$cfactura','$clientrfc','$tpagar','$CreditoGuardado','$TotalMenosCredito','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
							mysql_query($credito_sql);



						}
					
					//-----------------AGREGAR NUEVA VENTA A CREDITO-----------------------------------------------
					if ($_GET['tipocompra'] == 'CREDITO' && $CreditoGuardado>0 && $TotalMenosCredito!=0 && $CreditoGuardado<$tpagar && $ccpago!=0) {
						$tipsis = $_GET['tipsis'];
						echo "cumplida 1";	
							$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
									VALUES ('$cfactura','$clientrfc','$tpagar','$SumCredito','$TotalMenosCredito','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
							mysql_query($credito_sql);

					}

					if($CreditoGuardado==0){
						echo "cumplida 2";
							$Restante = $tpagar - $ccpago;
							$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
									VALUES ('$cfactura','$clientrfc','$tpagar','$ccpago','$Restante','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
							mysql_query($credito_sql);
				
					}

					if($CreditoRestante>0 && $ccpago!=0 && $tpagar<$SumCredito){
							echo "cumplida 3";
							$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
									VALUES ('$cfactura','$clientrfc','$tpagar','$ccpago','$CreditoRestante','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
							mysql_query($credito_sql);
				
					}

					if($CreditoGuardado>$tpagar && $ccpago==0 && $TotalMenosCredito>0){
							echo "cumplida 5";


							$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
									VALUES ('$cfactura','$clientrfc','$tpagar','$tpagar','0','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
							mysql_query($credito_sql);

							$Operacion = $tpagar-$CreditoGuardado;

							$QueryLan="UPDATE afavor SET PrecioProducto=$tpagar, CantidadRecibida=$ccpago, Sobrante=$Operacion, FechaVenta='$hoy', IdSucursal='$id_sucursal' WHERE RfcCliente='$clientrfc'";
							mysql_query($QueryLan) or die(print("Error actualización de saldo a favor PAGO MENOR".mysql_error()));	
				
					}


					//---------------------------------------------------------------------------------------------


						
					}


				}

				if ($ccpago==$tpagar) {
					header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
				}		
				//---------------------------------------------------------------------------------------------
				//borrar todo de la caja temporal

				header('location:Afavor.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
					

				$borrar_sql="DELETE FROM caja_tmp WHERE usu='$usuario'";
				mysql_query($borrar_sql);
				
				header('location:Afavor.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
			
			}		
}
}
$_SESSION['ddes']=0;	
?>