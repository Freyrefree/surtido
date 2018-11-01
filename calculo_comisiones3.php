<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $usu = $_SESSION['username'];
        $datestart  = $_REQUEST['fecha_inicio'];
        $datefinish = $_REQUEST['fecha_fin'];
        $codigo = $_REQUEST['ccodigo'];
        $datefinish = strtotime ( '+1 day' , strtotime ( $datefinish ) ) ;
        $_SESSION['datefinish_recargas']=$datefinish = date ( 'Y-m-j' , $datefinish );

            //obtiene cantidad de ventas
            $query=mysql_query("SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal = '$id_sucursal'");
            if($dato=mysql_fetch_array($query)){
                $cantidad_ventas= $cantidad_ventas+$dato[0];
            }
            //obtiene cantidad de repparaciones
            $quer=mysql_query("SELECT COUNT(*) FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal = '$id_sucursal' AND estado = '3'");
            if($dator=mysql_fetch_array($quer)){
                $cantidad_ventas= $cantidad_ventas+$dator[0];
            }
            $query2=mysql_query("SELECT * FROM usuarios WHERE usu='$codigo' ");/*AND id_sucursal='$id_sucursal'*/
            while($dato=mysql_fetch_array($query2)){
                $cedula = $dato['ced'];
                $nombre = $dato['nom'];
                $usuario = $dato['usu'];
                $boton="Cancelar Venta";
            }
            $query2=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal='$id_sucursal'");
            while($dato=mysql_fetch_array($query2)){
                $total_ventas = $total_ventas+$dato['importe'];
            }
            $quer2=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal='$id_sucursal' AND estado = '3'");
            while($dat2=mysql_fetch_array($quer2)){
                $total_ventas = $total_ventas+$dat2['precio'];
            }
            /*echo '  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>PENDIENTE SUMAR RECARGAS </strong>
                </div>';*/
?>  
<style>
.table{
	background-color: white;
}
</style>

<table>
 <tr>
        <td>
            <label>Cedula: </label><input type="text" name="codigo" id="codigo" value="<?php echo $cedula; ?>" readonly>
		</td>
		<td>	
            <label>Nombre: </label><input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" readonly>
		</td>	
		<td>
            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" readonly>
		</td>
		<td>	
            <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
		</td>
		<td>	
            <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
		</td>	
		<td>
            <label>Cantidad / Ventas: </label><input type="text" name="cant" id="cant" value="<?php echo $cantidad_ventas; ?>" readonly>
		<td>
		<td>	
            <label>Total / Ventas</label>

                <input type="text" name="total_ventas" size="10" id="total_ventas" value="<?php echo "$"; echo number_format($total_ventas,2,".",","); ?>" readonly>

        </td>
</tr>  
	<tr>
		<td><?php echo "<a href='ReporteExcelIndividual.php?fi=$datestart&ff=$datefinish&usuario=$usuario' class='btn btn-primary'>Excel del cajero</a>" ?></td>
	</tr>	
</table>		

<br>

  <ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#comisiones"><label>Comisiones</label></a></li>
    <li><a data-toggle="tab" href="#ventas"><label>Ventas</label></a></li>
  </ul>

  <div class="tab-content">
    <div id="comisiones" class="tab-pane fade in active">

						<table width="100%" border="0" class="table">
						  <tr>
							<th width="5%"><label><strong>N.</strong></label></th>
							<th width="10%"><label><strong>ID</strong></label></td>
							<th width="20%"><label><strong>Nombre</strong></label></th>
							<th width="5%"><label><strong>Cant.</strong></label></th>
							<th width="10%"><label><strong>Tipo Venta.</strong></label></th>
							<th width="7%"><label><strong>% .</strong></label></th>
							<th width="14%"><label><strong>Precio U.</strong></label></th>
							<th width="10%"><label><strong>Coimision</strong></label></th>
						  </tr>
						  <?php
								$contador = 0;
								$query=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal='$id_sucursal'");
								while($dato=mysql_fetch_array($query)){
									$contador++;
									$pro_tipo = "TAE";
									$pro_codigo =$dato['codigo'];
									$pro_cant   =$dato['cantidad'];
									$pro_nombre =$dato['nombre'];
									$pro_precio =$dato['valor'];
									$query2=mysql_query("SELECT * FROM producto WHERE cod = '$pro_codigo' AND id_sucursal='$id_sucursal'");
									while($dato2=mysql_fetch_array($query2)){
										$id_comision = $dato2['id_comision'];
										$pro_costo = $dato2['costo'];
										$query3=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
										while($dato3=mysql_fetch_array($query3)){
											$pro_tipo = $dato3['tipo'];
											$pro_porcentaje = $dato3['porcentaje'];
										}
									}
									if ($pro_tipo != "TAE") {
											$pro_comision = ($pro_precio-$pro_costo)*($pro_porcentaje/100);
											$total_comisiones1 = $total_comisiones1+$pro_comision;
										}else {

											$query11=mysql_query("SELECT * FROM compania_tl WHERE codigo = '$pro_codigo'");
											while($dato11=mysql_fetch_array($query11)){
											
													$IdComisionTL = $dato11['id_comision'];
													$query3=mysql_query("SELECT * FROM comision WHERE id_comision = '$IdComisionTL'");
													while($dato3=mysql_fetch_array($query3)){
														$pro_tipo = $dato3['tipo'];
														$pro_porcentaje = $dato3['porcentaje'];
													}

											}

											 $pro_comision = ($pro_precio)*($pro_porcentaje/100);
											 $total_comisiones2 = $total_comisiones2+$pro_comision;
										}
							?>
						  <tr>
							<td><label><?php echo $contador; ?></label></td>
							<td><label><?php echo $pro_codigo; ?></label></td>
							<td><label><?php echo $pro_nombre; ?></label></td>
							<td><label><center><?php echo $pro_cant; ?></label></td>
							<td><label><center><?php echo $pro_tipo; ?></label></td>
							<td><label><center><?php echo $pro_porcentaje." %"; ?></label></td>
							<td><label><?php echo "$ ".number_format($pro_precio,2,",","."); ?></label></td>
							<td style="text-align:right"><label><?php echo "$ ".number_format($pro_comision,2,",","."); ?></label></td>
						  </tr>
						  <?php  } 
								$queryr=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal='$id_sucursal' AND estado = '3'");
								//echo "SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal='$id_sucursal' AND estado = '3'";
							while($dato=mysql_fetch_array($queryr)){
								$contador++;
								$rep_codigo =$dato['id_reparacion'];
								$rep_cant   =1;
								$rep_nombre =$dato['motivo'];
								$rep_precio =$dato['precio'];
								$rep_costo  =$dato['costo'];
								$id_comision=$dato['id_comision'];
								$queryr1=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
								while($dator=mysql_fetch_array($queryr1)){
									$rep_tipo = $dator['tipo'];
									$rep_porcentaje = $dator['porcentaje'];
								}
								$rep_comision = ($rep_precio - $rep_costo)*($rep_porcentaje/100);
								$total_comisiones3 = $total_comisiones3+$rep_comision;
							
						  ?>
						  <tr>
							<td><label><?php echo $contador; ?></label></td>
							<td><label><?php echo $rep_codigo; ?></label></td>
							<td><label><?php echo $rep_nombre; ?></label></td>
							<td><label><?php echo $rep_cant; ?></label></td>
							<td><label><?php echo $rep_tipo; ?></label></td>
							<td><label><?php echo $rep_porcentaje." %"; ?></label></td>
							<td><label><?php echo "$ ".number_format($rep_precio,2,",","."); ?></label></td>
							<td style="text-align:right"><label><?php echo "$ ".number_format($rep_comision,2,",","."); ?></label></td>
						  </tr>
						  <?php 
						  
						  }

						  $total_comisiones = $total_comisiones1 + $total_comisiones2 + $total_comisiones3; 
						  
						  ?>
						  <tr>
							  <td  colspan="8" style="text-align:right" ><label>Total Comisiones: <?= "$ ".number_format($total_comisiones,2,",","."); ?></label></td>
						  </tr>
						</table>
