<?php
try {
 

  setlocale(LC_ALL,"es_ES");
 		session_start();
    include('php_conexion.php'); 
		//include('IMP_contado.php');
    include('IMP_Reparacion.php');
    $id_sucursal = $_SESSION['id_sucursal']; 
		if(!$_SESSION['tipo_usu']=='a'){
			header('location:error.php');
		}
    if ($_GET['tipo'] == "REPARACION") {
      echo "si pasa tipo reoaracion";
      $id_reparacion = $_GET['id_reparacion'];
      $sent=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'");
        if($data=mysql_fetch_array($sent)){ 
        $tpagar=$data['precio'];
        $ccpago=$data['abono'];
        $cambio=$data['precio']-$data['abono'];
      }
    }
		
		if(!empty($_GET['mensaje'])){
			$error='si';
		}else{
			$error='no';
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
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
      /*$(document).ready(function(){
      var doc = new jsPDF();
        var specialElementHandlers = {'#titulo': function (element, renderer) {
          return true;
          alert("specialElementHandlers");
        }
        };
        $('#cmd').click(function () {
            doc.fromHTML($('#Imprime').html(), 70, 15, {
                'width': 850,
                    'elementHandlers': specialElementHandlers
            });
            doc.save('Factura.pdf');
        });
    });*/
    </script>
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
<body data-spy="scroll" data-target=".bs-docs-sidebar">

<?php if($error=='no'){ ?>
<center><a href="reparaciones.php" class="btn"><i class="icon-backward"></i> Regresar a Reparaciones</a>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
<!-- <a href="IMP_contado.php?factura=<?php echo $factura; ?>" class="btn"><i class="icon-print"></i> Imprimir Factura</a> -->
</center><br>

<table width="100%" border="0">
  <tr>
    <td width="50%"><center>
        <pre style="font-size:24px"><strong class="text-success">Total a Pagar</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($tpagar,2,",","."); ?></strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($ccpago,2,",","."); ?></strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Resto</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($cambio,2,",","."); ?></strong></pre>
    </center></td>
    <td width="50%" rowspan="2">
    <?php 
    	
      $dia=date("d");
      setlocale(LC_ALL,"es_ES");
      $mes=strtoupper(date("M"));
      $year=date("o");
      $tipoventa=$_GET['tipo'];
      
      PDFR($id_reparacion);
    ?>
<!-- ticket a imprimir -->
<!-- style="color:#00A4DF" -->
<div id="titulo"></div>
<div id="Imprime" >
    <embed src="Facturas/R<?php echo $id_reparacion; ?>.pdf" width="100%" height="380" internalinstanceid="4" title>
</div>
     
    </td>
  </tr>
  <tr>
    <td><center>
        <div class="alert alert-success">
            <strong>Reparacion registrada con exito</strong><br><a href="caja.php?ddes=0">Regresar a Reparaciones</a>
        </div>
        
        <?php } 
            if($error=='si'){
        ?>
                    <div class="alert alert-error" align="center">
                      <strong>El dinero recibido es menor al valor a pagar</strong> <br>
                      <strong><a href="caja.php?ddes=<?php echo $_SESSION['ddes']; ?>">Regresar a la caja</a></strong>
                    </div>
        <?php } 
            if($error=='num'){
                echo '<div class="alert alert-error" align="center">
                      <strong>Solo debe de ingresar numeros en este campo</strong> <br>
                      <strong><a href="caja.php?ddes='.$_SESSION['ddes'].'">Regresar a la caja</a></strong>
                    </div>';
            }
        ?>
	</center>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<center>
<br>
</center>
</body>
</html>
<?php 
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
 ?>