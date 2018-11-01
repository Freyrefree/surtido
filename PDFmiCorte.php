<?php
 		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'or !$_SESSION['tipo_usu']=='su'){
			header('location:error.php');
		}

$usuario = $_SESSION['username'];
$fecha_inicio = $_GET['fechainicio'];
if($fecha_inicio == "--")
{
$fecha_inicio = "";
}else{
$fecha_inicio = $fecha_inicio." 00:00:00";
}
$fecha_fin = $_GET['fechafin'];
if($fecha_fin == "--")
{
$fecha_fin = "";
}else{
  $fecha_fin = $fecha_fin." 23:59:59";
}

if(($fecha_inicio == "") && ($fecha_fin == ""))
{
	$rango_fecha = "TODO";
}
else
{
	$rango_fecha = $fecha_inicio ." / " .$fecha_fin;
}

//*********************************TODO*********************************************
if(($fecha_inicio == "") && ($fecha_fin == ""))
{
  $consulta = "SELECT * FROM detalle WHERE usu = '$usuario';";
  $can = mysql_query($consulta);
  
  $canart=mysql_query("SELECT SUM(cantidad)FROM detalle WHERE usu = '$usuario';");
  $row=mysql_fetch_array($canart);
  $cantidad_art= $row[0];

  $canimporte=mysql_query("SELECT SUM(importe)FROM detalle WHERE usu = '$usuario';");
  $row1=mysql_fetch_array($canimporte);
  $importe1= $row1[0];
}
//*****************************************************PIVOTE FECHAS**************************************************************************************
if(($fecha_inicio != "") && ($fecha_fin != ""))
{
  $consulta = "SELECT * FROM detalle WHERE usu = '$usuario' AND fecha_op BETWEEN '$fecha_inicio' AND '$fecha_fin';";
  $can = mysql_query($consulta);
  
  $canart=mysql_query("SELECT SUM(cantidad)FROM detalle WHERE usu = '$usuario' AND fecha_op BETWEEN '$fecha_inicio' AND '$fecha_fin';");
  $row=mysql_fetch_array($canart);
  $cantidad_art= $row[0];

  $canimporte=mysql_query("SELECT SUM(importe)FROM detalle WHERE usu = '$usuario' AND fecha_op BETWEEN '$fecha_inicio' AND '$fecha_fin';");
  $row1=mysql_fetch_array($canimporte);
  $importe1= $row1[0];
}
//*******************************************************TABLAS RESULTADOS********************************************************************************/



$codigoHTML=' 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte Mi Corte</title>
</head>
<body>';

$codigoHTML.='<table>
<tr>
<th><img src="img/logoa.jpg" width="114" height="90" alt="" /></th>
</tr>
</table>';

$codigoHTML.='<table id="reporte">
<tr>
<th>Usuario</th>
<th>Cantidad Artículos</th>
<th>Venta Total</th>
<th>Fecha Consulta Ventas</th>
</tr>
<tr>
<td>'.$usuario.'</td>
<td>'.$cantidad_art.'</td>
<td>$ '.number_format($importe1, 2, ',', ' ').'</td>
<td>'.$rango_fecha.'</td>
</tr>
</table>';


$codigoHTML.='<table id="reporte">
<tr>
<th>No</th>
<th>Factura</th>
<th>Codigo</th>
<th>Nombre</th>

<th>IMEI</th>
<th>Nom Chip</th>
<th>ICCID</th>

<th>Cantidad</th>
<th>Valor</th>
<th>Importe</th>

<th>Tipo Comision</th>
<th>Total Comision</th>      
<th>Tipo Venta</th> 

