<?php
 		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
    //obtener el nombre de la persona
		$usuario=$_SESSION['username'];$cans=mysql_query("SELECT * FROM usuarios where usu='$usuario'");
    if($datos=mysql_fetch_array($cans)){$nombre_usu=$datos['nom'];$ced = $datos['ced'];}
    if(!empty($_POST['tmp_cantidad']) and !empty($_POST['tmp_nombre']) and !empty($_POST['tmp_valor'])){	$tmp_cantidad=$_POST['tmp_cantidad'];
			$tmp_nombre=$_POST['tmp_nombre'];$tmp_valor=$_POST['tmp_valor'];$fechay=date("Y-m-d");

  $tmp_importe=$tmp_cantidad*$tmp_valor;
  srand(time());
  $numero_aleatorio = rand(1,10000);
  $numero_aleatorio = $numero_aleatorio."PC";
  $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu) VALUES  ('$numero_aleatorio','$tmp_nombre','$tmp_valor','$tmp_cantidad','$tmp_importe','$tmp_cantidad','$usuario')";mysql_query($sql);
		}
        $botoninicio = "Apertura";
        $botonfinal = "Cierre";
        $hora = date("g:i");
        $fecha = date("Y-m-d");
        //---------------------------CORTE DE CAJA------------------------------------------------------------------------
        
            if (!empty($_POST['cierre'])) {
                  //--------------------------------------------------------------------
                  $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
                  if($dat=mysql_fetch_array($sqle)){
                    $ventas = $dat['cantidad'];
                    $hi = $dat['horainicio'];
                    $aper=$dat['apertura'];
                    
                    if ($_POST['efectivo'] >= $_POST['cierre']) {
                      $cierrecaja = $_POST['cierre'];
                      $sqlf = "INSERT INTO detalle_caja (id_cajero,apertura,ventas,cierre,horainicio,horacierre,fecha)
                                VALUES ('$ced','$aper','$ventas','$cierrecaja','$hi','$hora','$fecha')";
                      mysql_query($sqlf);
                    }
                  }
                //----------------------------------------------------------------------
                if ($_POST['efectivo'] >= $_POST['cierre']) {
                  $reserva = $_POST['efectivo']-$_POST['cierre'];
                  $sqla = "UPDATE caja set estado=0, apertura='$reserva',horafin='$hora',cantidad='0' WHERE id_cajero='$ced'";
                  mysql_query($sqla);
                }
            }
        //-----------------------------------------------------------------------------------------------------------------
        $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
        if($dat=mysql_fetch_array($sqle)){
          $estado=$dat['estado'];
          if ($estado == 1) {
            $botoninicio = $dat['horainicio'];
            $botonfinal = "Cerrar";
          }else {
            $botonfinal = "Cierre";
            $botoninicio = "Apertura";
          }
          $dinerocaja = $dat['apertura']+$dat['cantidad']; //dinero en caja para apertura
          //-----------------apertura de caja--------------------------------------------------------------------
          if (!empty($_POST['apertura']) || !empty($_POST['tcaja']) || !empty($_POST['inicio'])) {
              $apertura = $_POST['apertura'];
              if ($estado == 0){
                  /*echo "<script>alert('entra al if de estado == 0');</script>";*/
                  $cantidad = $dinerocaja+$apertura;
                  /*echo $cantidad;*/
                  $sqla = "UPDATE caja set estado='1', apertura='$cantidad',horainicio='$hora' WHERE id_cajero='$ced'";
                  mysql_query($sqla);
                  $botoninicio = $dat['horainicio'];
                  $botonfinal = "Cerrar";
                  $dinerocaja = $cantidad;
                  $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
                  if($dat=mysql_fetch_array($sqle))
                    $botoninicio=$dat['horainicio'];
              }
          }
          }else {
            /*if (!empty($_POST['apertura'])){*/
              if (!empty($_POST['inicio'])) {
                $inic = $_POST['apertura'];
                $sqlc = "INSERT INTO caja (id_cajero, apertura, estado, horainicio)
                VALUES ('$ced','$inic','1','$hora')";
                mysql_query($sqlc);
                
              $sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");

              if($dat=mysql_fetch_array($sqle)){

               $botoninicio = $dat['horainicio'];
               $dinerocaja = $inic;
              }
              }
            /*}*/
          }
          $fecha=date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>caja</title>
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
    
    <script>
      /*var bandera = false;
  	  function  hola(){
  		alert("hola")
  		}*/
      function nuevo(){
        var valor = document.getElementById('client').value;
        if (valor == "nuevo") {
            document.location.href="crear_clientes.php";
        }
      }
	</script>
  
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
   <script type="text/javascript">
       window.onload= function(){
       		document.form1.codigo.focus()
       }
	
	</script>-->
