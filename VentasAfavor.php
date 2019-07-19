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
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Listado Ventas a Credito</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <!-- "DATA TABLE" -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <!-- ********* -->

  <style>

    body{
            
            background: #F7D358;
    }
    .titulo{

            background: #e7e7e7;
            color: #F2F2F2;
    }
    .modal-header{

            background: #0275d8;
            color: #F2F2F2;
    }
    .listado-tareas {
            max-height: calc(50vh - 70px);
            overflow-y: auto;
    }
    .btn{
            border-radius: 0px;
    }
    .finish{
            text-decoration:line-through;
    }
    .dropdown-item{
            color: #E5E8E8;
    }
    .dropdown-item:hover{
            color:#F4F6F6;
    }
    .form-control{
            margin: 0px;
    }
    .black{
        color: black;
    }
    .red{
        color: red;
    }
    .green{
        color: green;
    }

  </style>

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
<?php include_once "layout.php"; ?>
<body>

<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-block titulo"></div>
					<div class="card-block">
						<div class="row">

							<div class="col-md-12">
								<br>

								<div class="container">

									<div class="row">
										<div class="col-md-12">
											<p class="black font-weight-bold titulo text-center">LISTADO DE VENTAS CON SALDO A FAVOR</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">

                                            <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
                                              <div class="input-append">
                                                    <label style="padding-right: 100px;"><input type="checkbox" id="nomb" name="nomb" value="name"> Nombre</label>
                                                    <input class="form-control" name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar">
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
                                                    <button class="btn btn-primary" type="submit">Buscar por Fecha / RFC!</button>
                                              </div>
                                            </form>                       
                                        
                                        </div>

                                        <div class="col-md-3">                        
                                       
                                       
                                        </div>

                                        <div class="col-md-6">


                                        </div>


                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">

                    <table  class="table">
                      <thead>
                      <tr>
                        <th>Codigo</th>
                        <th>RFC Cliente</th>
                        <th>Nombre Cliente</th>
                        <th>Cantidad a Favor</th>
                        <th>Fecha de la ultima compra</th>
                      </tr>
                      </thead>
                      <tbody>

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
                              $estado='<span class="badge badge-danger">Sis. Apartado</span>';
                          }else{
                              $estado='<span class="badge badge-success">Sis. Apartado</span>';
                          }
                        }else {
                          if($dato['estatus']=='0'){
                              $estado='<span class="badge badge-danger">Sis. Credito</span>';
                          }else{
                              $estado='<span class="badge badge-success">Sis. Credito</span>';
                          }
                        }
                        $rfc_cliente = $dato['RfcCliente'];
                        $canc=mysql_query("SELECT nom FROM cliente WHERE rfc='$rfc_cliente'") or die ((print"Errir al consultar cliente".mysql_error()));
                        while($datoc=mysql_fetch_array($canc)){
                            $nombre = $datoc['nom'];
                        }
                        $detalle = '<span class="badge badge-info"><strong>Más</strong></span>';
                      ?>
                        <tr>
                            <td><?php echo $dato['Id']; ?></td>
                            <td><?php echo $dato['RfcCliente']; ?></td>
                            <td><?php echo $nombre; ?></td>
                            <td>$<?php echo number_format($dato['Sobrante'],2,",","."); ?></td>
                            <td><?php echo $dato['FechaVenta']; ?></td>
                            
                        </tr>
                        <?php } $nombre="";?>
                        </tbody>
                    </table>

										</div>
									</div>

								</div>

							</div>

							<div class="col-md-12">
								
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



  
</body>
</html>



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
