<?php 
		session_start();
		include('php_conexion.php'); 
		$usuario=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
		$can=mysql_query("SELECT MAX(factura) as maximo FROM factura  WHERE id_sucursal = '$id_sucursal'");//codigo de la factura	
		$iccid = "";
		$imei = "";
        if($dato=mysql_fetch_array($can)){	$cfactura=$dato['maximo']+1;	}
		if($cfactura==1){$cfactura=1000;}//si es primera factura colocar que empieze en 1000
		$hoy=$fechay=date("Y-m-d");
		
		if($_GET['button']=='Cobrar Dinero Recibido'){ //contado
			$ccpago=$_GET['ccpago'];
			$tpagar=$_GET['tpagar'];
			$tipo=$_GET['tipocompra'];
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
			/*echo "<script>alert('$fechapago');</script>";*/
			$t_importe=0;
			if($tpagar<=$ccpago || $_GET['tipocompra'] == 'CREDITO'){
				//guarda tabla factura
				$factura_sql="INSERT INTO factura (factura, cajera, fecha, estado, tipo_pago, id_sucursal) VALUES ('$cfactura','$usuario','$hoy','s','$fpago','$id_sucursal')";
				mysql_query($factura_sql);	
				//codigo de la factura / guarda en detalles
				$can=mysql_query("SELECT * FROM caja_tmp where usu='$usuario'");	
				while($dato=mysql_fetch_array($can)){
					$cod=$dato['cod'];			$nom=$dato['nom'];			$cant=$dato['cant'];
					$venta=$dato['venta'];		$importe=$dato['importe'];	$t_importe=$t_importe+$importe;
					$imei=$dato['imei'];		$iccid = $dato['iccid'];	$n_ficha=$dato['n_ficha'];
					
					$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, fecha_op,usu,id_sucursal)
							VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe','$tipo',NOW(),'$usuario','$id_sucursal')";
					mysql_query($detalle_sql);
					//-----------------AGREGAR CANTIDAD A CAJA-----------------------------------------------------
					//obtener el id de usuario
					$u_sql=mysql_query("SELECT ced FROM usuarios where usu='$usuario'");
					if($udat=mysql_fetch_array($u_sql)){
						$cedula=$udat['ced']; //numero de cedula del ususario actual
					}
					/*echo "<script>alert($cedula);</script>";*/
					//obtener la cantidad actual de caja referente al usuario actual
					$c_sql=mysql_query("SELECT cantidad FROM caja where id_cajero='$cedula'");
					if($cdat=mysql_fetch_array($c_sql)){
						$cantidad=intval($cdat['cantidad']); //numero de cedula del ususario actual
					}
					/*echo "<script>alert($cantidad);</script>";
					echo "<script>alert($importe);</script>";*/
					$suma = $cantidad+$importe;
					/*echo "<script>alert($suma);</script>";*/
					//actualizar la cantidad encaja en cada venta debe aumentar
					$a_sql="UPDATE caja SET cantidad='$suma' where id_cajero = '$cedula' AND estado = '1'";
					mysql_query($a_sql);
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
	                          $sqll="UPDATE codigo_producto SET id_producto='$cod_pro',numero='0' WHERE identificador='$id_iccid'";mysql_query($sqll);
	                          $sqlm="UPDATE producto SET cantidad='$ncantidad' WHERE cod='$cod_pro' AND id_sucursal = '$id_sucursal'";mysql_query($sqlm);
	                        }
	                        //fin nuevo producto
	                      }
	                    }
	                }
	            #fin proceso cambio de producto iccid de celular a chip simple
					$imup="UPDATE codigo_producto SET estado='n' WHERE identificador = '$imei'";mysql_query($imup);
					$icup="UPDATE codigo_producto SET estado='n' WHERE identificador = '$iccid'";mysql_query($icup);
					$idup="UPDATE codigo_producto SET estado='n' WHERE identificador = '$n_ficha'";mysql_query($idup);
					/////////////////////////////////////////////
				}
				//-----------------AGREGAR NUEVA VENTA A CREDITO-----------------------------------------------
				if ($_GET['tipocompra'] == 'CREDITO') {
					$tipsis = $_GET['tipsis'];
					$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus, tipo,id_sucursal)
							VALUES ('$cfactura','$clientrfc','$tpagar','$ccpago','$resto','$hoy','$fechapago',0,'$tipsis','$id_sucursal')";
					mysql_query($credito_sql);
				}
				//---------------------------------------------------------------------------------------------

				$borrar_sql="DELETE FROM caja_tmp WHERE usu='$usuario'";//borrar todo de la caja temporal

				mysql_query($borrar_sql);
				
				
				header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc."&iccid=".$iccid."&imei=".$imei);
			}else{
				header('location:contado.php?mensaje=error');
			}
		}
		$_SESSION['ddes']=0;
		
?>