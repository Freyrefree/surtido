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
			$cans=mysql_query("SELECT * FROM usuarios WHERE estado='s' and ced='$id'");
	
			if($dat=mysql_fetch_array($cans)){
				$xSQL="UPDATE usuarios SET estado='n' WHERE ced='$id'";
				mysql_query($xSQL);
				header('location:clientes.php');
			}else{
				$xSQL="UPDATE usuarios SET estado='s' WHERE ced='$id'";
				mysql_query($xSQL);
				header('location:usuarios.php');
			}
			
		}
	}
}
header('location:empleado.php');
?>