<th>Fecha Venta</th>
<th>Usuario</th>
<th>Sucursal</th>
</tr>';
$contador=0;
while($dato=mysql_fetch_array($can)){
	$contador++;
	$factura = $dato['factura'];
	$id_producto = $dato['codigo'];
	$nombre = $dato['nombre'];

	$imei = $dato['IMEI'];
  	$nombrechip = $dato['nombreChip'];
	$iccid = $dato['ICCID'];
	  
	$cantidad = $dato['cantidad'];
	$valor = $dato['valor'];
	$importe = $dato['importe'];
	$fecha_op = $dato['fecha_op'];
	$usuario = $dato['usu'];
	//......nombre sucursal inicio.........................................................
	$idsucursal=$dato['id_sucursal'];
	$querynombresucursal="SELECT empresa FROM empresa WHERE id = '$idsucursal'";
	$canempresa = mysql_query($querynombresucursal);
	$dato2 = mysql_fetch_array($canempresa);
	$nombreempresa = $dato2['empresa'];
	//......nombre sucursal fin.........................................................
  if ($dato['tipo'] == 'CREDITO') {
	$tipov = "Credito/Apartado";
  }else {
	$tipov = "Contado";
	}

	$precioU = $dato['valor'];
$precioU = number_format($precioU, 2, '.', '');
$cantidad = $dato['cantidad'];
$id_producto = $dato['codigo'];
$consultaProducto = "SELECT * FROM producto WHERE cod='$id_producto' LIMIT 1";
$ejecutar2 = mysql_query($consultaProducto);
$dato2 = mysql_fetch_array($ejecutar2);
$id_comision = $dato2['id_comision'];
$costo_producto = $dato2['costo'];

$consultaComision="SELECT * FROM comision WHERE id_comision = '$id_comision'";
$ejecutar3 = mysql_query($consultaComision);
$dato3=mysql_fetch_array($ejecutar3);  

//**************Comision mostrada en tabla*****************/
$tipo_comision = $dato['tipo_comision'];
if(($tipo_comision == "venta"))
{
    $tipo_comisionshow = "público";
}else if($tipo_comision == "especial")
{
   $tipo_comisionshow = "especial";
}else if($tipo_comision == "mayoreo" )
{
    $tipo_comisionshow ="mayoreo";
}
//************************************************************/
//**************************Tipo porcentaje de acuerdo al tipo de venta************************
                                    
if(($tipo_comision == "venta"))
{
    $porcentaje_comision = $dato3['porcentaje'];
}else if($tipo_comision == "especial")
{
    $porcentaje_comision = $dato3['porcentajeespecial'];
}else if($tipo_comision == "mayoreo" )
{
    $porcentaje_comision = $dato3['porcentajemayoreo'];
}
//************************************************************************************************

$pro_comision = (($precioU-$costo_producto)*($porcentaje_comision/100)*$cantidad);
$pro_comision =number_format($pro_comision, 2, '.', '');
$total_comisiones = $total_comisiones+$pro_comision;
$total_comisiones = number_format($total_comisiones, 2, '.', '');

//************************************************************************************************	
$codigoHTML.= '<tr>';
$codigoHTML.= '<td>'.$contador.'</td>';
$codigoHTML.= '<td>'.$factura.'</td>';
$codigoHTML.= '<td>'.$id_producto.'</td>';
$codigoHTML.= '<td>'.$nombre.'</td>';
$codigoHTML.= '<td>'.$imei.'</td>';
$codigoHTML.= '<td>'.$nombrechip.'</td>';
$codigoHTML.= '<td>'.$iccid.'</td>';
$codigoHTML.= '<td>'.$cantidad.'</td>';
$codigoHTML.= '<td>$ '.number_format($valor, 2, ',', ' ').'</td>';
$codigoHTML.= '<td>$ '.number_format($importe, 2, ',', ' ').'</td>';

$codigoHTML.= '<td>'.$tipo_comisionshow.'</td>';
$codigoHTML.= '<td>$'.$pro_comision.'</td>';

$codigoHTML.= '<td>'.$tipov.'</td>';
$codigoHTML.= '<td>'.$fecha_op.'</td>';
$codigoHTML.= '<td>'.$usuario.'</td>';
$codigoHTML.= '<td>'.$nombreempresa.'</td>';


$codigoHTML.='</tr>';

  
}
$codigoHTML.='<tr>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td></td>';
$codigoHTML.= '<td>TOTAL</td>';
$codigoHTML.= '<td colspan="5">$'.$total_comisiones.'</td>';
$codigoHTML.='</tr>';
$codigoHTML.='</table>';
$codigoHTML.='</body>
</html>';


include("MPDF/mpdf.php");

$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0; 
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($codigoHTML);
$mpdf->Output('Mi Reporte Corte.pdf', 'D');
?>