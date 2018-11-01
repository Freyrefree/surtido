<?php
session_start();
//include('php_conexion.php');
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(0);
include("host.php");
include("funciones.php");
$id_sucursal = $_SESSION['id_sucursal'];
$criterio = $_POST['criterio'];


if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
{

    if ($criterio != "") 
    {
        if ($_SESSION['tipo_usu']=='a' or $_SESSION['tipo_usu']=='te') {
            $consulta = "SELECT * FROM reparacion WHERE 
            id_reparacion LIKE '%$criterio%' OR 
            cod_cliente LIKE '%$criterio%' OR 
            nombre_contacto LIKE '%$criterio%' OR
            ap_contacto LIKE '%$criterio%' OR
            am_contacto LIKE '%$criterio%' OR
            CONCAT(nombre_contacto,' ',ap_contacto,' ',am_contacto) LIKE '%$criterio%' OR 
            telefono_contacto LIKE '%$criterio%'  ORDER BY id_reparacion DESC;";
        }else{
            $consulta = "SELECT * FROM reparacion WHERE 
            id_reparacion LIKE '%$criterio%' OR 
            cod_cliente LIKE '%$criterio%' OR 
            nombre_contacto LIKE '%$criterio%' OR
            ap_contacto LIKE '%$criterio%' OR
            am_contacto LIKE '%$criterio%' OR
            CONCAT(nombre_contacto,' ',ap_contacto,' ',am_contacto) LIKE '%$criterio%' OR 
            telefono_contacto LIKE '%$criterio%' AND id_sucursal = '$id_sucursal'  ORDER BY id_reparacion DESC;";
        }
    }else
    {
        if ($_SESSION['tipo_usu']=='a' or $_SESSION['tipo_usu']=='te') 
        {
            $consulta = "SELECT * FROM reparacion  ORDER BY id_reparacion DESC;";
        }else{
            $consulta = "SELECT * FROM reparacion WHERE id_sucursal = '$id_sucursal'  ORDER BY id_reparacion DESC;";
        }
    }
    if ($paquete = consultar($con, $consulta)) 
    {
        $codigoTabla = tabularReparaciones($paquete,$_SESSION['tipo_usu']);
        echo $codigoTabla;
    }else{}

}

?>