<?php
 		session_start();
		include('php_conexion.php'); 
    $id_sucursal = $_SESSION['id_sucursal'];
    $Sucursal = $_SESSION['sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Principal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>
    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>



    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
<style>
  .sucursal{
      color: black;
      font-size: 16px;
      text-align: center;
    }
</style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<center>
<p class="sucursal"> <?= $Sucursal ?></p>
</center><br><br>
<div align="right">
	<a href="PDFestado_inventario.php" class="btn"><i class="icon-print"></i> Reporte PDF</a> 
    <!-- Button to trigger modal -->
<table width="80%" border="0" class="table table-hover">
<thead>
  <tr>
    <td colspan="6"><strong><center>Productos de Baja Existencia</center></strong></td>
    </tr>
  <tr>
    <td width="15%"><strong>Codigo</strong></td>
    <td width="26%"><strong>Descripcion del Producto</strong></td>
    <td width="13%"><div align="right"><strong>Costo</strong></div></td>
    <td width="16%"><div align="right"><strong>Mayoreo</strong></div></td>
    <td width="16%"><div align="right"><strong>Valor Venta</strong></div></td>
    <td width="14%"><strong><center>Existencia</center></strong></td>
    <td width="7%"><strong>Estado</strong></td>
  </tr>
</thead>
<tbody>
<?php 
	$mensaje='no';
    $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND estado = 's' ORDER BY nom ASC");
    while($dato=mysql_fetch_array($can)){
    if($dato['estado']=="n"){
        $estado='<span class="label label-important">Inactivo</span>';
    }else{
        $estado='<span class="label label-success">Activo</span>';
    }
		$cant=$dato['cantidad'];
		$minima=$dato['minimo'];
		if($cant<=$minima){
			$mensaje='si';
?>

  <tr>
    <td><?php echo $dato['cod']; ?></td>
    <td><a href="crear_producto.php?codigo=<?php echo $dato['cod']; ?>"><?php echo $dato['nom']; ?> </a>
	<?php if($dato['clase']=='tmp'){echo '<span class="label label-info">TMP</span>';} ?></td>
    <td><div align="right">$ <?php echo number_format($dato['costo'],2,",","."); ?></div></td>
    <td><div align="right">$ <?php echo number_format($dato['mayor'],2,",","."); ?></div></td>
    <td><div align="right">$ <?php echo number_format($dato['venta'],2,",","."); ?></div></td>
    <td><center><span class="badge badge-important"><?php echo $cant; ?></span></center></td>
    <td><a href="php_estado_producto.php?id=<?php echo $dato['cod']; ?>"><?php echo $estado; ?></a></td>
  </tr>
<?php }} ?>
  </tbody>
</table>
<?php	if($mensaje=='no'){	echo '<div class="alert alert-success" align="center"><strong>No existen articulos bajos de stock!</strong></div>'; } ?><br><br>
<table width="80%" border="0" class="table table-hover">
<thead>
  <tr>
    <td colspan="7"><strong><center>Listado y Totales de Productos</center></strong></td>
    </tr>
  <tr>
    <td width="15%"><strong>Codigo</strong></td>
    <td width="26%"><strong>Descripcion del Producto</strong></td>
    <td width="13%"><div align="right"><strong>Costo</strong></div></td>
    <td width="16%"><div align="right"><strong>Venta a por Mayor</strong></div></td>
    <td width="16%"><div align="right"><strong>Valor Venta</strong></div></td>
    <td width="14%"><strong><center>Existencia</center></strong></td>
  </tr>
</thead>
<tbody>
<?php 
	$mensaje2='no';$costo=0;$mayor=0;$venta=0;$art=0;
    $can=mysql_query("SELECT * FROM producto WHERE id_sucursal = '$id_sucursal' AND estado = 's' ORDER BY nom ASC");
    while($dato=mysql_fetch_array($can)){
    if($dato['estado']=="n"){
          $estado='<span class="label label-important">Inactivo</span>';
      }else{
          $estado='<span class="label label-success">Activo</span>';
      }
		$cant=$dato['cantidad'];
		$minima=$dato['minimo'];
		$mensaje2='si';
		$art=$art+$cant;
		$costo=$costo+($dato['costo']*$dato['cantidad']);
		$mayor=$mayor+($dato['mayor']*$dato['cantidad']);
		$venta=$mayor+($dato['venta']*$dato['cantidad']);
		if($cant<=$minima){
			$cantidad='<span class="badge badge-important">'.$cant.'</span>';
		}else{
			$cantidad='<span class="badge badge-success">'.$cant.'</span>';
		}
?>

  <tr>
    <td><?php echo $dato['cod']; ?></td>
    <td><a href="crear_producto.php?codigo=<?php echo $dato['cod']; ?>"><?php echo $dato['nom']; ?></a></td>
    <td><div align="right">$ <?php echo number_format($dato['costo'],2,",","."); ?></div></td>
    <td><div align="right">$ <?php echo number_format($dato['mayor'],2,",","."); ?></div></td>
    <td><div align="right">$ <?php echo number_format($dato['venta'],2,",","."); ?></div></td>
    <td><center><?php echo $cantidad; ?></center></td>
    <td><a href="php_estado_producto.php?id=<?php echo $dato['cod']; ?>"><?php echo $estado; ?></a></td>
  </tr>
  <?php } 
  	if($mensaje2=='2'){
  ?>
   <tr>
    <td colspan="6">
    		<div class="alert alert-error">
              <strong>No hay Articulos registrados actualmente</strong>
            </div></td>
    </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right"><strong>Totales:</strong></div></td>
    <td><div align="right"><strong>$ <?php echo number_format($costo,2,",","."); ?></strong></div></td>
    <td><div align="right"><strong>$ <?php echo number_format($mayor,2,",","."); ?></strong></div></td>
    <td><div align="right"><strong>$ <?php echo number_format($venta,2,",","."); ?></strong></div></td>
    <td><CENTER><span class="badge badge-warning"><?php echo $art; ?></span></CENTER></td>
  </tr>

  </tbody>
</table>
</body>
</html>