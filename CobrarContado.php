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
$ddes = $_SESSION['ddes'];


#sacar el rfc del cliente a partir del nombre
$client= $_GET['client'];
$u_sql=mysql_query("SELECT * FROM cliente where empresa='$client'");
if($udat=mysql_fetch_array($u_sql)){
   $clientrfc=$udat['rfc'];
}
	
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
					  $nombre_chip=$dato['nombre_chip'];
					  $tipo_comision = $dato['tipo_comision'];

					  $importe_descuento = ($importe*$ddes/100);
					  $importe_final = $importe - $importe_descuento;
					
					 $detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, ICCID, IMEI, fecha_op,usu,id_sucursal,nombreChip,
					 tipo_comision)
							       VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe_final','$tipo','$iccid','$imei',NOW(),'$usuario','$id_sucursal','$nombre_chip',
								   '$tipo_comision')";
					 mysql_query($detalle_sql);
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
					$suma = $tpagar+$cantidad;

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
	                        //-----------------------------------poner tipo de compaÃ±ia telefonica
	                        $qu2=mysql_query("SELECT * FROM producto WHERE id_comision = '$id_com' AND compania = '$compania' AND id_sucursal = '$id_sucursal'");
	                        //-----------------------------------poner tipo de compaÃ±ia telefonica
	                        if($ro2=mysql_fetch_array($qu2)){
	                          $cod_pro = $ro2['cod'];
	                          $ncantidad = $ro2['cantidad']+1;
	                          $sqll="UPDATE codigo_producto SET id_producto='$cod_pro',numero='0' WHERE identificador='$id_iccid'";mysql_query($sqll);
	                          $sqlm="UPDATE producto SET cantidad='$ncantidad' WHERE cod='$cod_pro' AND id_sucursal = '$id_sucursal'";mysql_query($sqlm);
	                        }
	                        //fin nuevo producto
	                      }
	                    }
					}
					
				//*****Restar Cantidad a prodcuto chip de a cuerdo al ICCID Vendido (venta de TELEFONO con ICCID)***********
				if($imei != "" && $iccid != ""){
				$consultaidchip = "SELECT id_producto FROM codigo_producto WHERE identificador = '$iccid'";
				$ejecutar = mysql_query($consultaidchip);
				$dato = mysql_fetch_array($ejecutar);
				$id_prodcutoChip = $dato['id_producto'];
				$restarICCID = "UPDATE producto SET cantidad = (cantidad - 1) WHERE cod='$id_prodcutoChip' AND id_sucursal = '$id_sucursal'";
				$ejecutar = mysql_query($restarICCID);
				}
				//**************************************************************************************************************
	            #fin proceso cambio de producto iccid de celular a chip simple
					$imup="DELETE FROM codigo_producto  WHERE identificador = '$imei'";mysql_query($imup);
					$icup="DELETE FROM codigo_producto  WHERE identificador = '$iccid'";mysql_query($icup);
					$idup="DELETE FROM codigo_producto  WHERE identificador = '$n_ficha'";mysql_query($idup);
					/////////////////////////////////////////////
				}


				header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);	
				//---------------------------------------------------------------------------------------------
				//borrar todo de la caja temporal
				$borrar_sql="DELETE FROM caja_tmp WHERE usu='$usuario'";
				mysql_query($borrar_sql);
				
				//header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
			
			}		
}	
?>