<?php
include('../php_conexion.php');

$folio = $_POST['folio'];  

	$consult_folio = mysql_query("SELECT folio from reg_factura where folio_compra='$folio' AND estatus='vigente'");
	$fila_folio = mysql_fetch_array($consult_folio);
	$uuid = $fila_folio[folio];

	/*$zip = new ZipArchive();
	$filename = 'comprobantes/'.$uuid.'.zip';

	if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
  	  exit("cannot open <$filename>\n");
	}
	$thisdir = 'comprobantes/';
	$zip->addFile($thisdir . $uuid.'.pdf',$uuid.'.pdf');
	$zip->addFile($thisdir . $uuid.'.xml',$uuid.'.xml');
	$zip->close();*/
	
	echo $uuid;

?>