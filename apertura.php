<?php
    session_start();
    include('php_conexion.php'); 
    if(!$_SESSION['tipo_usu']=='a'){
      header('location:error.php');
    }
    //contado.php?tpagar='.$tpagar.'&ccpago='.$ccpago)
    if(!empty($_GET['tpagar']) and !empty($_GET['ccpago']) and !empty($_GET['factura'])){
      $tpagar=$_GET['tpagar'];
      $ccpago=$_GET['ccpago'];
      $factura=$_GET['factura'];
      $cambio=$ccpago-$tpagar;
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
<center><a href="caja.php?ddes=0" class="btn"><i class="icon-backward"></i> Regresar a Ventas</a>
<a href="IMP_contado.php?factura=<?php echo $factura; ?>" class="btn"><i class="icon-print"></i> Imprimir Factura</a>
</center><br>

<table width="100%" border="0">
  <tr>
    <td width="50%"><center>
        <pre style="font-size:24px"><strong class="text-success">Total a Pagar</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($tpagar,2,",","."); ?></strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($ccpago,2,",","."); ?></strong></pre>
        <pre style="font-size:24px"><strong class="text-success">Cambio</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($cambio,2,",","."); ?></strong></pre>
    </center></td>
    <td width="50%" rowspan="3">
    <?php 
  $can=mysql_query("SELECT * FROM empresa where id=1"); 
    if($dato=mysql_fetch_array($can)){  
    $empresa=$dato['empresa'];    $direccion=$dato['direccion'];
    $telefono=$dato['tel1'];    $nit=$dato['nit'];
    $fecha=date("Y-m-d H:i:s");   $pagina=$dato['web'];
    $tama=$dato['tamano'];
  }
  $can=mysql_query("SELECT * FROM factura where factura='$factura'"); 
    if($datos=mysql_fetch_array($can)){ 
    $cajera=$datos['cajera'];
  }
  $can=mysql_query("SELECT * FROM usuarios where usu='$cajera'"); 
    if($datos=mysql_fetch_array($can)){ 
    $cajera=$datos['nom'];
  }
?>
<!-- codigo imprimir -->
<center>
<div id="Imprime" style="font-size:<?php echo $tama.'px'; ?>"><br />
<!-- <iframe frameborder="0" height="100" width="300" src="></iframe> -->
    <table width="310px" border="0">
      <tr>
        <td>
        <strong><?php echo $empresa; ?></strong><br />
        <?php echo $direccion; ?><br />
        <?php echo $telefono; ?><br />
        <?php echo $nit; ?><br /></td>
      </tr>
      <tr>
        <td><div align="right"><?php echo $fecha; ?></div></td>
      </tr>
      <tr>
        <td>CAJERO: <?php echo $cajera; ?></td>
        </tr>
   </table><br>
   <table width="310px" border="0">
      <tr>
        <td width="45">CANT </td>
        <td width="158">DESCRIPCION</td>
        <td width="93"><div align="right">IMPORTE</div></td>
      </tr>
      <tr>
        <td colspan="3"><center>=====================================</center></td>
      </tr>
      <?php 
      $numero=0;$valor=0;
      $can=mysql_query("SELECT * FROM detalle where factura='$factura'"); 
      while($dato=mysql_fetch_array($can)){
      $numero=$numero+1;
      $valor=$valor+$dato['valor'];
      $tipo=$dato['tipo'];
        
    ?>
      <tr>
        <td><?php echo $dato['cantidad']; ?></td>
        <td><?php echo $dato['nombre'].'<br>'.$dato['codigo']; ?></td>
        <td><div align="right">$ <?php echo number_format($dato['valor'],2,",","."); ?></div></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3"><center>NO. DE ARTICULOS: <?php echo $numero; ?></center></td>
      </tr>
      <tr>
        <td colspan="3"><center>
          <strong>TOTAL: $ <?php echo number_format($valor,2,",","."); ?></strong>
        </center></td>
      </tr>
      <tr>
        <td colspan="3"><center><strong>* VENTA A <?php echo $tipo; ?> *</strong></center></td>
      </tr>
      <tr>
        <td colspan="3"><center>FIRMA DEL CLIENTE</center></td>
      </tr>
      <tr>
        <td colspan="3"><center>__________________________</center></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><center>GRACIAS POR SU COMPRA</center></td>
      </tr>
      <tr>
        <td colspan="3"><center><?php echo $pagina; ?></center></td>
      </tr>
    </table>
  <br>
</div>
<p><a href="IMP_contado.php?factura=<?php echo $factura; ?>" class="btn"><i class="icon-print"></i> Imprimir Factura</a></p>
<!-- fin del codigo factura --></center>
    </td>
  </tr>
  <tr>
    <td><center>
        <div class="alert alert-success">
            <strong>Pago realizado con exito</strong><br><a href="caja.php?ddes=0">Regresar a la caja</a>
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