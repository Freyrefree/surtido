<?php
session_start();
if(!isset($_SESSION["usuario"])){
header("location:CARGA_SAT/lectura_xml.php");
}else
{
	header ("Location: index.html");
}	
?>
<!--<frameset cols="100%">
  <frame src="inicio/index.html">
</frameset>-->