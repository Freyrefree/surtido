<?php

session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:proveedor.php');
}else{
	$id=$_GET['id'];
	
	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a'){
			$cans=mysql_query("SELECT * FROM proveedor WHERE estado='s' and codigo='$id'");
	
			if($dat=mysql_fetch_array($cans)){
				$xSQL="Update proveedor Set estado='n' Where codigo=$id";
				mysql_query($xSQL);
				header('location:proveedor.php');
			}else{
				$xSQL="Update proveedor Set estado='s' Where codigo=$id";
				mysql_query($xSQL);
				header('location:proveedor.php');
			}
			
		}
	}
}
header('location:proveedor.php');
?>