<?php
		session_start();
		include('../php_conexion.php'); 
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>



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


?>


<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
<thead>
<tr> 
  <th>Usuario</th> 
  <th>Apertura</th> 
  <th>Ventas</th> 
  <th>Corte de Caja</th> 
  <th>En tienda</th>
  <th>Hora de Inicio</th> 
  <th>Hora de Cierre</th> 
  <th>Fecha</th> 
  <th>Responsable</th>                                                                                 
</tr>
</thead>
<tbody>
<?php


  if ($cajero != 'Todos') {
    $can=mysql_query("SELECT * FROM detalle_caja  WHERE  autoriza ='$cajero' AND (fecha BETWEEN '$fecha_ini3' AND '$fecha_fin3')") or die (print("Error"));
  }

  if ($cajero == 'Todos') {
    $can=mysql_query("SELECT * FROM detalle_caja WHERE fecha BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'");
  }


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
    
  <tr>
    <td><?php echo $usuario; ?></td>
    <td>$<?php echo number_format($dato['apertura'], 2, ',', ' '); ?></td>
    <td>$<?php echo number_format($dato['ventas'], 2, ',', ' '); ?></td>
    <td>$<?php echo number_format($dato['cierre'], 2, ',', ' '); ?></td>
    <td>$<?php echo number_format($cantidadcaja, 2, ',', ' '); ?></td>
    <td><?php echo $dato['horainicio']; ?></td>
    <td><?php echo $dato['horacierre']; ?></td>
    <td><?php echo $dato['fecha']; ?></td>
    <td><?php echo $dato['autoriza']; ?></td>
  </tr>
        
  <?php
 }

?>
</tbody>
</table>


