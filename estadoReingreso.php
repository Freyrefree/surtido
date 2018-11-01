<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php"); 
$usu=$_SESSION['username'];
$id_sucursal = $_SESSION['id_sucursal'];

if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te')
{
header('location:error.php');
}

$id_reparacion = trim($_POST['id_reparacion']);
$data = array();
if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
    $consulta = "SELECT estado FROM reparacion WHERE id_reparacion = '$id_reparacion'";
    if ($paquete = consultar($con, $consulta)) 
    {
        if ($fila = mysqli_fetch_array($paquete)) 
        {
            $estado = trim($fila['estado']);
            $data['estado'] = $estado;

            echo json_encode($data);
        }        
    }     
}
else{}


?>