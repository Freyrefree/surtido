<?php

include('../php_conexion.php'); 

$fecha=$_POST['fecha'];
$folio=$_POST['folio'];
$importe=$_POST['importe'];

$consult = mysql_query("SELECT sum(importe)as importe from detalle where fecha_op like '$fecha%' AND factura='$folio'");
$fila = mysql_fetch_array($consult);
$array[0] = number_format($fila[importe],2);
$subtotal = number_format($fila[importe]/1.16,2);
$array[1] = $subtotal;
$array[2] = number_format($fila[importe]-$subtotal,2);

 echo json_encode($array);

?>