</div>				

    <div id="ventas" class="tab-pane fade in">

						<table width="80%" border="0" class="table">
						  <tr>
							<td width="3%"><label><strong>ID</strong></label></td>
							<td width="10%"><label><strong>Tipo de Venta</strong></label></td>
							<td width="8%"><label><strong>Cantidad</strong></label></td>
							<td width="8%" style="text-align:right"><strong>Total</strong></label></td>
						  </tr>
						  <?php
							$query=mysql_query("SELECT * FROM comision");
							while($dato=mysql_fetch_array($query)){
								$id_comision = $dato['id_comision'];
								$nombre_comision = $dato['nombre'];
								$query2=mysql_query(
									"SELECT SUM(detalle.cantidad) AS cantidad
									 FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' 
													AND id_sucursal = '$id_sucursal' 
													AND usu = '$usuario' 
													AND (codigo IN (SELECT cod FROM producto WHERE id_comision='$id_comision') OR codigo IN (SELECT codigo FROM compania_tl WHERE id_comision='$id_comision'))");
								while($dato2=mysql_fetch_array($query2)){
									$cantidad_ventas_tipo = $dato2['cantidad'];
								}
								$query3=mysql_query(
									"SELECT SUM(detalle.importe) AS total
									 FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' 
													AND id_sucursal = '$id_sucursal' 
													AND usu = '$usuario' 
													AND (codigo IN (SELECT cod FROM producto WHERE id_comision='$id_comision') OR codigo IN (SELECT codigo FROM compania_tl WHERE id_comision='$id_comision'))");
								while($dato3=mysql_fetch_array($query3)){
									$total_importe = $dato3['total'];
								}
								/*echo "SELECT COUNT(id_reparacion) AS cantidad, SUM(precio) AS total
									 FROM reparacion 
									 WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '2' AND id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND usuario = '$usuario'";*/
								$queryc=mysql_query("SELECT * FROM reparacion WHERE id_comision = '$id_comision'");
								if($dat=mysql_fetch_array($queryc)){
									$query4=mysql_query(
									"SELECT COUNT(id_reparacion) AS cantidad, SUM(precio) AS total
									 FROM reparacion 
									 WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3' AND id_sucursal = '$id_sucursal' AND id_comision = '$id_comision' AND usuario = '$usuario'");
									while($dato4=mysql_fetch_array($query4)){
										$total_importe = $dato4['total'];
										$cantidad_ventas_tipo = $dato4['cantidad'];
									}
								}
								$importe_total = $importe_total+$total_importe;
						  ?>
						  <tr>
							<td><label><?php echo $id_comision; ?></label></td>
							<td><label><?php echo $nombre_comision; ?></label></td>
							<td><label><?php echo $cantidad_ventas_tipo; ?></label></td>
							<td style="text-align:right"><label><?php echo "$ ".number_format($total_importe,2,",","."); ?></label></td>
						  </tr>
						  <?php } ?>
						  <tr>
							  <td  colspan="7" style="text-align:right" ><label>Total Ventas: <?= "$ ".number_format($importe_total,2,",","."); ?></label></td>
						  </tr>
						</table>

	  </div>
</div>						

<script type='text/javascript'>
$(function (e) {
	$('#form1').submit(function (e) {
	  e.preventDefault()
  $('#ajax').load('calculo_comisiones2.php?' + $('#form1').serialize())
	})
})
</script>           