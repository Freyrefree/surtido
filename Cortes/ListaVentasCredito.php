<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>


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
<table class="table">
  <tr>
  <thead>
    <th>No. Ventas</th>
    <th>Cantidad</th>
    <th>Abonos</th>
    <th>Restantes</th>
    <th>Fecha Venta</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><?php echo $registros  ?></td>
    <td>$ <?php echo number_format($importe1, 2, ',', ' ') ?></td>
    <td>$ <?php echo number_format($adelanto, 2, ',', ' ') ?></td>
    <td>$ <?php echo number_format($resto, 2, ',', ' ') ?></td>
    <td><?php echo $rango_fecha  ?></td>
  </tr>
  </tbody>
</table>


<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
 	<thead>
      <tr> 
        <td>Id</td> 
        
        <td>Factura</td> 
        
        <td>RFC Cliente</td> 
         
        <td>Importe</td> 
          
        <td>Adelanto</td> 
          
        <td>Restante</td> 
          
        <td>Fecha venta</td>

        <td>Fecha Limite</td>

        <td>Estatus</td>
      </tr>
  </thead><tbody>

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
  
<tr>
  <td> <?php echo $dato['id']; ?></td>
  <td><?php echo $dato['id_factura']; ?></td>
  <td><?php echo $dato['rfc_cliente']; ?></td>
  <td>$ <?php echo number_format($dato['total'], 2, ',', ' ') ?></td>
  <td>$ <?php echo  number_format($dato['adelanto'], 2, ',', ' '); ?></td>
  <td>$ <?php echo  number_format($dato['resto'], 2, ',', ' '); ?></td>
  <td><?php echo $dato['fecha_venta']; ?></td>
  <td><?php echo $dato['fecha_pago']; ?></td>
  <td><?php echo $estatus; ?></td>
  
  </tr>
<?php
$i ++;
 }
?>  
</tbody>
</table>


