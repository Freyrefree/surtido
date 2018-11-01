<?php
//include('php_conexion.php');
session_start();
include("host.php");
include("funciones.php"); 

$id_sucursal  = $_SESSION['id_sucursal'];

$id=$_POST['id'];
$IdReparacion = $_POST['id_reparacion'];
$id_producto=$_POST['id_producto'];

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
    $consulta = "DELETE FROM reparacion_refaccion WHERE id_producto='$id_producto' AND id='$id'";
    if ($paquete = eliminar($con,$consulta) )
    {
        $consulta2 = "UPDATE producto SET cantidad=cantidad+1 WHERE cod='$id_producto' AND id_sucursal = '$id_sucursal'";
        if ($paquete = actualizar($con,$consulta2))
        {
            echo 1;

        } 
        else 
        {
            echo 0;
        }
        
    } 
    else 
    {
        echo 0;
    }	

}   


?>	