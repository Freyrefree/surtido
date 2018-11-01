<?php
include('php_conexion.php');
$buscar=$_GET['term'];
$rescliente=mysql_query("SELECT empresa from cliente where empresa like '%".$buscar."%'");

while($row=mysql_fetch_array($rescliente))
{
	$data[] = array("value"=>$row['empresa']);
}

echo json_encode($data);
?>