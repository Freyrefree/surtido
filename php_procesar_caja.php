<?php
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$codigo=$_GET['xcodigo'];
$cantidad=$_GET['cantidad'];

//echo $codigo;
//echo $cantidad;
$can=mysql_query("SELECT * FROM caja_tmp where cod='$codigo' or nom='$codigo' AND usu = '$usu'");
			if($dato=mysql_fetch_array($can)){
				$acant=$dato['cant']+1;	
			$dcodigo=$dato['cod'];
			//---------------------------------------------------------
			$ventapublico=$dato['venta'];
			
			  
              
            if($cantidad>=5)
            {
			  $id_sucu=$_SESSION['id_sucursal'];
              $consulta = "SELECT mayor FROM producto WHERE cod = '$dcodigo' AND id_sucursal = '$id_sucu'";
              $execquery=mysql_query($consulta);
			  $dato2=mysql_fetch_array($execquery);
			  
			  $preciomayoreo=$dato2['mayor'];
              $aventa=($preciomayoreo*$cantidad);
              $ventapublico=$preciomayoreo;

            }else{
			  $id_sucu=$_SESSION['id_sucursal'];
              $consulta = "SELECT venta FROM producto WHERE cod = '$dcodigo' AND id_sucursal = '$id_sucu'";
              $execquery=mysql_query($consulta);
			  $dato3=mysql_fetch_array($execquery);

				$precioventa=$dato3['venta'];
				$aventa=($precioventa*$cantidad);
				$ventapublico=$precioventa;


            //$aventa=$dato['venta']*$acant;
            }

			}
				$sql="Update caja_tmp Set venta='$ventapublico', importe='$aventa', cant='$cantidad' Where cod='$dcodigo' AND usu = '$usu'";
				mysql_query($sql);
header('location:caja.php');
?>
