<?php 
//$conexion = mysql_connect("174.136.28.81","soysocom_soporte","soporte2015");
//mysql_select_db("soysocom_LAPASADITA",$conexion);
//	if(!empty($_SESSION['username']) and !empty($_SESSION['tipo_usu'])){
//		$usu=$_SESSION['username'];
//		$tip=$_SESSION['tipo_usu'];
//	}
//date_default_timezone_set("Mexico/General");

error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
$conexion = mysql_connect("localhost","root","");
mysql_select_db("tienda_surtidocell",$conexion);
	if(!empty($_SESSION['username']) and !empty($_SESSION['tipo_usu'])){
		$usu=$_SESSION['username'];
		$tip=$_SESSION['tipo_usu'];
	}
date_default_timezone_set("Mexico/General");

?>