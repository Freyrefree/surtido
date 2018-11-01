<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        if (!empty($_GET['id'])) {
            $identificador = $_GET['id'];
            /*echo "el valor obtenido es ".$identificador;*/
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Listado Ventas a Credito</title>
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

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <?php if (!empty($_GET['cambio'])) { 
        ?>
     <script>
            $(function() {
                $('#Cambio').modal('show');
            })
     </script>
     <?php } ?>
    <script>
        function enviar(id){
          $.ajax({ 
              type: "POST", 
              url: "PostAbono.php",
              data: "id="+id,
              success: function(msg){
              var valores = msg.split(";");
              //------------------------------
              document.getElementById('idventa').value = id;
              document.getElementById('tpagar').value = valores[0];
              /*$("#idventa").value = id;
              $("#tpagar").value = valores[0];*/
              //------------------------------
              $("#mont").text("$ "+valores[0]);
              document.getElementById('fecha').value = valores[1];
              $("#cliente").text("Cliente: "+valores[2]);
              $('#Apertura').modal('show');
              } 
          }); 
        }
        function mostrar(id){
          var valores = "codigo="+id;
          $.ajax({
                url: "DetalleVenta.php", /* Llamamos a tu archivo */
                data: valores, /* Ponemos los parametros de ser necesarios */
                type: "POST",
                contentType: "application/x-www-form-urlencoded",
                dataType: "json",  /* Esto es lo que indica que la respuesta será un objeto JSon */
                success: function(data){
                    /* Supongamos que #contenido es el tbody de tu tabla */
                    /* Inicializamos tu tabla */
                  //data = $.parseJSON(data);
                  $('#filtro').modal('show');
                    $("#tablafiltro").html('');
                    /* Vemos que la respuesta no este vacía y sea una arreglo */
                    if(data != null && $.isArray(data)){
                        $("#tablafiltro").append("<tr class='info'><td colspan='4'><center><strong>Productos</strong></center></td><tr>");
                        $("#tablafiltro").append("<tr><td width='3%'>codigo</td><td width='7%'>Nombre</td><td width='7%'>Cantidad</td><td width='7%'>Precio</td></tr>");
                        /* Recorremos tu respuesta con each */
                        $.each(data, function(index, value){
                            /* Vamos agregando a nuestra tabla las filas necesarias */
                            //alert(value.nombre);
                            $("#tablafiltro").append("<tr><td>" + value.id_articulo + "</td><td>" + value.nombre + "</td><td>" + value.cantidad + "</td><td> $ " + value.valor + "</td></tr>");
                        });
                    }
                }
            });
        }
        function aceptar(){
            $('#Cambio').modal('hide');
        }
    </script>

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
    <td>
    <!-- <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='PDFproducto.php'">Reporte PDF</button>
        <button type="button" class="btn btn-primary" onClick="window.location='crear_producto.php'">Ingresar Nuevo</button>
    </div> -->
    </td>
    <td>
    <div align="right">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-append">
            <label style="padding-right: 100px;"><input type="checkbox" id="nomb" name="nomb" value="name"> Nombre</label>
             <input name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar">
              <datalist id="characters">
              <?php
                $buscar=$_POST['bus'];
                $can=mysql_query("SELECT * FROM afavor");
                while($dato=mysql_fetch_array($can)){
                    echo '<option value="'.$dato['FechaVenta'].'">';
                    echo '<option value="'.$dato['RfcCliente'].'">';
                }
              ?>
          </datalist>
            <button class="btn" type="submit">Buscar por Fecha / RFC!</button>
      </div>
    </form>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="10"><center><strong>Listado de Ventas con saldo a favor</strong></center></td>
  </tr>
  <tr>
    <td><strong>Codigo</strong></td>
    <td><strong>RFC Cliente</strong></td>
    <td><strong>Nombre Cliente</strong></td>
    <td><strong>Cantidad a Favor</strong></td>
    <td><strong>Fecha de la ultima compra</strong></td>
  </tr>
    <?php 
	if(empty($_POST['bus'])){
		$can=mysql_query("SELECT * FROM afavor WHERE estatus='0' AND IdSucursal = '$id_sucursal' ORDER BY RfcCliente")or die ((print"Errir al consultar saldos 00".mysql_error()));;
	}else{
		$buscar=$_POST['bus'];
    if (!empty($_POST['nomb'])) {

      $que=mysql_query("SELECT rfc FROM cliente WHERE nom LIKE '%$buscar%'");
      //echo "SELECT rfc FROM cliente WHERE nom LIKE '%$buscar%'";
      if($row=mysql_fetch_array($que)){
        $rfc = $row['rfc'];
      }
      //echo "rfc: ".$rfc;
      $can=mysql_query("SELECT * FROM afavor WHERE RfcCliente = '$rfc'")or die ((print"Errir al consultar saldos".mysql_error()));
      //echo "SELECT * FROM credito WHERE rfc_cliente = '$rfc'";
    }else {

		  $can=mysql_query("SELECT * FROM afavor WHERE IdFactura LIKE '%$buscar%' or RfcCliente LIKE '%$buscar%' OR FechaVenta LIKE '%$buscar%'")or die ((print"Error al consultar Factura".mysql_error()));
    }
	}
	while($dato=mysql_fetch_array($can)){
		$codigo=$dato['cod'];
    if ($dato['tipo'] == 1) {
      if($dato['estatus']=='0'){
          $estado='<span class="label label-important">Sis. Apartado</span>';
      }else{
          $estado='<span class="label label-success">Sis. Apartado</span>';
      }
    }else {
      if($dato['estatus']=='0'){
          $estado='<span class="label label-important">Sis. Credito</span>';
      }else{
          $estado='<span class="label label-success">Sis. Credito</span>';
      }
    }
    $rfc_cliente = $dato['RfcCliente'];
    $canc=mysql_query("SELECT nom FROM cliente WHERE rfc='$rfc_cliente'") or die ((print"Errir al consultar cliente".mysql_error()));
    while($datoc=mysql_fetch_array($canc)){
        $nombre = $datoc['nom'];
    }
    $detalle = '<span class="label label-info"><strong>Más</strong></span>';
	?>
    <tr>
        <td><?php echo $dato['Id']; ?></td>
        <td><?php echo $dato['RfcCliente']; ?></td>
        <td><?php echo $nombre; ?></td>
        <td>$ <?php echo number_format($dato['Sobrante'],2,",","."); ?></td>
        <td><?php echo $dato['FechaVenta']; ?></td>
        <!-- <td><a  href="VentasCredito.php?id=<?php echo $dato['id']; ?>" data-toggle="modal"><?php echo $estado; ?></a></td> -->
    </tr>
    <?php } $nombre="";?>
</table>
</div>
<!-- Modal -- myCredito -->
<div id="Apertura" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">SISTEMA CREDITO / APARTADO</h4>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong id="cliente"></strong></p>
      <p align="center" class="text-info"><strong>Resto a Pagar</strong></p>
      <!-- <label align="center"><input type="text" readonly="true" id="mont"></label> -->
      <pre style="font-size:30px; text-align:center" id="mont"><center></center></pre>
    <!-- <p align="center" class="text-info"><strong>Forma de Pago "Credito"</strong></p> -->
        <div align="center">
          <form id="form1" name="contado" method="GET" action="AbonoCredito.php">
          <p align="center" class="text-info"><strong>Fecha de Pago</strong></p>
          <input type="date" name="fecha" id="fecha">
            <label for="ccpago">Dinero Recibido</label>
            <input type="hidden" name="idventa" id="idventa">
            <input type="hidden" name="tpagar" id="tpagar">
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="number" name="ccpago" id="ccpago" step="any" autocomplete="on" />
                <span class="add-on">.00</span>
            </div><br>
            <input type="submit" class="btn btn-success" name="button" id="button" value="Cobrar Dinero Recibido" />
          </form>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- modal muestra cambio si lo hay -->
<div id="Cambio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">CAMBIO DEL PAGO</h3>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong>Cantidad cambio</strong></p>
      <pre style="font-size:30px; text-align:center" id="cambioresto"><center>$ <?php echo $_GET['cambio']; ?></center></pre>
      <input type="submit" onclick="aceptar()" class="btn btn-success" name="button" id="button" value="Aceptar" />
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- -------------------------- modal Filtros ---------------------------------- -->
<div id="filtro" class="modal hide fade modal-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">DETALLE DE VENTA</h3>
  </div>
  <div class="modal-body">
      <div style="width: 100%; height: 250px; overflow-y: scroll;">
        <table width="80%" border="0" class="table" id="tablafiltro">
          <tr class="info">
            <td colspan="4"><center><strong>Productos/Accesorios</strong></center></td>
          </tr>
        </table>
      </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
</body>
</html>