<!--
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <style>
    /* .opciones{
      margin-top: -30px;
    } */
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0" class="opciones">
<tr><td>
<a href="VentasCredito.php" role="button" class="btn btn-primary credito">Ventas a Credito</a>
<a href="CancelarVenta.php" role="button" class="btn btn-danger credito" >Cancelar Venta</a>
<!-- <button class="btn btn-primary">Ventas a Credito</button> -->
</td></tr>
  <tr>
    <td width="25%" rowspan="2"><div class="control-group info">
        <form name="form1" method="post" action="">
          <label>
          <input type="text" autofocus class="input-xlarge" id="codigo" name="codigo" list="characters" placeholder="Codigo de barra o Nombre del producto" autocomplete="off" >
          	  <datalist id="characters" >
              <?php 
			  $can=mysql_query("SELECT * FROM producto WHERE estado = 's'");
			  while($dato=mysql_fetch_array($can)){
				  echo '<option value="'.$dato['nom'].'">';
				  $codigo11 = $dato['cod'];
				  }
			  ?>
         	</datalist>
            </label>
        </form>
      </div>
      <?php 
	  	if(!empty($_POST['codigo'])){
      $codigo=$_POST['codigo'];
      
      //aplicar substring al valor del lector de codigo de barras y quitarle el ultimo caracter
      //$codigo = substr($codigo, 0, -1);
		  $can=mysql_query("SELECT * FROM caja_tmp where cod='$codigo' or nom='$codigo'");
			if($dato=mysql_fetch_array($can)){
        
          //-------------------------------------------
          if (($dato['exitencia']-$dato['cant'])>0) {
              $acant=$dato['cant']+1;$dcodigo=$dato['cod'];$aventa=$dato['venta']*$acant;
      				$sql="Update caja_tmp Set importe='$aventa', cant='$acant' Where cod='$dcodigo'";mysql_query($sql);	
          }else {
                echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">×</button><strong>No hay exitencia del producto</strong></div>';
              }
          //-------------------------------------------
			}else{
        $cans=mysql_query("SELECT * FROM producto where cod='$codigo' or nom='$codigo'");	
      if($datos=mysql_fetch_array($cans)){
					if($_SESSION['tventa']=="venta"){
            $importe=$datos['venta'];	$venta=$datos['venta'];	
            }else{
              $importe=$datos['mayor'];	$venta=$datos['mayor'];
              }
              if ($datos['cantidad'] < 1) {
                echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">×</button><strong>No hay existencia del producto</strong></div>';
              }else {
                $cod=$datos['cod'];$nom=$datos['nom'];$cant="1";$exitencia=$datos['cantidad'];$usu=$_SESSION['username'];
                $sql="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia, usu) VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia','$usu')";mysql_query($sql);
              }
              }else{
                echo '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">×</button><strong>Producto no encontrado en la base de datos<br><a href="#mycrear" role="button" class="btn btn-success" data-toggle="modal">Crear Nuevo Producto </a></strong></div>';
                }
                }
                }  
                ?> 
  	</td>
    <td width="13%" align="right" rowspan="2" >&nbsp;</td>
    <td width="25%" height="51" ><center>
    	   <a href="#mycrear" role="button" class="btn" data-toggle="modal">
        	<i class="icon-tag"></i> Agregar Producto Común
         </a>
    </td>
    <!-- ------------------------------------------------------------------------------------------------------------------- -->
    <td width="1%" align="right" rowspan="2" >&nbsp;</td>
    <td> <!-- apertura de caja indica con cuanto dinero en efectivo inicia la caja -->
      <a href="#Apertura" role="button" class="btn btn-success" data-toggle="modal"> <?php echo "$botoninicio"; ?> </a>
    </td>
    <td width="1%" align="right" rowspan="2" >&nbsp;</td>
    <td> <!-- cierre de caja indica con cuanto dinero en efectivo se queda la caja la caja -->
      <a href="#Cierre" role="button" class="btn btn-primary" data-toggle="modal"><?php echo "$botonfinal"; ?></a>
    </td>
    <td width="1%" align="right" rowspan="2" >&nbsp;</td>
    <!-- ------------------------------------------------------------------------------------------------------------------- -->
    <td width="37%" rowspan="2">
    	<pre><center>Nombre del Cajero/a : <?php echo $nombre_usu; ?></center></pre>
        <div align="right">
        	<?php 	if(!empty($_SESSION['tventa'])){if($_SESSION['tventa']=='venta'){$vboton="btn btn-primary";
					}else{$vboton="btn";}if($_SESSION['tventa']=='mayoreo'){$mboton="btn btn-primary";
					}else{$mboton="btn";}}else{$_SESSION['venta'];	$vboton="btn btn-primary";}?>
                    <strong>Tipo de Compra: 
            <button type="button" class="<?php echo $vboton; ?>" onClick="window.location='php_caja.php?tventa=venta'">P. Publico</button> 
            <button type="button" class="<?php echo $mboton; ?>" onClick="window.location='php_caja.php?tventa=mayoreo'">P. Mayoreo</button></strong>
        </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
	$can=mysql_query("SELECT * FROM caja_tmp where usu='$usuario'");if($dato=mysql_fetch_array($can)){echo '<div style=" OVERFLOW: auto; WIDTH: 100%; TOP: 48px; HEIGHT: 200px">';}?>
