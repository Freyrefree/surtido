<?php

include("FacturacionModerna/FacturacionModerna.php");
date_default_timezone_set('America/Mexico_City');

/***************************************************************************
* Descripción: Ejemplo del uso de la clase FacturacionModerna, generando un
* archivo XML de un CFDI 3.2 y enviandolo a certificar.
*
* Nota: Esté ejemplo pretende ilustrar de manera general el proceso de sellado y
* timbrado de un XML que cumpla con los requerimientos del SAT.
* 
* Facturación Moderna :  (http://www.facturacionmoderna.com)
* @author Edgar Durán <edgar.duran@facturacionmoderna.com>
* @package FacturacionModerna
* @version 1.0
*
*****************************************************************************/

//pruebaTimbrado(6,1009);
function pruebaTimbrado($id_cliente,$folio){

  /**
  * Niveles de debug:
  * 0 - No almacenar
  * 1 - Almacenar mensajes SOAP en archivo log.
  */
  
  include('../php_conexion.php');
  $consult = mysql_query("SELECT * from dat_fiscal where rfc='ESI920427886'");
  $fila = mysql_fetch_array($consult);
  
  $debug = 1;
  
  //RFC utilizado para el ambiente de pruebas
  $rfc_emisor = $fila['rfc'];
  
  //Archivos del CSD de prueba proporcionados por el SAT.
  //ver http://developers.facturacionmoderna.com/webroot/CertificadosDemo-FacturacionModerna.zip
  $numero_certificado = $fila['num_certificado'];
  $archivo_cer = "utilerias/certificados/".$fila['archivo_cer'];
  $archivo_pem = "utilerias/certificados/".$fila['archivo_pem'];
  
    
  //Datos de acceso al ambiente de pruebas
  $url_timbrado = "https://t1demo.facturacionmoderna.com/timbrado/wsdl";
  $user_id = $fila['user_id'];
  $user_password = $fila['user_pass'];

  //generar y sellar un XML con los CSD de pruebas
  $cfdi = generarXML($rfc_emisor,$id_cliente,$folio);
  $cfdi = sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem);


  $parametros = array('emisorRFC' => $rfc_emisor,'UserID' => $user_id,'UserPass' => $user_password);

  $opciones = array();
  
  /**
  * Establecer el valor a true, si desea que el Web services genere el CBB en
  * formato PNG correspondiente.
  * Nota: Utilizar está opción deshabilita 'generarPDF'
  */     
  $opciones['generarCBB'] = false;
  
  /**
  * Establecer el valor a true, si desea que el Web services genere la
  * representación impresa del XML en formato PDF.
  * Nota: Utilizar está opción deshabilita 'generarCBB'
  */
  $opciones['generarPDF'] = true;
  
  /**
  * Establecer el valor a true, si desea que el servicio genere un archivo de
  * texto simple con los datos del Nodo: TimbreFiscalDigital
  */
  $opciones['generarTXT'] = false;
  

  $cliente = new FacturacionModerna($url_timbrado, $parametros, $debug);

  if($cliente->timbrar($cfdi, $opciones)){

    //Almacenanos en la raíz del proyecto los archivos generados.
    $comprobante = 'comprobantes/'.$cliente->UUID;
    
    if($cliente->xml){
      //echo "XML almacenado correctamente en $comprobante.xml\n";        
      file_put_contents($comprobante.".xml", $cliente->xml);
    }
    if(isset($cliente->pdf)){
      //echo "PDF almacenado correctamente en $comprobante.pdf\n";
      file_put_contents($comprobante.".pdf", $cliente->pdf);
    }
    if(isset($cliente->png)){
      //echo "CBB en formato PNG almacenado correctamente en $comprobante.png\n";
      file_put_contents($comprobante.".png", $cliente->png);
    }
    
    //echo "Timbrado exitoso\n";
    $folio_fiscal = str_replace('comprobantes/','', $comprobante);
    mysql_query("UPDATE creditos set creditos=creditos-1, consumidos=consumidos+1 where estatus=1");
    mysql_query("INSERT INTO historial_creditos(folio,operacion,fecha_operacion)values('$folio_fiscal','generacion',NOW())");
    return $folio_fiscal;
    
  }else{
    //echo "[".$cliente->ultimoCodigoError."] - ".$cliente->ultimoError."\n";
    $error = "Error";
    return $error;
  }    
}

