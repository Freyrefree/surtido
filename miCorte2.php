<?php
		session_start();
		include('php_conexion.php'); 
        $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='su'){
			header('location:error.php');
        }     
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>miCorte</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="" /> -->
	<script src="cortes/jquery-1.9.1.js"></script>

	<style type="text/css">
	.fila_0 { background-color: #FFFFFF;}
	.fila_1 { background-color: #E1E8F1;}
	.botone{
	background-color: #FFBF00;
	border-radius: 40px;
	border: 0px;
	}
	.botone:hover{
	background-color: #F7D358;
	}
	</style>
</head>
<body>
<?php
$usuario = $_SESSION['username'];
$fecha_inicio = $_POST['fechainicio'];
if($fecha_inicio == "--")
{
$fecha_inicio = "";
}else{
$fecha_inicio = $fecha_inicio." 00:00:00";
}
$fecha_fin = $_POST['fechafin'];
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

$contador=0;
$codigo = '<table width="70%" border="1"  bordercolor="#AAAAAA"  FRAME="border" RULES="none" align="center">
  <tr>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Usuario</td>   
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad Articulos</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Venta Total</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Fecha Consulta Ventas</td>
  </tr>
  <tr>
    <td  align="center" style="font-size:16px">'.$usuario.'</td>   
    <td align="center" style="font-size:16px">'.$cantidad_art.'</td>
    <td align="center" style="font-size:16px" >$ '.number_format($importe1, 2, ',', ' ').'</td>
    <td align="center" style="font-size:16px" >'.$rango_fecha.'</td>
  </tr>
</table>';

$codigo.= '<div id="divId">';
$codigo.= '<table width="100%" border="1"  cellpadding="0" cellspacing="0"   FRAME="border" align="center">

<thead>
  <tr> 
  
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>No</SMALL></span></h3></th>
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Factura</SMALL></span></h3></th> 
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Codigo</SMALL></span></h3></th> 
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Nombre</SMALL></span></h3></th>

  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>IMEI</SMALL></span></h3></th>
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Nom Chip</SMALL></span></h3></th>
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>ICCID</SMALL></span></h3></th>
  
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Cantidad</SMALL></span></h3></th> 
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Valor</SMALL></span></h3></th> 
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Importe</SMALL></span></h3></th>
  
  
  <td style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Tipo Comision</SMALL></span></h3></td>
  
  <td style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Total Comision</SMALL></span></h3></td>      
  <td style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Tipo Venta</SMALL></span></h3></td> 

  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Fecha venta</SMALL></span></h3></th> 
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Usuario</SMALL></span></h3></th>
  <th style="color:#000; font-size:14px" bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Sucursal</SMALL></span></h3></th>                                                                                        
  </tr>
<thead>';

$codigo.='<tbody>';

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
	
$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$contador.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$factura.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:10px"><span ><SMALL>'.$id_producto.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:12px"><span ><SMALL>'.$nombre.'</SMALL></span></td>';

$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$imei.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$nombrechip.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$iccid.'</SMALL></span></td>';

$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$cantidad.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>$ '.number_format($valor, 2, ',', ' ').'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>$ '.number_format($importe, 2, ',', ' ').'</SMALL></span></td>';

$codigo.= '<td style="color:#000;  font-size:14px" ><span ><SMALL>'.$tipo_comisionshow.'</SMALL></span></td>';
$codigo.= '<td style="color:#000;  font-size:14px" ><span ><SMALL>$'.$pro_comision.'</SMALL></span></td>';


$codigo.= '<td style="color:#000; font-size:14px"><span ><SMALL>'.$tipov.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:12px"><span ><SMALL>'.$fecha_op.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:10px"><span ><SMALL>'.$usuario.'</SMALL></span></td>';
$codigo.= '<td style="color:#000; font-size:10px"><span ><SMALL>'.$nombreempresa.'</SMALL></span></td>';


$codigo.='<tr>';

  
}
$codigo.='<tr>
<td style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span ><SMALL></SMALL></span></td>
<td  style="color:#000;  font-size:10px"><span >TOTAL</span></td>
<td colspan="5" style="color:#000;  font-size:14px"><span >'.$total_comisiones.'</span></td>
</tr>';
$codigo.= '</tbody>';
$codigo.= '</table>';
$codigo.= '</div>';
echo $codigo;
?>	
</body>
</html>