<table width="00%" border="0" class="table table-hover">
  <tr class="info">
    <td width="13%"><strong>Codigo</strong></td>
    <td width="27%"><strong>Descripcion del Producto</strong></td>
    <td width="15%"><strong>Valor Unitario</strong></td>
    <td width="13%"><strong><center>Cant.</center></strong></td>
    <td width="12%"><strong>Importe</strong></td>
    <td width="9%"><strong><center>Existencia</center></strong></td>
    <td width="11%">&nbsp;</td>
  </tr>
 
  <?php $na=0;$can=mysql_query("SELECT * FROM caja_tmp where usu='$usuario'");  while($dato=mysql_fetch_array($can)){ $na=$na+$dato['cant']; ?>
  <tr>
    <td><?php echo $dato['cod']; ?>&nbsp;<?php echo '<img src="articulo/'.$dato['cod'].'.jpg" WIDTH=35 HEIGHT=12>'; ?></td>
    <td><?php echo $dato['nom']; ?></td>
    <td><div align=""><a href="caja.php?id=<?php echo $dato['cod'].'&ddes='.$_SESSION['ddes']; ?>">$ <?php echo number_format($dato['venta'],2,",","."); ?></a></div></td>
    <td><center><a href="caja.php?idd=<?php echo $dato['cod'].'&ddes='.$_SESSION['ddes']; ?>"><?php echo $dato['cant']; ?></a></center></td>
    <td bgcolor="#D9EDF7"><div align="right">$ <?php echo number_format($dato['importe'],2,",","."); ?></div></td>
    <td><center><?php 
	if(($dato['exitencia']-$dato['cant'])>0){
		echo $dato['exitencia']-$dato['cant'];
	}else{
		echo 0;
	}
	 ?></center></td>
    <td> 
    <button type="button" class="btn btn-danger" onClick="window.location='php_eliminar_caja.php?id=<?php echo $dato['cod']; ?>'"><i class="icon-minus-sign"></i> Remover</button>
    </td>
  <?php } ?>
  
</table>