function sellarXML($cfdi, $numero_certificado, $archivo_cer, $archivo_pem){
  
  $private = openssl_pkey_get_private(file_get_contents($archivo_pem));
  $certificado = str_replace(array('\n', '\r'), '', base64_encode(file_get_contents($archivo_cer)));
  
  $xdoc = new DomDocument();
  $xdoc->loadXML($cfdi) or die("XML invalido");

  $XSL = new DOMDocument();
  $XSL->load('utilerias/xslt32/cadenaoriginal_3_2.xslt');
  
  $proc = new XSLTProcessor;
  $proc->importStyleSheet($XSL);

  $cadena_original = $proc->transformToXML($xdoc);    
  openssl_sign($cadena_original, $sig, $private);
  $sello = base64_encode($sig);

  $c = $xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0); 
  $c->setAttribute('sello', $sello);
  $c->setAttribute('certificado', $certificado);
  $c->setAttribute('noCertificado', $numero_certificado);
  return $xdoc->saveXML();

}
function generarXML($rfc_emisor,$id_cliente,$folio){

  $fecha_actual = substr( date('c'), 0, 19);

  include('../php_conexion.php');
  $consult_cli = mysql_query("SELECT * from cliente where codigo=$id_cliente");
  $consult_emi = mysql_query("SELECT * from dat_fiscal where rfc='$rfc_emisor'");
  $consult_det = mysql_query("SELECT d.nombre,d.cantidad,d.valor,d.importe,d.codigo from detalle as d, producto as p where d.codigo=p.cod and d.factura='$folio'");
  $fila_cli = mysql_fetch_array($consult_cli);
  $fila_emi = mysql_fetch_array($consult_emi);
  $sum_subtotal=0;
  while ($fila_det=mysql_fetch_array($consult_det)){ 
     $codigo = $fila_det[codigo];
      $consult_unidad = mysql_query("SELECT nombre from unidad_medida where id=(SELECT unidad from producto where cod=2)");
    $fila_unidad = mysql_fetch_array($consult_unidad); 
    $nom_unidad = $fila_unidad[nombre];
    if($nom_unidad=='')
        $nom_unidad='No aplica'; 
    $valor_unitario = number_format(($fila_det[valor]/1.16),2);
    $valor_total = number_format(($fila_det[importe]/1.16),2);
    $sum_subtotal += $valor_total;
   $conceptos .= '<cfdi:Concepto cantidad="'.$fila_det[cantidad].'" unidad="'.$nom_unidad.'" noIdentificacion="'.$fila_det[codigo].'" descripcion="'.$fila_det[nombre].'" valorUnitario="'.$valor_unitario.'" importe="'.$valor_total.'">
      </cfdi:Concepto>';
  }
  $iva = ($sum_subtotal*0.16);
  $sum_total = number_format($sum_subtotal+$iva,2);
  $cfdi = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" version="3.2" fecha="$fecha_actual" tipoDeComprobante="ingreso" noCertificado="" certificado="" sello="" formaDePago="Pago en una sola exhibición" metodoDePago="Transferencia Electrónica" NumCtaPago="No identificado" LugarExpedicion="San Pedro Garza García, Mty." subTotal="$sum_subtotal" total="$sum_total">
<cfdi:Emisor nombre="$fila_emi[razon_social]" rfc="$rfc_emisor">
  <cfdi:RegimenFiscal Regimen="No aplica"/>
</cfdi:Emisor>
<cfdi:Receptor nombre="$fila_cli[empresa]" rfc="$fila_cli[rfc]"></cfdi:Receptor>
<cfdi:Conceptos>
  $conceptos
</cfdi:Conceptos>
<cfdi:Impuestos totalImpuestosTrasladados="$iva">
  <cfdi:Traslados>
    <cfdi:Traslado impuesto="IVA" tasa="16.00" importe="$iva"></cfdi:Traslado>
  </cfdi:Traslados>
</cfdi:Impuestos>
<cfdi:Addenda>
    <fmpdf:Detalles xmlns:fmpdf="https://dev.facturacionmoderna.com/utils" version="1.0" xsi:schemaLocation="https://dev.facturacionmoderna.com/utils https://dev.facturacionmoderna.com/utils/fmpdf_addenda.xsd">
      <fmpdf:Plantilla numDecimales="2" nombrePlantilla="custom" colorHex="" colorRGB="" nombreLogotipo="lg_e141fbacc856706e950bfb5" colorLetraE="" removerSellos="">
        <fmpdf:Pie sitioWeb="prueba.com.mx" email="prueba@gmail.com" telefono1="12-34-56-78-90" telefono2="" leyenda=""/>
      </fmpdf:Plantilla>
      <fmpdf:Cliente numeroCliente="" emailCliente="" telefonoCliente=""/>
      <fmpdf:Documento tipoDocumento="" ordenVenta="" ordenCompra="" importeLetra="" observaciones="Notas adicionales en PDF, para información adicional al cliente"/>
    </fmpdf:Detalles>
  </cfdi:Addenda>
</cfdi:Comprobante>
XML;
  return $cfdi;
}

?>
