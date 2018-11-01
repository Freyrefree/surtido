<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$id_sucursal = $_SESSION['id_sucursal'];
?>
<!-- Inician los estilos -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Listado Producto</title>
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
    <script src="includes/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="includes/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
</head>
<!-- Terminan los estilos -->
 
<?php
  		// consulta el saldo virtual de la sucursal  
          $sqle = mysql_query("SELECT * FROM recargassucursal WHERE IdSucursal='$id_sucursal'") or die(print"Error en consulta de saldo virtual".mysql_error());
          if($dat=mysql_fetch_array($sqle)){
                  $SaldoVirtual=$dat['Saldo'];
            }
          // fin de consulta el saldo virtual de la sucursal    
?>
 
<body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div id="ajax">
    <div align="center">
            <h3>Saldo disponible: <?php echo $SaldoVirtual ?></h3>
          <br>
          <form class="form-horizontal" action="CobrarRecargaMayoreo.php" method="POST" name="RecargaMayoreo" id="RecargaMayoreo" target="_self"> 
                <label for="monto">Compañia</label> 
                <select name="compania" id="compania" autofocus required>
					<option value="Telcel">Telcel</option>
                    <option value="Multirecargas">Multirecargas</option>
				</select>	
				
					<!--
					<select name="monto" id="monto" required>
					</select>
					-->
					<label for="monto">Monto</label>
					<input type="text" id="monto" name="monto" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="10" required autocomplete="off" required>
					<br>
                 <div class="ui-widget">
					<label for="ccpago">Cliente</label>
					<?php echo "<input type='hidden' step='any' name='IdCajero' id='IdCajero' autocomplete='off' value='$ced'>"; ?>
					<input type="text" class="client" id="client" name="client" placeholder="Nombre del Cliente" size="20" style="font-family: Arial;  height:30px; font-size: 20pt;" maxlength="10" autocomplete="off" required>
                </div>
					<p id="msgerror" style="color:red;"></p>
					<button type="submit" class="btn btn-success" name="EnviarRecarga" id="EnviarRecarga"> Cobrar</button>
        	</form>
            </div>
       </div>
</body>
</html>



<script type="text/javascript">
$(function (e) {
	$('#RecargaMayoreo').submit(function (e) {
	  e.preventDefault()
  $('#ajax').load('CobrarRecargaMayoreo.php?' + $('#RecargaMayoreo').serialize())
	})
})
</script>	



<script>
$(function() {
    $( "#client" ).autocomplete({
       source: 'search.php',
       //change: function (event, ui) { 
       //$('#ConfNum').load('AjaxNombre.php?client=' + $("#client").val())
       //}
    });
});
</script>

<!--
<script>
   $(document).ready(function(){
      $("#compania").change(function() {
          $('option', '#monto').remove();
          //alert('getdenominacion.php?codigo='+$("#compania").val())
          $("#monto").empty();
          $.getJSON('GetDenominacionMasiva.php?codigo='+$("#compania").val(),function(data){
              //console.log(JSON.stringify(data));
              $.each(data, function(k,v){
                  $("#monto").append("<option value="+k+"> $"+v+".00</option>");
              }).removeAttr("disabled");
          });
      });
      });
</script>	  
-->