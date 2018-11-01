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
    $usuario       = $_SESSION['username'];
    $ExMachineCount=0;
    $error = "no";

    $id_reparacion = $_GET['id_reparacion'];
    if($_SESSION['tipo_usu'] == 'a'){
        $sent=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion'");
    }else{
        $sent=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'");
    }
    
    if($data=mysql_fetch_array($sent)){
        $tpagar=$data['precio'];
        $ccpago=$data['abono'];
        $ccpago=$tpagar - $ccpago;
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
        <pre style="font-size:24px"><strong class="text-success">Cambio</strong></pre>
        <pre style="font-size:24px"><strong>$ <?php echo number_format($cambio,2,",","."); ?></strong></pre>
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
      $hora = "Entrega";
      PDFR($id_reparacion,$hora);
    ?>
<!-- ticket a imprimir -->
<!-- style="color:#00A4DF" -->
<div id="titulo"></div>
<div id="Imprime" >
    <embed src="Facturas/R_L<?php echo $id_reparacion."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
</div>
     <!-- <table class="nota" style="text-align: center; ">
        <tr>
          <td colspan="4" ><h4>ELÉCTRICA FERRETERIA</h4><h2>"EL JEFE"</h2></td>
        </tr>
        <tr>
          <td><img src="img/Logoa.png" alt=""  style="border: white 1px solid; height:10%"></td>
          <td >
            <h4>JUAN CARLOS TORIBIO ROMERO</h4>
            <p>R.F.C. TORJ860317NF5</p>
            <p>GUSTAVO VICENCIO 27-A COLONIA CENTRO XONACATLAN MÉX.</p>
            <strong>TEL (722) 2477820</strong>
          </td>
          <td colspan="2">NOTA<p style="color:red">N° <?php echo $factura; ?></p></td>
        </tr>
        <tr>
          <td colspan="4" align="right">XONACATLAN, MÉX. A. <?php echo $dia.' DE '.$mes.' DEL '.$year; ?></td>
        </tr>

        <?php if ($_GET['tipo'] == "CREDITO"){
          $tipoventa=$_GET['tipo'];
          $rfc = $_GET['rfc'];
            $query=mysql_query("SELECT * FROM cliente where rfc='$rfc'");
            while($dato=mysql_fetch_array($query)){
              $nomclient=$dato['empresa'];
              $dirclient=$dato['calle'].', N.ext.'.$dato['next'].', N.int.'.$dato['nint'].', Col. '.$dato['colonia'].', '.$dato['municipio'].', '.$dato['estado'];
            }
          ?>
            <tr>
              <td colspan="4" align="left">
                <p>NOMBRE: <?php echo $nomclient; ?></p>
                <p>DIRECCION: <?php echo $dirclient; ?></p>
              </td>
            </tr>
        <?php } ?>

        <tr>
          <td class="product">CANT.</td>
          <td class="product">ARTICULO</td>
          <td class="product">PRECIO<br>UNITARIO</td>
          <td class="product">IMPORTE</td>
        </tr>
        <?php 
            $numero=0;$valor=0;$importe=0;
            $can=mysql_query("SELECT * FROM detalle where factura='$factura'"); 
            while($dato=mysql_fetch_array($can)){
            $numero=$numero+1;
            $importe=$dato['cantidad']*$dato['valor'];
            $valor=$valor+$importe;
            $tipo=$dato['tipo'];
          ?>
        <tr>
          <td class="product"><?php echo $dato['cantidad']; ?></td>
          <td class="product" align="left"> &nbsp; <?php echo $dato['nombre']; ?></td>
          <td class="product">$ <?php echo number_format($dato['valor'],2); ?></td>
          <td class="product">$ <?php echo number_format($importe,2); ?></td>
        </tr>

        <?php $importe=0; } ?>
        <tr>
          <td></td><td></td>
          <td align="right"><b>TOTAL $</b></td>
          <td><b><?php echo number_format($valor,2); ?></b></td>
        </tr>
        <tr>
          <td></td><td></td>
          <td align="right">EFECTIVO $</td>
          <td> <?php echo number_format($ccpago,2); ?></td>
        </tr>
        <tr>
          <td></td><td></td>
          <td align="right">CAMBIO $</td>
          <td> <?php echo number_format(($valor-$ccpago),2); ?></td>
        </tr>
      </table>-->
      </div>
      <!-- <p><a href="IMP_contado.php?factura=<?php echo $factura; ?>&tipo=<?php echo $tipoventa; ?>&rfc=<?php echo $rfc; ?>&pago=<?php echo $ccpago; ?>" id="cmd" class="btn"><i class="icon-print"></i> Imprimir Factura</a></p> -->
<!-- ticket a imprimir -->
<!-- codigo imprimir 1-->
<!-- <center>
<div id="titulo"></div>
<div id="Imprime" style="font-size:<?php echo $tama.'px'; ?>"><br />
<iframe frameborder="0" height="100" width="300" src=""></iframe>
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
        <td width="93" align="right">IMPORTE</td>
      </tr>
      <tr>
        <td colspan="3"><center>======================================</center></td>
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
<button id="cmd"><i class="icon-print"></i> Imprimir Factura</button>
<p><a href="#" id="cmd" class="btn"><i class="icon-print"></i> Imprimir Factura</a></p>
</center> -->
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