<?php	$can=mysql_query("SELECT * FROM caja_tmp where usu='$usuario'");if($dato=mysql_fetch_array($can)){	echo '</div>';} //cierra el div?>
<?php if(!empty($_GET['id'])){ ?>
<form name="form2" method="get" action="php_caja_act.php">
  <input type="hidden" name="xcodigo" id="xcodigo" value="<?php echo $_GET['id'] ?>">
  Nuevo Precio o % Descuento: <input type="text" name="xdes" id="xdes" value="0" autocomplete="off">
  [ <input type="radio" name="tipo" id="optionsRadios1" value="p" checked>Descuento % ]
  [ <input type="radio" name="tipo" id="optionsRadios1" value="d" checked>Nuevo Precio $ ]
  <button type="submit" class="btn btn-success">Procesar</button>  
</form>
<?php } ?>
<?php if(!empty($_GET['idd'])){ ?>
<form name="form2" method="get" action="php_procesar_caja.php">
  <input type="hidden" name="xcodigo" id="xcodigo" value="<?php echo $_GET['idd'] ?>">
  Cantidad: <input type="text" name="cantidad" id="cantidad" value="0" autocomplete="off">
  <button type="submit" class="btn btn-success">Procesar</button>  
</form>
<?php } ?>
<br>
<table width="100%" border="0">
  <tr>
    <td width="35%"><pre style="font-size:24px"><center><?php echo $na; ?> Articulos en venta</center></pre></td>
    <td width="3%">&nbsp;</td>
    <td width="26%">  	
    <?php
			if($_GET['ddes']>=0){
				$_SESSION['ddes']=$_GET['ddes'];	
			}
	?>
    <form name="form3" method="get" action="caja.php">
    <label>Descuento al Neto</label>
      <div class="input-prepend input-append">
        <input type="number" class="span1" min="0" max="99" name="ddes" id="ddes" value="<?php echo $_SESSION['ddes']; ?>">
        <span class="add-on">%</span>
      </div>
       <button type="submit" class="btn btn-mini">Aplicar Descuento</button>
    </form>
    </td>
    <td width="36%">
    	<div align="right">
    	  <pre style="font-size:24px">Neto: <?php $can=mysql_query("SELECT SUM(importe) as neto FROM caja_tmp where usu='$usuario'");
	  		if($dato=mysql_fetch_array($can)){$NETO=$dato['neto']-($dato['neto']*$_SESSION['ddes']/100);	$_SESSION['neto']=$NETO;
				echo '$ '.number_format($_SESSION['neto'],2,",",".");}?></pre>
        
    	</div>
    </td>
  </tr>
  <tr>
    <td colspan="4">
    <?php if($NETO<>0){ ?>
    <div class="well" style="max-width: 400px; margin: 0 auto 10px;">
        <div align="center">
        <a href="#myContado" role="button" class="btn btn-success" data-toggle="modal"><i class=" icon-shopping-cart"></i> V. Contado</a>
        <a href="#myCredito" role="button" class="btn btn-success" data-toggle="modal"><i class=" icon-shopping-cart"></i> V. Credito</a>
        </div>
    </div>

    <?php } ?>
    </td>
  </tr>
</table> 

<!-- Modal -- myContado -->
<div id="myContado" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">COBRAR AL CONTADO</h3>
  </div>
  <div class="modal-body">
    	<p align="center" class="text-info"><strong>Total Cobrar</strong></p>
    	<pre style="font-size:30px"><center><?php echo '$ '.number_format($_SESSION['neto'],2,",","."); ?></center></pre>
   	<p align="center" class="text-info"><strong>Forma de Pago "Contado"</strong></p>
        <div align="center">
          <form id="form1" name="contado" method="get" action="contado_credito.php">
                <label for="ccpago">Dinero Recibido</label>
                <input type="hidden" name="tpagar" id="tpagar" value="<?php echo $_SESSION['neto']; ?>">
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="ccpago" id="ccpago" autocomplete="on" step="any" required autofocus/>
                    <span class="add-on">.00</span>
                </div><br>
                <input type="hidden" name="tipocompra" id="tipocompra" value="CONTADO">
                <input type="submit" class="btn btn-success" name="button" id="button" value="Cobrar Dinero Recibido" />
          </form>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<!-- Modal -- myCredito -->
