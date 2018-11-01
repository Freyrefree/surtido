<?php

include("FacturacionModerna/FacturacionModerna.php");

function pruebaCancelacion($uuid){
  /**
  * Niveles de debug:
  * 0 - No almacenar
  * 1 - Almacenar mensajes SOAP en archivo log.
  */
  $debug = 1;
  
  /*RFC utilizado para el ambiente de pruebas*/
  include('../php_conexion.php');
  $consult = mysql_query("SELECT * from dat_fiscal where rfc='ESI920427886'");
  $fila = mysql_fetch_array($consult);

  $rfc_emisor = $fila['rfc'];
  
  /*Datos de acceso al ambiente de pruebas*/
  $url_timbrado = "https://t1demo.facturacionmoderna.com/timbrado/wsdl";
  $user_id = $fila['user_id'];
  $user_password = $fila['user_pass'];

  $parametros = array('emisorRFC' => $rfc_emisor,'UserID' => $user_id,'UserPass' => $user_password);
  $cliente = new FacturacionModerna($url_timbrado, $parametros, $debug);

  /*Cambiar este valor por el UUID que se desea cancelar*/
  //$uuid = $folio;
  $opciones=null;
  
  if($cliente->cancelar($uuid, $opciones)){
  	mysql_query("UPDATE creditos set creditos=creditos-1, consumidos=consumidos+1 where estatus=1");
  	mysql_query("UPDATE reg_factura set estatus='cancelado' where folio='$uuid'");
  	mysql_query("INSERT INTO historial_creditos(folio,operacion,fecha_operacion)values('$uuid','cancelado',NOW())");
    echo "Cancelación exitosa\n";
  }else{
    echo "[".$cliente->ultimoCodigoError."] - ".$cliente->ultimoError."\n";
  }    
}

include('../php_conexion.php');
$folio = $_POST['folio'];  
	$consult_folio = mysql_query("SELECT r.folio from reg_factura as r where r.folio_compra='$folio' AND r.estatus='vigente'");
	$fila_folio = mysql_fetch_array($consult_folio);
	$uuid = $fila_folio[folio]; 
	pruebaCancelacion($uuid);

?>