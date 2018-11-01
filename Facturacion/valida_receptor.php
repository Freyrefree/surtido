<?php

include('../php_conexion.php'); 

$rfc=$_POST['rfc'];

$consult = mysql_query("SELECT * from cliente where rfc='$rfc' AND estatus='s'");
$fila = mysql_fetch_array($consult);
$array[0] = $fila[empresa];
$array[1] = $fila[pais];
$array[2] = $fila[estado];
$array[3] = $fila[municipio];
$array[4] = $fila[colonia];
$array[5] = $fila[calle];
$array[6] = $fila[cp];
$array[7] = $fila[next];
$array[8] = $fila[nint];
$array[9] = $fila[correo];
$array[10] = $fila[nom];
$array[11] = $fila[tel];
$array[12] = $fila[cel];

 echo json_encode($array);

?>