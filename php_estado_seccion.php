<?php

session_start();
include('php_conexion.php');

$id=$_GET['id'];

if($_SESSION['username']==""){
}else{
	if($_SESSION['tipo_usu']=='a'){
		$cans=mysql_query("SELECT * FROM seccion WHERE estado='s' and id='$id'");

		if($dat=mysql_fetch_array($cans)){
			$xSQL="Update seccion Set estado='n' Where id=$id";
			mysql_query($xSQL);
			header('location:seccion.php');
		}else{
			$xSQL="Update seccion Set estado='s' Where id=$id";
			mysql_query($xSQL);
			header('location:seccion.php');
		}
		
	}
}

?>