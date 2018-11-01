<?php
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:clientes.php');
}else{
	$id=$_GET['id'];
	if($_SESSION['username']==""){
	}else{
		$query=mysql_query("SELECT * FROM movimiento WHERE id_movimiento = '$id'");
		//echo "SELECT * FROM movimiento WHERE id_movimiento = '$id' <br>";
            if($dato=mysql_fetch_array($query)){
            	//datos de movimiento
            	$cantidad = $dato['cantidad'];
            	$id_suc_salida = $dato['id_suc_salida'];
            	$id_suc_entrada = $dato['id_suc_entrada'];
            	$id_producto = $dato['id_producto'];
            	$query2=mysql_query("SELECT * FROM producto WHERE cod = '$id_producto' AND id_sucursal = '$id_suc_salida'");
            	//echo "SELECT * FROM producto WHERE cod = '$id_producto' AND id_sucursal = '$id_suc_salida' <br>";
	            if($dato2=mysql_fetch_array($query2)){
	            	$gcantidad = $dato2['cantidad']-$cantidad;
	            	//echo $gcantidad."<br>";
	            }
	            $query3=mysql_query("SELECT * FROM producto WHERE cod = '$id_producto' AND id_sucursal = '$id_suc_entrada'");
	            //echo "SELECT * FROM producto WHERE cod = '$id_producto' AND id_sucursal = '$id_suc_entrada' <br>";
            	if($dato3=mysql_fetch_array($query3)){
            		$ncantidad = $dato3['cantidad']+$cantidad;
            		//echo $ncantidad."<br>";
            	}
            	$sql="UPDATE producto SET  cantidad='$gcantidad'
		            WHERE cod='$id_producto' AND id_sucursal = '$id_suc_salida'";
		            //echo $sql;
		            //echo "<br>";
		            mysql_query($sql);
		        $sql2="UPDATE producto SET  cantidad='$ncantidad'
		            WHERE cod='$id_producto' AND id_sucursal = '$id_suc_entrada'";
		            //echo $sql2;
		        	mysql_query($sql2);
		    #actualizacion del estado del movimiento
				$xSQL="UPDATE movimiento SET estado='2',
											 usu_entrada = '$usu',
											 fecha2 = NOW()
				 						 WHERE id_movimiento='$id'";
				$id_movimiento = $dato['id_movimiento'];
				mysql_query($xSQL);
			#fin actualizacion del estado del movimiento

				$can=mysql_query("SELECT * FROM codigo_producto_temp WHERE id_movimiento = '$id_movimiento'");
                while($dato=mysql_fetch_array($can)){
                	$identificador = $dato['identificador'];
                	$id_sucursal = $dato['id_sucursal'];
                	$sql2="UPDATE codigo_producto SET id_sucursal='$id_sucursal'
		            WHERE identificador='$identificador'";
		            //echo $sql2;
		        	mysql_query($sql2);
                }
                $sqld="DELETE FROM codigo_producto_temp WHERE id_movimiento = '$id_movimiento'";
		            //echo $sql2;
		        mysql_query($sqld);
            }
		header('location:movimientos.php');
	}
}
header('location:movimientos.php');
?>