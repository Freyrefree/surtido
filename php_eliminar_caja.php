<?php
session_start();
include('php_conexion.php');
$usu=$_SESSION['username'];
$codigo=$_GET['id'];
//echo $codigo;
$xSQL="delete from caja_tmp  Where cod='$codigo' and usu='$usu'";
mysql_query($xSQL);
header('location:caja.php');
?>
