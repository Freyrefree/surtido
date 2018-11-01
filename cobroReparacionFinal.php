<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contado</title>
    <style type="text/css" media="print">
    	#Imprime {
    		height: auto;
    		width: 310px;
    		margin: 0px;
    		padding: 0px;
    		float: left;
    		font-family: Arial, Helvetica, sans-serif;
    		
    		color: #000;
    	}
    	@page{
    	   margin: 0;
    	}

  </style>
  <style>
      .nota{
        border-collapse: collapse;border: 1px solid #0B2161;font-size: 14px;
        border-radius: 25px;
        color: #0B2161;
      }
      .product{
        border: 1px solid black;
      }
  </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script language="javascript">

	  function imprSelec(nombre) {
	  ////////
		  var ficha = document.getElementById(nombre);
		  var ventimp = window.open(' ', 'popimpr');
		  ventimp.document.write( ficha.innerHTML );
		  ventimp.document.close();
		  ventimp.print( );
		  ventimp.close();
	  }
    
	</script> 
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
    <!-- descargar en pdf -->
    <script src="js/jspdf.min.js"></script>
    <script>
    </script>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
</head>
<body>
  

<?php
session_start();
include("host.php");
include("funciones.php");
include('IMP_LiberarReparacion.php');

$sucursal   = $_SESSION['sucursal'];
$idSucursal = $_SESSION['id_sucursal'];
$usuario=$_SESSION['username'];
$hoy=$fechay=date("Y-m-d");
$id_reparacion = $_GET['idReparacion'];
$dineroRecibo = $_GET['dineroRecibo'];

//$idSucursal = 15;
$consulta = "SELECT * FROM reparacion WHERE id_reparacion = '$id_reparacion'";
if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {

  if($paquete = consultar($con,$consulta)){
    $fila = mysqli_fetch_array($paquete);
        if($fila['resto'] == ''){
            $resto = ($fila['precio_inicial']-$fila['abono']);
        }else{
            $resto = $fila['resto'];
        }  
  }

  $totalPagar = $resto;

  $pagoResto = "UPDATE reparacion SET pagoResto = '$totalPagar' WHERE id_reparacion = '$id_reparacion'";
  actualizar($con, $pagoResto);


  $cambio = ($dineroRecibo - $totalPagar);

  PDFLiberar($id_reparacion,$totalPagar,$dineroRecibo,$cambio,$con,$hostDB, $usuarioDB, $claveDB, $baseDB);

  $html = '<center><a href="reparaciones.php" class="btn"><i class="icon-backward"></i> Regresar a Reparaciones</a>
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
  
  </center><br>
  <table width="100%" border="0">
  <tr>
    <td width="50%">
      <center>
        <pre style="font-size:24px"><strong class="text-success">Total a Pagar</strong></pre>
        <pre style="font-size:24px"><strong>$ '.$totalPagar.'</strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></pre>
        <pre style="font-size:24px"><strong>$ '.$dineroRecibo.'</strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Cambio</strong></pre>
        <pre style="font-size:24px"><strong>$ '.$cambio.'</strong></pre>
      </center>
    </td>
  <td width="50%" rowspan="2">
    <div id="titulo"></div>
    <div id="Imprime" >
        <embed src="Facturas/RL'.$id_reparacion."_".$idSucursal.'.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
    </div>
  </td>
  </tr>
  <tr>
  <td>
    <center>
      <div class="alert alert-success">
          <strong>Pago realizado con exito</strong><br><a href="reparaciones.php">Regresar a Reparaciones</a>
      </div>           
    </center>
  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  </table>
  </body>
  </html>';

  echo $html;

}

?>
