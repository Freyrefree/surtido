<?php
session_start();
//error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(0);
include("host.php");
include("funciones.php");

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{
    $consulta = "SELECT * FROM usuarios ORDER BY nom ASC"; //Todas menos la sucursal MATRIZ
    if ($paquete = consultar($con, $consulta)) 
    {
        $codigoTabla = tabularUsuarios($paquete);
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