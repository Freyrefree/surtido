<?php 
session_start();
$usuario=$_SESSION['username'];
include('php_conexion.php');
$cans=mysql_query("SELECT * FROM usuarios where usu='$usuario'");
if($datos=mysql_fetch_array($cans)){
  $ced = $datos['ced'];
}
$hora = date("g:i");
$fecha = date("Y-m-d");
  $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
  if($dat=mysql_fetch_array($sqle)){
    $ventas = $dat['cantidad'];
    $hi = $dat['horainicio'];
    $aper=$dat['apertura'];
    
	$cierrecaja = $ventas + $apertura;
	$sqlf = "INSERT INTO detalle_caja (id_cajero,apertura,ventas,cierre,horainicio,horacierre,fecha,autoriza)
	          VALUES ('$ced','$aper','$ventas','$cierrecaja','$hi','$hora','$fecha','')";
	mysql_query($sqlf);
  }

$sqla = "UPDATE caja SET horainicio='', horafin = '$hora',estado=0, apertura='$reserva', cantidad = '0' WHERE id_cajero='$ced'";
mysql_query($sqla);
$_SESSION['username']=NULL;
$_SESSION['tipo_usu']=NULL;
$_SESSION['id_empresa']=NULL;
session_destroy();

header("location:index.php");	
?>