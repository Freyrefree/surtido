<?php

$finicial = $_POST['fi'];
$ffinal = $_POST['ff'];

include('../php_conexion.php'); 

if($finicial!='' && $ffinal!=''){
	$query = "select r.folio_compra,r.receptor,h.folio,h.operacion,h.fecha_operacion from historial_creditos as h, reg_factura as r where r.folio=h.folio AND h.fecha_operacion between '".$finicial." 00:00:00' and '".$ffinal." 23:59:59' order by h.fecha_operacion asc";
}else{
	$query = "select r.folio_compra,r.receptor,h.folio,h.operacion,h.fecha_operacion from historial_creditos as h, reg_factura as r where r.folio=h.folio  order by h.fecha_operacion asc";
}
	$consult = mysql_query($query);
	$tabla = '<style type="text/css"> *{font-family: arial; } table {margin:10px; background-color:#D8EBEB;} td{  background-color:#F9F9F9; height: 30px; text-align:center; padding:5px;}</style><table width="80%" ><tr><th><center>Folio de Compra</center></th><th><center>RFC Receptor</center></th><th><center>Folio Fiscal</center></th><th><center>Operación</center></th><th><center>Fecha de operación</center></th></tr>';
	 while ($fila = mysql_fetch_array($consult)) {

			$tabla .= '<tr>';
        	$tabla .= '<td  style="font-size:12px">'.$fila[folio_compra].'</td>';
        	$tabla .= '<td  style="font-size:12px">'.$fila[receptor].'</td>';
        	$tabla .= '<td  style="font-size:12px">'.$fila[folio].'</td>';
			$tabla .= '<td style="font-size:12px">'.$fila[operacion].'</td>';
        	$tabla .= '<td style="font-size:12px">'.$fila[fecha_operacion].'</td>';
        	$tabla .= '</tr>';
		 }
	$tabla .= '</table>';
	
	echo $tabla;	 

?>