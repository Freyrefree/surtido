<?php 
	session_start();
	include('php_conexion.php');
	$id_comision = $_REQUEST['id'];
	//-----------------------------------------------------
	$can=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
	//echo "SELECT * FROM comision WHERE id_comision = '$id_comision'";
    if($dato=mysql_fetch_array($can)){
        $tipo=$dato['tipo'];
        echo $tipo;
    }else {
    	echo 0;
    }
 ?>