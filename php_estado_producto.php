<?php

session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:producto.php');
}else{
	$id=$_GET['id'];
	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a'){
			$cans=mysql_query("SELECT * FROM producto WHERE estado='s' AND  cod='$id' AND id_sucursal = '$id_sucursal'");
	
			if($dat=mysql_fetch_array($cans)){
				$xSQL="Update producto Set estado='n' Where cod='$id' AND id_sucursal = '$id_sucursal'";
				mysql_query($xSQL);
				header('location:empresa.php');
			}else{
				$xSQL="Update producto Set estado='s' Where cod='$id' AND id_sucursal = '$id_sucursal'";
				mysql_query($xSQL);
				header('location:empresa.php');
			}
			
		}
	}
}
header('location:producto.php');
?>