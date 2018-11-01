<?php

session_start();
include('../php_conexion.php');
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];
if(!$_SESSION['tipo_usu']=='a'){
	header('location:clientes.php');
}else{
	if($_SESSION['username']==""){
	}else{
		if($_SESSION['tipo_usu']=='a'){
			$factura = $_POST['factura'];
			$xSQL="UPDATE detalle SET garantia = 'garantia' WHERE factura = '$factura' AND id_sucursal = '$id_sucursal'";
			$answer = mysql_query($xSQL);
			if ($answer) {
				echo "1";
			}else {
				echo "0";
			}

		}
	}
}
?>