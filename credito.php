<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credito</title>

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

        .nota{
            border-collapse: collapse;border: 1px solid #0B2161;font-size: 14px;
            border-radius: 25px;
            color: #0B2161;
        }

        .product{
            border: 1px solid black;
        }
    </style>


    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script language="javascript">

	  function imprSelec(nombre) {
	  
		  var ficha = document.getElementById(nombre);
		  var ventimp = window.open(' ', 'popimpr');
		  ventimp.document.write( ficha.innerHTML );
		  ventimp.document.close();
		  ventimp.print( );
		  ventimp.close();
	  }
    
	</script> 
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
    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <body data-spy="scroll" data-target=".bs-docs-sidebar">


</head>
<body>
    



<?php
    session_start();
    include('funciones.php');
    include('host.php');
    include('IMP_CreditoApartado.php');


    $idSucursal   = $_SESSION['id_sucursal']; 
    $usuario      = $_SESSION['username'];



    if ($_GET['tipo'] == "CREDITO"){
      $tpagar=$_GET['tpagar'];
      $ccpago=$_GET['ccpago'];
      $factura=$_GET['factura'];
      $resto = $_GET['resto'];
      $cambio = $_GET['cambio'];
      $denominacion = $_GET['denominacion'];
     
    }

    

    $ruta = "Facturas/CA".$factura."_".$idSucursal;

    PDFCreditoApartado($factura,$ccpago,$tpagar,$resto,$cambio,$denominacion);
    


    $html='';
    $html.='
    <center>
        <a href="caja.php?ddes=0" class="btn"><i class="icon-backward"></i> Regresar a Ventas</a>
    <center><br>';

    $html.='
    <table width="100%" border="0">
    <tr>
    <td width="50%"><center>
        <pre style="font-size:24px"><strong class="text-success">Total</strong></pre>
        <pre style="font-size:24px"><strong>$ '.number_format($tpagar,2).'</strong></pre>

        <pre style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></pre>
        <pre style="font-size:24px"><strong>$ '.number_format($denominacion,2).'</strong></pre>

        <pre style="font-size:24px"><strong class="text-success">Usted Abona</strong></pre>
        <pre style="font-size:24px"><strong>$ '.number_format($ccpago,2).'</strong></pre>

        <pre style="font-size:24px"><strong class="text-success">Cambio</strong></pre>
        <pre style="font-size:24px"><strong>$ '.number_format($cambio,2).'</strong></pre>

        <pre style="font-size:24px"><strong class="text-success">Usted Resta</strong></pre>
        <pre style="font-size:24px"><strong>$ '.number_format($resto,2).'</strong></pre>


    </center></td>
    <td width="50%" rowspan="2">

    <div id="titulo"></div>
    <div id="Imprime">

        <embed src="'.$ruta.'.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
    
    </div>
    </td>
    ';

    echo $html;

    //echo "789789789789978978978978978978789";

?>

</body>
</html>



