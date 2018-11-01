<?php
  setlocale(LC_ALL,"es_ES");
 		session_start();
    include('php_conexion.php'); 
		include('IMP_contado.php');
    include('IMP_Reparacion.php');
    
    if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
			header('location:error.php');
		}


    $id_sucursal   = $_SESSION['id_sucursal']; 
    $OtrosMensajes =$_GET['OtrosMensajes'];
    $usuario       =$_SESSION['username'];
    $ExMachineCount=0;


    if ($_GET['tipo'] == "CREDITO"){
      $tpagar=$_GET['tpagar'];
      $ccpago=$_GET['ccpago'];
      $factura=$_GET['factura'];
      $cambio=$ccpago-$tpagar;
      if ($cambio <= 0) {
        $cambio = 0;
      }
    }

    
    if(!empty($_GET['tpagar']) and !empty($_GET['ccpago']) and !empty($_GET['factura'])){
			$tpagar=$_GET['tpagar'];
			$ccpago=$_GET['ccpago'];
			$factura=$_GET['factura'];
			$cambio=$ccpago-$tpagar;
      if ($cambio <= 0) {
        $cambio = 0;
      }
		}
    if ($_GET['tipo'] == "REPARACION") {
      $id_reparacion = $_GET['id_reparacion'];
      $sent=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'");
        if($data=mysql_fetch_array($sent)){ 
        $tpagar=$data['precio'];
        $ccpago=$data['abono'];
        $cambio=0;

             $u_sql=mysql_query("SELECT ced FROM usuarios where usu='$usuario'");
              if($udat=mysql_fetch_array($u_sql)){
                $cedula=$udat['ced']; //numero de cedula del ususario actual
              }

              $c_sql=mysql_query("SELECT cantidad FROM caja where id_cajero='$cedula'");
              if($cdat=mysql_fetch_array($c_sql)){
                $cantidad=$cdat['cantidad']; //numero de cedula del ususario actual
              }

              $suma = $ccpago+$cantidad;

              if($ExMachineCount==0){
              //actualizar la cantidad encaja en cada venta debe aumentar
              $a_sql="UPDATE caja SET cantidad='$suma' where id_cajero = '$cedula' AND estado = '1'";
              mysql_query($a_sql);
              $ExMachineCount++;
              }
      }
    }
		
		if(!empty($_GET['mensaje'])){
			$error='si';
		}else{
			$error='no';
    }
    
    $numero = $_GET['numero'];
    $confirm = $_GET['confirm'];
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
    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<?php
  if($OtrosMensajes=='sinusuario'){
                echo '<div class="alert alert-error" align="center">
                      <strong>Solo los clientes registrados pueden tener credito</strong> <br>
                      <strong><a href="caja.php?ddes='.$_SESSION['ddes'].'">Regresar a la caja</a></strong>
                    </div>';
            }else{
 ?>           

<?php if($error=='no'){ ?>
<center><a href="caja.php?ddes=0" class="btn"><i class="icon-backward"></i> Regresar a Ventas</a>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
<!-- <a href="IMP_contado.php?factura=<?php echo $factura; ?>" class="btn"><i class="icon-print"></i> Imprimir Factura</a> -->
</center><br>

<table width="100%" border="0">
  <tr>
    <td width="50%"><center>
        <pre style="font-size:24px"><strong class="text-success">Total a Pagar</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($tpagar,2); ?></strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($ccpago,2); ?></strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Cambio</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($cambio,2); ?></strong></pre>
    </center></td>
    <td width="50%" rowspan="2">
    <?php 
      $can=mysql_query("SELECT * FROM empresa where id=1");	
        if($dato=mysql_fetch_array($can)){
      	$empresa=$dato['empresa'];		$direccion=$dato['direccion'];
      	$telefono=$dato['tel1'];		$nit=$dato['nit'];
      	$fecha=date("d-m-y H:i:s");		$pagina=$dato['web'];
      	$tama=$dato['tamano'];
      }
      $can=mysql_query("SELECT * FROM factura where factura='$factura' AND id_sucursal = '$id_sucursal'");
        if($datos=mysql_fetch_array($can)){	
      	$cajera=$datos['cajera'];
      }
      $can=mysql_query("SELECT * FROM usuarios where usu='$cajera'");	
        if($datos=mysql_fetch_array($can)){	
      	$cajero=$datos['nom'];
      }
      $dia=date("d");
      setlocale(LC_ALL,"es_ES");
      $mes=strtoupper(date("M"));
      $year=date("o");
      $rfc = $_GET['rfc'];
      $tipoventa=$_GET['tipo'];
      if ($_GET['tipo'] == "REPARACION") {
        
        PDFR($id_reparacion);
      }else {if ($_GET['tipo'] == "ABONO") {
        $num = $_GET['n'];
      }else {
        $nombrecliente = $_GET['nombrecliente']; 
        PDF($factura,$tipoventa,$ccpago,$rfc,$tpagar,$numero,$confirm,$nombrecliente);
      }
      }
    ?>


<!-- ticket a imprimir -->
<!-- style="color:#00A4DF" -->
<div id="titulo"></div>
<div id="Imprime" >
  <?php if ($_GET['tipo'] == "REPARACION") { ?>
    <embed src="Facturas/R<?php echo $id_reparacion."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
  <?php }else { if ($_GET['tipo'] == "ABONO") {  ?>
    <embed src="Facturas/<?php echo "A".$num."_".$factura."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
  <?php 
  }else { ?>
    <embed src="Facturas/<?php echo $factura."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
  <?php } ?>
  <?php } //?#zoom=170 ?#zoom=170?>
</div>
</div>
    </td>
  </tr>
  <tr>
    <td><center>
        <div class="alert alert-success">
            <strong>Pago realizado con exito</strong><br><a href="caja.php?ddes=<?php echo $_SESSION['ddes']; ?>">Regresar a la caja</a>
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