<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    $id_sucursal = $_SESSION['id_sucursal'];
?>
<?php header( 'Content-type: text/html; charset=iso-8859-1' );?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

</script>

<style type="text/css">
.fila_0 { background-color: #FFFFFF;}
.fila_1 { background-color: #E1E8F1;}
</style>
</head>
<body>

<?php

$fecha_fin3=$_POST['fecha_fin11'];

$fechaaumentada = date($fecha_fin3,strtotime("+1 day"));
//echo $fechaaumentada;
$fecha_fin3=date("Y-m-d",strtotime($fecha_fin3)+86400);
//echo $siguiente;
$fecha_ini3=$_POST['fecha_ini11'];
$can=mysql_query("SELECT * from gastos where fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND id_sucursal = '$id_sucursal'");
$registros=mysql_num_rows($can);

$can1=mysql_query("SELECT SUM(total)from gastos where fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND id_sucursal = '$id_sucursal'");
$row1=mysql_fetch_array($can1);
$importe1= $row1[0];

$can1=mysql_query("SELECT SUM(iva)from gastos where fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND id_sucursal = '$id_sucursal'");
$row1=mysql_fetch_array($can1);
$cant_iva= $row1[0];

$ImporteIva = $importe1+$cant_iva;
$rango_fecha = $fecha_ini3 ." / " .$fecha_fin3;
?>
<table width="70%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel2" FRAME="border" RULES="none" align="center">
  <tr>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Gastos</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Fechas</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad Sin Iva</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad Con Iva</td>
  </tr>
  <tr>
    <td  align="center" style="font-size:16px"><?php echo $registros  ?></td>
    <td  align="center" style="font-size:16px"><?php echo $rango_fecha  ?></td>
    <td align="center" style="font-size:16px">$ <?php echo number_format($importe1, 2, ',', ' ') ?></td>
    <td align="center" style="font-size:16px" >$ <?php echo number_format($ImporteIva, 2, ',', ' ') ?></td>
  </tr>
</table>
<p>
<table width="100%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel" FRAME="border" RULES="none" align="center">
 	<thead>
      <tr> 
        <td style="color:#000; font-size:14px" align="center" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>ID</SMALL></span></h3></td> 
        
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Concepto</SMALL></span></h3></td> 
        
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Factura</SMALL></span></h3></td> 
         
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>fecha</SMALL></span></h3></td> 
          
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Importe</SMALL></span></h3></td> 
          
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Iva</SMALL></span></h3></td> 
          
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Total + Iva</SMALL></span></h3></td>

        <td style="color:#000; font-size:14px" width="70"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Descripcion</SMALL></span></h3></td>

        <td style="color:#000; font-size:14px" width="50"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Documento</SMALL></span></h3></td>
      </tr>
  </thead>

<?php

//$fecha_fin=$_POST['fecha_fin11'];
//$fecha_ini=$_POST['fecha_ini11'];

$i = 1;
$can=mysql_query( "SELECT  * from gastos where fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND id_sucursal = '$id_sucursal' ORDER BY fecha DESC");

while($dato=mysql_fetch_array($can)){
$total = $dato['total']+$dato['iva'];
if (!empty($dato['documento'])) {
  $direccion = $dato['documento'];
  $id = $dato['id_gasto'];
  $document = "<a href='descarga.php?archivo=$direccion&id=$id'>Descargar</a>";
}else {
  $document = "";
}
?>
  <tfoot>
<tr>
  <td style="color:#000; font-size:14px" align="center" class="fila_<?php echo $i%2; ?>"><span ><SMALL> <?php echo $dato['id_gasto']; ?></SMALL></span></td>

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['concepto']; ?></SMALL></span></td>
  
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['numero_fact']; ?></SMALL></span></td>
  
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['fecha']; ?></SMALL></span></td>

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo number_format($dato['total'], 2, ',', ' ') ?></SMALL></span></td>
 
  <td  style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo  number_format($dato['iva'], 2, ',', ' '); ?></SMALL></span></td>
  
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo  number_format($total, 2, ',', ' '); ?></SMALL></span></td>
   
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['descripcion']; ?></SMALL></span></td>

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $document; ?></SMALL></span></td>
<?php
$i ++;
 }
?>  
<a href=""></a>
</table>
<p>&nbsp;</p>

</body>
</html>

