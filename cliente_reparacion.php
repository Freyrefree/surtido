<?php
// include('php_conexion.php');
// $buscar=$_GET['term'];
// $consulta = "SELECT CONCAT(codigo,',',nombre_completo) FROM
// cliente_reparacion WHERE nombre_completo like '%".$buscar."%' OR codigo LIKE '%".$buscar."%';";
// $rescliente = mysql_query($consulta);
// while($row=mysql_fetch_array($rescliente))
// {
// 	$data[] = array("value"=>$row['nombre_completo']);
// }

// echo json_encode($data);

include('php_conexion.php');
$buscar=$_GET['term'];
$consulta = "SELECT CONCAT(codigo,',',nombre_completo) AS nombre_completo FROM
 cliente_reparacion WHERE nombre_completo like '%".$buscar."%' OR codigo LIKE '%".$buscar."%'";
$rescliente=mysql_query($consulta);

while($row=mysql_fetch_array($rescliente))
{
	$data[] = array("value"=>$row['nombre_completo']);
}

echo json_encode($data);
?>