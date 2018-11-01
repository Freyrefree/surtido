<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		$fecha=date("Y-m-d");
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
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

<!-- Obtenemos el saldo global del webservice -->

<?php
	$ClaveCanal = 'SURCELPROD';
	$PassCanal = 'Ejks258Rf25rsA5';
	

	$fecha = date_create();
	$TimeStamp = date_timestamp_get($fecha);
	$Longitud=strlen($str);

	if($Longitud<12){
		$TimeStamp = $TimeStamp."00";
	}


	$can=mysql_query("SELECT * FROM webservice");
	$ContaService = mysql_num_rows($can);

	if($ContaService==0){	

		$can=mysql_query("INSERT INTO webservice (IdWebService) VALUES ('$TimeStamp')");	

		$can=mysql_query("SELECT MAX(IdWebService) AS id FROM webservice");
		if($dato=mysql_fetch_row($can)){
			$IdWebService = $dato[0];
			$IdWebService=$IdWebService+1;	
		}
			    
	 }else{
			$can=mysql_query("SELECT MAX(IdWebService) AS id FROM webservice");
			if($dato=mysql_fetch_row($can)){
				$IdWebService = $dato[0];
				$IdWebService=$IdWebService+1;
			} 

			$can=mysql_query("INSERT INTO webservice (IdWebService) VALUES ('$IdWebService')");	

	 }    


	$Terminal = '';
	// $Producto = $cod; //codigo de producto compania
	// $Producto = utf8_encode($Producto);
	// $Destino = $numero;
	// $Monto = $ccpago;
	// $Monto = (double)$Monto;
	// $Monto = sprintf("%.2f", $Monto);
	// $Extra = '';
	// $Nodo = '';
	$params = array(
		'claveCanal' => $ClaveCanal, 
		'passCanal' => $PassCanal
	);
	// Valores de nodo padre 
	// $Nodo = "reverso";   //Modulo Reverso
	// $Nodo = "datos";     //Modulo datos
	// $Nodo = "consulta";  //Modulo saldoExterno
    // $Nodo = "status";    //Modulo statusVenta
	$Nodo = "saldo";     //Modulo venta

	$arrayName = array($Nodo => $params); // Este valor


    // Llamada al WebService
    $cliente = new SoapClient("https://www.movivendor.com/wsmovivendor.wsdl");

    /*
    //obtener las funciones a las que puedo llamar
    $funciones = $cliente->__getFunctions();

    echo "<h2>Funciones del servicio</h2>";
    foreach ($funciones as $funcion) {
        echo $funcion . "<br />";
    }

    //obtener los tipos de datos involucrados
    echo "<h2>Tipos en el servicio</h2>";
    $tipos = $cliente->__getTypes();

    foreach ($tipos as $tipo) {
        echo $tipo . "<br />";
    }
    */

    //hago la llamada pasando por parámetro un objeto como el que se define arriba
    $respuesta = $cliente->saldo($params);

    //var_dump($respuesta); // se imprime por pantalla la respuesta que será un Array asociativo con la estructura definida como GetWeatherResponse

    foreach ($respuesta as &$campo) {
        if($i==0){    
        $SaldoGlobal = $campo;
        }
        $i++;    
    }

    $can=mysql_query("SELECT * FROM saldosglobales");
    $Existe= mysql_num_rows($can);

    if($Existe==0){

        $query  = "INSERT INTO saldosglobales (Monto, FechaTiempo) VALUES($SaldoGlobal, NOW())";
        $result = mysql_query($query);    

    }else{

        $can=mysql_query("SELECT * FROM saldosglobales ORDER BY Id DESC LIMIT 1");
        if($gato=mysql_fetch_array($can)){

            $Gsaldo = $gato['Monto'];

            if($SaldoGlobal>$Gsaldo){

               $query  = "INSERT INTO saldosglobales (Monto, FechaTiempo) VALUES($SaldoGlobal, NOW())";
               $result = mysql_query($query);    

            }                

        }    

    }

    
$SaldoGlobal =  $SaldoGlobal * -1
?>      

<!-- Fin de uso webserive -->



<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="7"><center><strong>Asignar Saldo a Sucursales</strong></center></td>
  </tr>
    <tr class="warning">
    <td colspan="7"><center><strong>Saldo global: <?php echo "$".number_format($SaldoGlobal).".00"; ?></strong></center></td>
  </tr>
  <tr>
    <td width="5%"><strong>Sucursales</strong></td>
    <td width="7%"><strong>Nuevo Monto</strong></td>
    <td width="15%"><strong>Enviar</strong></td>
  </tr>
  <tr>
  <td>
  <select name="sucursal" id="sucursal">
		    <option value="0" selected>Seleccione sucursal </option>
		    <?php 
				$can=mysql_query("SELECT id,empresa FROM empresa");
				while($dato=mysql_fetch_array($can)){
			  ?>
		    <option value="<?php echo $dato['id']; ?>"><?php echo $dato['empresa']; ?></option>
		    <?php } ?>
	</select>
    </td>
    <td><input type="number" style="height:30px" step="any" name="saldo" id="saldo" required></td>
    <td><input type="submit" class="btn" value="Asignar Saldo"></td>
    </tr>
    </form>
</table>

<div id="TablaSaldoSucursales">
<table width="80%" border="0" class="table">
<tbody>
    <tr class="info">
        <td colspan="7"><center><strong>Saldo Actual en Sucursales</strong></center></td>
    </tr>
    <tr>
        <th><strong>Codigo</strong></td>
        <th><strong>Sucursal</strong></td>
        <th><strong>Saldo</strong></td>
    </tr>
<?php
        $query2=mysql_query("SELECT * FROM recargassucursal");
        while($dato=mysql_fetch_array($query2)){
?>        
    <tr>
        <td><?php echo $dato['Id'] ?></td>
        <td><?php echo $dato['Sucursal'] ?></td>
        <td><?php echo "$".$dato['Saldo'] ?></td>
    </tr>
<?php    
        }
?>        
    </tbody>
</table>
</div>

</div>
</body>
</html>

<script type="text/javascript">
$(function () {
	
    $('#sucursal').change(function ()
	{
        $('#SaldoActual').load('ConsultaSaldoSucursal.php?sucursal=' + this.options[this.selectedIndex].value)
 
	})
})


$(function () {
	
    $('#sucursal').keyup(function ()
	{
        $('#SaldoActual').load('ConsultaSaldoSucursal.php?sucursal=' + this.options[this.selectedIndex].value)
 
	})
})
</script>

<script type="text/javascript">
$(function (e) {
	$('#form1').submit(function (e) {
	  e.preventDefault()
  $('#TablaSaldoSucursales').load('ActualizarTablaSucursal.php?' + $('#form1').serialize());
  if (document.form1.saldo.value != "")
      document.form1.saldo.value = "";
	})
})
</script>	

