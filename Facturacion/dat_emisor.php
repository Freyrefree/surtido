<?php

include('../php_conexion.php');

$consult = mysql_query("SELECT * from dat_fiscal where id_empresa=1");
$fila = mysql_fetch_array($consult);
$cont[0] = $fila[rfc];
$cont[1] = utf8_encode($fila[razon_social]);
$cont[2] = utf8_encode($fila[pais]);
$cont[3] = utf8_encode($fila[estado]);
$cont[4] = utf8_encode($fila[municipio]);
$cont[5] = utf8_encode($fila[colonia]);
$cont[6] = utf8_encode($fila[calle]);
$cont[7] = $fila[cp];
$cont[8] = $fila[next];
$cont[9] = $fila[nint];
$cont[10] = $fila[correo];
$cont[11] = $fila[telefono];
$cont[12] = $fila[celular];
echo json_encode($cont);
?>