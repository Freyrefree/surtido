<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php");
$id_reparacion = $_POST['id_reparacion'];

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
    $consulta = "SELECT * FROM reparacion_refaccion WHERE id_reparacion=$id_reparacion";
    if ($paquete = consultar($con, $consulta)) 
    {
        $codigoTabla = tabularRefacciones($paquete,$id_reparacion);
        echo $codigoTabla;
    }
    else
    {
        echo 2;
    }
}
else{
    echo 0;
}
?>