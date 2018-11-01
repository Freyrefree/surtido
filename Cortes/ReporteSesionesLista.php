<?php
		session_start();
		include('../php_conexion.php'); 
    $id_sucursal = $_SESSION['id_sucursal'];
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
//echo "fecha final: ".$fecha_fin3;
//echo $siguiente;
$fecha_ini3=$_POST['fecha_ini11'];
//echo "fecha inicio: ".$fecha_ini3;
$cajero=$_POST['cajero'];
#buscar por usuario en especifico
/*if ($cajero =='Todos'){
$can=mysql_query("SELECT SUM(cantidad)from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
$row=mysql_fetch_array($can);
$cantidad_art= $row[0];

$can1=mysql_query("SELECT SUM(importe) from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
$row1=mysql_fetch_array($can1);
$importe1= $row1[0];

$tipo_user ='Todos'; $tipo_producto = 'Todos';
$rango_fecha = $fecha_ini3 ." / " .$fecha_fin3;
}*/
#fin buscar por usuario en especifico

#buscar por todos los usuarios
/*if ($cajero != 'Todos') {
  $tipo_user =$cajero; $tipo_producto=$producto;
  
  $can=mysql_query("SELECT SUM(cantidad)from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' and nombre='".$producto."'");
  $row=mysql_fetch_array($can);
  $cantidad_art= $row[0];

  $can1=mysql_query("SELECT SUM(importe)from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' and nombre='".$producto."'");
  $row1=mysql_fetch_array($can1);
  $importe1= $row1[0];
  
  $rango_fecha = $fecha_ini3 ." / " .$fecha_fin3;
}*/
#fin buscar por todos los usuarios
 //muestra el total de la suma

?>
<!-- <table width="70%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel2" FRAME="border" RULES="none" align="center">
  <tr>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Usuario</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Total Ventas</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad Articulos</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Venta Total</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Fecha Venta</td>
  </tr>
  <tr>
    <td  align="center" style="font-size:16px"><?php echo $tipo_user  ?></td>
    <td  align="center" style="font-size:16px"><?php echo $tipo_producto  ?></td>
    <td align="center" style="font-size:16px"><?php echo $cantidad_art ?></td>
    <td align="center" style="font-size:16px" >$ <?php echo number_format($importe1, 2, ',', ' ') ?></td>
    <td align="center" style="font-size:16px" ><?php echo $rango_fecha ?></td>
  </tr>
</table> -->
<p>
<table width="90%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel" FRAME="border" RULES="none" align="center">
 	          <thead>
              <tr> 
            <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Usuario</SMALL></span></h3></td> 
            
            <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Apertura</SMALL></span></h3></td> 
            
             <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Ventas</SMALL></span></h3></td> 

              <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Corte de Caja</SMALL></span></h3></td> 

             <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>En tienda</SMALL></span></h3></td>
              
              <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Hora de Inicio</SMALL></span></h3></td> 
              
              <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Hora de Cierre</SMALL></span></h3></td> 
              
              <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Fecha</SMALL></span></h3></td> 
              
              <td style="color:#000; font-size:14px" width="60"bgcolor="#CEE3F6" height="27"><h3><span ><SMALL>Responsable</SMALL></span></h3></td> 
                                                                                                
            </tr>
  <thead>
<?php

//$fecha_fin=$_POST['fecha_fin11'];
//$fecha_ini=$_POST['fecha_ini11'];
$i = 1;

if ($cajero != 'Todos') {
  /*$can=mysql_query("SELECT * FROM detalle_caja WHERE fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."' AND id_cajero='$cajero'");*/
  $can=mysql_query("SELECT * FROM detalle_caja  WHERE  autoriza ='$cajero' AND (fecha BETWEEN '$fecha_ini3' AND '$fecha_fin3')") or die (print("Error"));
  
}

if ($cajero == 'Todos') {
  $can=mysql_query("SELECT * FROM detalle_caja WHERE fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
}



//$sql ="SELECT  LTRIM(factura) AS factura,codigo from detalle where fecha_op BETWEEN '2015-01-01' AND '2015-01-06'";
//$can=mysql_query("SELECT  LTRIM(factura) AS factura,codigo from detalle where fecha_op BETWEEN '2015-01-01' AND '2015-01-06'");

while($dato=mysql_fetch_array($can)){
$ced = $dato['id_cajero'];
$query=mysql_query("SELECT * FROM usuarios WHERE ced = '$ced'");
if($row=mysql_fetch_array($query)){
  $usuario = $row['usu'];
}
$querys=mysql_query("SELECT * FROM caja WHERE id_cajero = '$ced'");
if($rows=mysql_fetch_array($querys)){
  $cantidadcaja = $rows['apertura'];
}
?>
  <tfoot>
<tr>

  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>  <?php echo $usuario; ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo number_format($dato['apertura'], 2, ',', ' '); ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo number_format($dato['ventas'], 2, ',', ' '); ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo number_format($dato['cierre'], 2, ',', ' '); ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>$ <?php echo number_format($cantidadcaja, 2, ',', ' '); ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>  <?php echo $dato['horainicio']; ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>  <?php echo $dato['horacierre']; ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>  <?php echo $dato['fecha']; ?></SMALL></span></td>
  <td style="color:#000;  font-size:14px" class="fila_<?php echo $i%2; ?>"><span ><SMALL>  <?php echo $dato['autoriza']; ?></SMALL></span></td>
       
<?php
$i ++;
 }
?>


</table>
<p>&nbsp;</p>
</body>
</html>

