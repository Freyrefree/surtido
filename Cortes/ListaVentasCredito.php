<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
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
$can=mysql_query("SELECT * from credito where fecha_venta BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
$registros=mysql_num_rows($can);

$can1=mysql_query("SELECT SUM(total)from credito where fecha_venta BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
$row1=mysql_fetch_array($can1);
$importe1= $row1[0];

$can1=mysql_query("SELECT SUM(adelanto)from credito where fecha_venta BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
$row1=mysql_fetch_array($can1);
$adelanto= $row1[0];

$can1=mysql_query("SELECT SUM(resto)from credito where fecha_venta BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
$row1=mysql_fetch_array($can1);
$resto= $row1[0];

$rango_fecha = $fecha_ini3 ." / " .$fecha_fin3;
?>
<table width="70%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel2" FRAME="border" RULES="none" align="center">
  <tr>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">No. Ventas</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Abonos</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Restantes</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Fecha Venta</td>
  </tr>
  <tr>
    <td  align="center" style="font-size:16px"><?php echo $registros  ?></td>
    <td align="center" style="font-size:16px">$ <?php echo number_format($importe1, 2, ',', ' ') ?></td>
    <td align="center" style="font-size:16px" >$ <?php echo number_format($adelanto, 2, ',', ' ') ?></td>
    <td align="center" style="font-size:16px" >$ <?php echo number_format($resto, 2, ',', ' ') ?></td>
    <td  align="center" style="font-size:16px"><?php echo $rango_fecha  ?></td>
  </tr>
</table>
<p>
<table width="100%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel" FRAME="border" RULES="none" align="center">
 	<thead>
      <tr> 
        <td style="color:#000;  font-size:14px" width="40"bgcolor="#CEE3F6" align="center" height="27"><h3><span ><SMALL>Id</SMALL></span></h3></td> 
        
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Factura</SMALL></span></h3></td> 
        
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>RFC Cliente</SMALL></span></h3></td> 
         
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Importe</SMALL></span></h3></td> 
          
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Adelanto</SMALL></span></h3></td> 
          
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Restante</SMALL></span></h3></td> 
          
        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Fecha venta</SMALL></span></h3></td>

        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Fecha Limite</SMALL></span></h3></td>

        <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Estatus</SMALL></span></h3></td>
      </tr>
  </thead>

<?php

//$fecha_fin=$_POST['fecha_fin11'];
//$fecha_ini=$_POST['fecha_ini11'];

$i = 1;
$can=mysql_query( "SELECT  * from credito where fecha_venta BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' ORDER BY fecha_venta DESC");

while($dato=mysql_fetch_array($can)){
if ($dato['estatus'] == 1) {
      $estatus = "Pagado";
    }else {
      $estatus = "Pendiente";
    }
?>
  <tfoot>
<tr>
  <td style="color:#000; font-size:14px" align="center" class="fila_<?php echo $i%2; ?>"><span ><SMALL> <?php echo $dato['id']; ?></SMALL></span></td>

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['id_factura']; ?></SMALL></span></td>
  
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['rfc_cliente']; ?></SMALL></span></td>
  

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo number_format($dato['total'], 2, ',', ' ') ?></SMALL></span></td>
 
  <td  style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo  number_format($dato['adelanto'], 2, ',', ' '); ?></SMALL></span></td>

  <td  style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo  number_format($dato['resto'], 2, ',', ' '); ?></SMALL></span></td>
  
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['fecha_venta']; ?></SMALL></span></td>
   
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $dato['fecha_pago']; ?></SMALL></span></td>

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL><?php echo $estatus; ?></SMALL></span></td>
<?php
$i ++;
 }
?>  

</table>
<p>&nbsp;</p>

</body>
</html>

