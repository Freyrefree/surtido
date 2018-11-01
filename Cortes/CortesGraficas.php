<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		include("../MPDF/mpdf.php");
    	$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Datepicker - Select a Date Range</title>
	<link rel="stylesheet" href="themes/base/jquery.ui.all.css">


 
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>    
	<script src="jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.datepicker.js"></script>
    <script src="ui/jquery.ui.button.js"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
    
	<link rel="stylesheet" href="demos/demos.css">
	<style type="text/css">
	body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, Verdana, sans-serif;
}
body {
	background-color: #FFF;
}
    </style>
     
	<script>
	$(function() {
		$( "input[type=submit], a, button" )
			.button()
			.click(function( event ) {
				event.preventDefault();
			});
	});
	
	
	function consultacortes(){
		var year         = document.getElementById("year").value;
		var cajero       = document.getElementById("seccion").value;
		var producto     = document.getElementById("product").value;
		var categoria    = document.getElementById("categoria").value;
		var empresa 	   = document.getElementById("empresa").value;
		$.post("ConsultasGraficas.php", 
				{cajero: cajero,
				 year: year,
				 producto: producto,
				 empresa: empresa,
				 categoria: categoria},
				function(data){		
					$("#recargado").html(data);
		});			
}
	</script>
    
 
</head>
<body><table width="100%" border="0" align="center" class="ui-widget-content ui-widget-header">
  <tr>
    <td align="center" style="font-size:14px">Cosulta Corte de Ventas</td>
  </tr>
</table>
<p>
<table width="90%" border="0"  align="center">
  <tr>
  	<td width="60%" height="19" align="center" class="ui-widget-content ui-corner-all"> <img src="../img/calendar_view_month.png" width="32" height="32"> Selecciona Fecha</td>
    <td width="37%" align="center" class="ui-widget-content ui-corner-all"><img src="../img/user_orange.png" width="32" height="32"> Selecciona Cajero</td>
		<td width="37%" align="center" class="ui-widget-content ui-corner-all"><img src="../img/shop.png" width="32" height="32"> Selecciona Sucursal</td>
		<td width="20%" align="center" class="ui-widget-content ui-corner-all"><img src="../img/product.png" width="32" height="32">Producto específico</td>
    <td width="20%" align="center" class="ui-widget-content ui-corner-all"><img src="../img/product.png" width="32" height="32"><br>Tipo Producto</td>
	<td width="20%" align="center" class="ui-widget-content ui-corner-all"><img src="../img/search.png" width="32" height="32"><br>Consultar</td>
  </tr>
  
  <tr>
      <td width="37%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
            <select name="year" id="year">
            <?php 
				$can=mysql_query("SELECT DISTINCT YEAR(fecha_op) FROM detalle");
				while($dato=mysql_fetch_array($can)){
			?>
              <option value="<?php echo $dato['YEAR(fecha_op)']; ?>" <?php if($seccion==$dato['usu']){ echo 'selected'; } ?>><?php echo $dato['YEAR(fecha_op)']; ?></option>
            <?php } ?>
            <option value="" selected>Seleccionar Año</option>
            </select>
    </td>
    <td width="37%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
            <select name="seccion" id="seccion">
            <?php 
				$can=mysql_query("SELECT * FROM usuarios WHERE tipo='a' or tipo='ca' ");
				while($dato=mysql_fetch_array($can)){
					
			?>
              <option value="<?php echo $dato['usu']; ?>" <?php if($seccion==$dato['usu']){ echo 'selected'; } ?>><?php echo $dato['usu']; ?></option>
            <?php } ?>
            <option value="Todos" selected>Todos </option>
            </select>
    </td>
		<td width="37%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
            <select name="empresa" id="empresa">
            <?php 
				$can=mysql_query("SELECT * FROM empresa");
				while($dato=mysql_fetch_array($can)){
					
			?>
              <option value="<?php echo $dato['id']; ?>" <?php if($seccion==$dato['empresa']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
            <?php } ?>
            <option value="Todos" selected>Todos </option>
            </select>
    </td>
    <td width="20%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
            <select name="product" id="product">
            <?php 
    				$can=mysql_query("SELECT DISTINCT codigo, nombre FROM detalle WHERE codigo IN(SELECT cod FROM producto) OR codigo IN(SELECT codigo FROM compania_tl) OR codigo IN(SELECT NombreServicio FROM servicio)");
    				while($dato=mysql_fetch_array($can)){
    			?>
              <option value="<?php echo $dato['codigo']; ?>" <?php if($product==$dato['nom']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            <option value="Todos" selected>Todos </option>
            </select>
    </td>
	<td width="20%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
            <select name="categoria" id="categoria">
			<option value="" selected>Seleccione una Categoría</option>
            <?php 
    				$can=mysql_query("SELECT id_comision, nombre FROM comision WHERE tipo!='RECARGA'");
    				while($dato=mysql_fetch_array($can)){
    		?>
              <option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>
            <?php } ?>
			<option value="RECARGA">RECARGAS</option>
            </select>
    </td>
	<td rowspan="2" width="37%" align="center" class="ui-widget-content ui-corner-all"><a href="#" onClick="consultacortes();" ><img src="../img/report.png" width="32" height="32">Consultar</a></td>	
  </tr>
  <tr>
  	<p id="resultado"></p>
  </tr>
</table>
<center><table width="85%" border="0" align="ceneter">
  <tr>
    <td><p><div id="recargado"></div></p></td>
  </tr>
</table></center>



</body>
</html>
