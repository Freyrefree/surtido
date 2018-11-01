<?php
$file="impress.prn";
if(($handle = fopen($file, "w")) === FALSE) { die("No se puedo Imprimir, Verifique su conexion con el Terminal"); }
fwrite($handle, chr(27). chr(64));//->Reinicializa la impresion, esto hay que hacerlo siempre al inicio.
fwrite($handle, chr(27). chr(97). chr(1));//->Centro
fwrite($handle, "Hola".PHP_EOL);
fwrite($handle, chr(27). chr(97). chr(0)); //->Izquierda
fwrite($handle, "ALINEADO A LA IZQUIERDA".PHP_EOL);
fwrite($handle, chr(27). chr(97). chr(2)); //->Derecha
fwrite($handle, "ALINEADO A LA DERECHA".PHP_EOL);
fwrite($handle, chr(27). chr(97). chr(1));//->Centro
fwrite($handle, "=================================".PHP_EOL);
fwrite($handle, "".PHP_EOL);
fwrite($handle, "".PHP_EOL);
fwrite($handle, "".PHP_EOL);
fclose($handle); // cierra el archivo
shell_exec("type $file>lpt1");
?>
