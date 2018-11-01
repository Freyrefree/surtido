<?php

include('../php_conexion.php'); 

	$consult = mysql_query("SELECT creditos,consumidos from creditos where estatus=1");
	$fila = mysql_fetch_array($consult);
     $array[0]=$fila[consumidos];
     $array[1]=$fila[creditos];
    $consult1 = mysql_query("SELECT creditos from creditos where estatus=2");
    $count = mysql_num_rows($consult1);
    if($count>0){
		$fila1 = mysql_fetch_array($consult1);
    	$array[2]=$fila1[creditos];
	}else{
		$array[2]=0;
	}															
	echo json_encode($array);
?>