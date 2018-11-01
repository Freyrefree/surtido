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
		$xSQL="UPDATE movimiento SET estado='2',
									 usu_entrada = '$usu'
		 						 WHERE id_movimiento='$id'";
		mysql_query($xSQL);
		header('location:movimientos.php');
	}
}
header('location:movimientos.php');
?>