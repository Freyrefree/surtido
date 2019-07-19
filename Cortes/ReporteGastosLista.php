<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    $id_sucursal = $_SESSION['id_sucursal'];
?>


<?php

$fecha_fin3=$_POST['fecha_fin11'];
$fechaaumentada = date($fecha_fin3,strtotime("+1 day"));
$fecha_fin3=date("Y-m-d",strtotime($fecha_fin3)+86400);
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


<table class="table">
<thead>
  <tr>
    <th>Gastos</th>
    <th>Fechas</th>
    <th>Cantidad Sin Iva</th>
    <th>Cantidad Con Iva</th>
  </tr>
</thead><tbody>

  <tr>
    <td  align="center" style="font-size:16px"><?php echo $registros  ?></td>
    <td  align="center" style="font-size:16px"><?php echo $rango_fecha  ?></td>
    <td align="center" style="font-size:16px">$ <?php echo number_format($importe1, 2, ',', ' ') ?></td>
    <td align="center" style="font-size:16px" >$ <?php echo number_format($ImporteIva, 2, ',', ' ') ?></td>
  </tr>
  </tbody>
</table>

<p>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
 	<thead>
      <tr> 
        <th>ID</th>        
        <th>Concepto</th>        
        <th>Factura</th>         
        <th>fecha</th>         
        <th>Importe</th>           
        <th>Iva</th>           
        <th>Total + Iva</th>
        <th>Descripcion</th>
        <th>Documento</th>
      </tr>
  </thead><tbody>

<?php



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
  
<tr>
  <td><?php echo $dato['id_gasto']; ?></td>
  <td><?php echo $dato['concepto']; ?></td>
  <td><?php echo $dato['numero_fact']; ?></td>
  <td><?php echo $dato['fecha']; ?></td>
  <td>$<?php echo number_format($dato['total'], 2, ',', ' ') ?></td>
  <td>$<?php echo  number_format($dato['iva'], 2, ',', ' '); ?></td>
  <td>$<?php echo  number_format($total, 2, ',', ' '); ?></td>
  <td><?php echo $dato['descripcion']; ?></td>
  <td><?php echo $document; ?></td>
</tr>

<?php
$i ++;
 }
?>
</tbody>
</table>