<div id="myCredito" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">VENTA A CREDITO</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong>Total Cobrar</strong></p>
      <pre style="font-size:30px"><center><?php echo '$ '.number_format($_SESSION['neto'],2,",","."); ?></center></pre>
    <!-- <p align="center" class="text-info"><strong>Forma de Pago "Credito"</strong></p> -->
        <div align="center">
          <form id="form1" name="contado" method="GET" action="contado_credito.php">
          <p align="center" class="text-info"><strong>Fecha Limite de Pago</strong></p>
          <input type="date" name="fecha" id="fecha"  value="<?php echo $fecha; ?>" required>
              <p align="center" class="text-info"><strong>Nombre del Cliente</strong></p>
              <label align="center">
              <select name="client" id="client" onchange="nuevo();"><!--  onchange="location = this.value" -->
                <option value="0"></option>
                <?php 
                  $can=mysql_query("SELECT * FROM cliente where estatus='s'");
                  while($dato=mysql_fetch_array($can)){
                ?>
                  <option value="<?php echo $dato['rfc']; ?>"><?php echo $dato['nom']; ?></option>
                <?php } ?>
                <option value="nuevo">Agregar</option>
                </select>
                <!-- <a href="crear_clientes.php" role="button" class="btn btn-success">Agregar</a> -->
                </label>
                <label for="ccpago">Dinero Recibido</label>
                <input type="hidden" name="tpagar" id="tpagar" value="<?php echo $_SESSION['neto']; ?>">
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="ccpago" id="ccpago" step="any" autocomplete="on" />
                    <span class="add-on">.00</span>
                </div><br>
                <input type="hidden" name="tipocompra" id="tipocompra" value="CREDITO">
                <input type="submit" class="btn btn-success" name="button" id="button" value="Cobrar Dinero Recibido" />
          </form>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<!-- -------------------------- modal apertura de caja ---------------------------------- -->
<div id="Apertura" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">APERTURA DE CAJA</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong>Cantidad exitente</strong></p>
        <div align="center">
          <form id="form1" name="inicio" method="post" action="caja.php">
                <div>
                  <input type="text" name="tcaja" id="tcaja" value="<?php echo $dinerocaja; ?>" readonly>
                </div>
                <label for="ccpago">Entrada de efectivo</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="apertura" id="apertura" autocomplete="on" />
                    <span class="add-on">.00</span>
                </div><br>
                <input type="hidden" name="inicio" id="inicio" value="1" readonly>
                <input type="submit" class="btn btn-success" name="button" id="button" value="Aceptar" />
          </form>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- ---------------------------------- modal cierre de caja --------------------------------------- -->
<div id="Cierre" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">CIERRE DE CAJA</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong>Cantidad en Caja</strong></p>
        <div align="center">
          <form id="form1" name="corte" method="post" action="caja.php">
                <div>
                  <input type="text" name="efectivo" id="efectivo" value="<?php echo $dinerocaja; ?>" readonly>
                </div>
                <label for="ccpago">Retiro de Efectivo</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="cierre" id="cierre" autocomplete="on" required />
                    <span class="add-on">.00</span>
                </div><br>
                <input type="submit" class="btn btn-success" name="button" id="button" value="Aceptar" />
          </form>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


</div>
</div>

<!-- Modal crear articulo -->
<div id="mycrear" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Agregar Producto en Comun</h3>
    </div>
    <div class="modal-body">
    	<form id="form1" name="form1" method="post" action="">
        <center>
        <table width="80%" border="0">
          <tr>
            <td>Descripcion</td>
            <td><input type="text" autofocus name="tmp_nombre" id="tmp_nombre" /></td>
          </tr>
          <tr>
            <td>Cantidad</td>
            <td><input type="number" name="tmp_cantidad" id="tmp_cantidad" min="1" value="1" /></td>
          </tr>
          <tr>
            <td>valor</td>
            <td><input type="number" name="tmp_valor" id="tmp_valor" /></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
            	
            </div></td>
          </tr>
        </table>
        </center>
    </div>
    <div class="modal-footer" align="center">
    	  <input type="submit" class="btn btn-primary" name="button" id="button" value="Guardar" />
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
    </form>
</div>	
      <!-- Modal crear articulo -->
<div id="mycrear" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Ventas a Credito</h3>
    </div>
    <div class="modal-body">
      <form id="form1" name="form1" method="post" action="">
        <center>
        <table width="80%" border="0">
          <tr>
            <td>Descripcion</td>
            <td><input type="text" autofocus name="tmp_nombre" id="tmp_nombre" /></td>
          </tr>
          <tr>
            <td>Cantidad</td>
            <td><input type="number" name="tmp_cantidad" id="tmp_cantidad" min="1" value="1" /></td>
          </tr>
          <tr>
            <td>valor</td>
            <td><input type="number" name="tmp_valor" id="tmp_valor" /></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
              
            </div></td>
          </tr>
        </table>
        </center>
    </div>
    <div class="modal-footer" align="center">
        <input type="submit" class="btn btn-primary" name="button" id="button" value="Guardar" />
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
    </form>
</div>  
</body>
</html>