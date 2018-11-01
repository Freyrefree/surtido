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
		if($_SESSION['tipo_usu']=='a'){
			$cans=mysql_query("SELECT * FROM cliente WHERE estatus='s' and codigo='$id'");
	
			if($dat=mysql_fetch_array($cans)){
				$xSQL="Update cliente Set estatus='n' Where codigo=$id";
				mysql_query($xSQL);
				header('location:clientes.php');
			}else{
				$xSQL="Update cliente Set estatus='s' Where codigo=$id";
				mysql_query($xSQL);
				header('location:clientes.php');
			}
			
		}
	}
}
header('location:clientes.php');
?>