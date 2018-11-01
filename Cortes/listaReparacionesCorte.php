<?php
session_start();
include("../funciones.php");
include("../host.php");
error_reporting(0); 
$idSucursal   = $_SESSION['id_sucursal'];
$usuario      = $_SESSION['username'];
$tipoUsuario  = $_SESSION['tipo_usu'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='su'){
    header('../location:error.php');
}

$usuario = $_SESSION['username'];
##FECHA SALIDA
$fecha_inicio = $_POST['fechainicio'];
if($fecha_inicio == "--")
{
$fecha_inicio = "";
}else{
$fecha_inicio = $fecha_inicio." 00:00:00";
}
$fecha_fin = $_POST['fechafin'];
if($fecha_fin == "--")
{
$fecha_fin = "";
}else{
  $fecha_fin = $fecha_fin." 23:59:59";
}

###FECHA ENTRADA
$fecha_inicioen = $_POST['fechainicioen'];
if($fecha_inicioen == "--")
{
$fecha_inicioen = "";
}else{
$fecha_inicioen = $fecha_inicioen." 00:00:00";
}

$fecha_finen = $_POST['fechafinen'];
if($fecha_finen == "--")
{
$fecha_finen = "";
}else{
  $fecha_finen = $fecha_finen." 23:59:59";
}

###cajero
$cajero = $_POST['cajero'];

############################################################################################################################



if(($fecha_inicio == "") && ($fecha_fin == ""))
{
	$rango_fecha = "TODO";
}
else
{
	$rango_fecha = $fecha_inicio ." / " .$fecha_fin;
}

$codigoTabla = tabularCorteReparaciones($idSucursal,$usuario,$tipoUsuario,$fecha_inicio,$fecha_fin,$fecha_inicioen,$fecha_finen,$cajero);

echo $codigoTabla;


?>

