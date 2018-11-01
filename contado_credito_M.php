<?php 

		session_start();
		include('php_conexion.php'); 
		$usuario=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		
		
		$can=mysql_query("SELECT MAX(factura) as maximo FROM factura");//codigo de la factura
        if($dato=mysql_fetch_array($can)){	$cfactura=$dato['maximo']+1;}
		if($cfactura==1){$cfactura=1000;}//si es primera factura colocar que empieze en 1000
		$hoy=$fechay=date("Y-m-d");
		
		if($_GET['button']=='Cobrar Dinero Recibido'){ //contado
			$ccpago=$_GET['ccpago'];
			$tpagar=$_GET['tpagar'];
			$tipo=$_GET['tipocompra'];
			$clientrfc=$_GET['client'];
			$fechapago=$_GET['fecha'];
			$resto=$tpagar-$ccpago;
			/*echo "<script>alert('$fechapago');</script>";*/
			$t_importe=0;
			if($tpagar<=$ccpago || $_GET['tipocompra'] == 'CREDITO'){
				//guarda tabla factura
				$factura_sql="INSERT INTO factura (factura, cajera, fecha, estado) VALUES ('$cfactura','$usuario','$hoy','s')";
				mysql_query($factura_sql);	
				//codigo de la factura / guarda en detalles
				$can=mysql_query("SELECT * FROM caja_tmp where usu='$usuario'");	
				while($dato=mysql_fetch_array($can)){
					$cod=$dato['cod'];			$nom=$dato['nom'];			$cant=$dato['cant'];
					$venta=$dato['venta'];		$importe=$dato['importe'];	$t_importe=$t_importe+$importe;
					
					$detalle_sql="INSERT INTO detalle (factura, codigo, nombre, cantidad, valor, importe, tipo, fecha_op,usu)
							VALUES ('$cfactura','$cod','$nom','$cant','$venta','$importe','$tipo',NOW(),'$usuario')";
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
					$ca=mysql_query("SELECT * FROM producto where cod='$cod'");	
					if($date=mysql_fetch_array($ca)){
						$e_actual=$date['cantidad'];
					}
					$n_cantidad=$e_actual-$cant;
					if($n_cantidad<0){	$n_cantidad=0;	}// si la cantidad da negativo ponerlo en 0
					$sql="Update producto Set cantidad='$n_cantidad' Where cod='$cod'";
					mysql_query($sql);	
					/////////////////////////////////////////////
				}
				//-----------------AGREGAR NUEVA VENTA A CREDITO-----------------------------------------------
				if ($_GET['tipocompra'] == 'CREDITO') {
					$credito_sql="INSERT INTO credito (id_factura,rfc_cliente, total, adelanto, resto, fecha_venta, fecha_pago, estatus)
							VALUES ('$cfactura','$clientrfc','$tpagar','$ccpago','$resto','$hoy','$fechapago',0)";
					mysql_query($credito_sql);
				}
				//---------------------------------------------------------------------------------------------

				$borrar_sql="DELETE FROM caja_tmp WHERE usu='$usuario'";//borrar todo de la caja temporal
				mysql_query($borrar_sql);
				
				header('location:contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago.'&factura='.$cfactura.'&tipo='.$tipo.'&rfc='.$clientrfc);
			}else{
				header('location:contado.php?mensaje=error');
			}
		}
		$_SESSION['ddes']=0;
		
?>