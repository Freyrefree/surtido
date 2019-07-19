<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'  or !$_SESSION['tipo_usu']=='te' or !$_SESSION['tipo_usu']=='su'){
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

</head>
<?php include_once "layout.php"; ?>
<body>

<?php if (!empty($_GET['cambio'])) { ?>
  <script>
    $(function() {
      $('#Cambio').modal('show');
    })
  </script>
<?php } ?>

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
											<p class="black font-weight-bold titulo text-center">LISTA DE VENTAS A CRÉDITO APARTADO</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">                        
                                           
                                        </div>

                                        <div class="col-md-2">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
                    <div class="col-md-12">

                      <div class="row">

                        <div class="col-md-2">
                          <form method="post" action="" enctype="multipart/form-data" name="formCA" id="formCA">
                          <input class="form-control" type="text" name="noCA" id="noCA"  placeholder="No">
                        </div>
                        <div class="col-md-2">
                          <input class="form-control" type="text" name="nombreCA" id="nombreCA"  placeholder="Nombre">
                        </div>
                        <div class="col-md-2">
                          <input class="form-control" type="email" name="correoCA" id="correoCA"  placeholder="Correo">
                        </div>
                        <div class="col-md-2">
                          <input class="form-control" type="text" name="telefonoCA" id="telefonoCA"  placeholder="Telefono">
                        </div>
                        <div>
                          <select class="form-control" name="categoriaCA" id="categoriaCA">
                            <option value="" selected>TODO</option>
                                <?php 
                                $can=mysql_query("SELECT id_comision, nombre FROM comision WHERE tipo <> 'RECARGA' AND tipo <> 'FICHA' AND tipo <> 'REPARACION' AND tipo <> 'APARTADO' ");
                                while($dato=mysql_fetch_array($can)){
                                ?>
                                  <option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>
                            
                                <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-2"><br>
                          <input  type="submit" class="btn btn-primary" name="submitCA" id="submitCA" value="BUSCAR">
                          <i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>

                        </form>
                        </div>

                      </div>

                    </div>
									</div>

								</div>

							</div>

							<div class="col-md-12"><br><br>
                <div id = "listadoPrincipal"></div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  
</body>
</html>


<!-- *****************************MODAL PRODUCTOS******************************* -->




<div id="modalProductos" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">SISTEMA CREDITO / APARTADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <div id="tablaPoductos"></div>
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>


<!-- ***************************************************************************** -->
<!-- *****************************MODAL PAGOS******************************* -->




<div id="modalPagos" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">SISTEMA CREDITO / APARTADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <div id="tablaPagos"></div>
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>


<!-- ***************************************************************************** -->

<!-- *****************************MODAL ABONO******************************* -->


<div id="Apertura" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">SISTEMA CREDITO / APARTADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <p align="center" class="text-info"><strong id="cliente"></strong></p>
      <p align="center" class="text-info"><strong>Resto a Pagar</strong></p>     
      <pre style="font-size:30px; text-align:center" id="mont"><center></center></pre>
    
        
          <form id="formAbono" name="formAbono" method="POST" action="PostAbono.php">
          <p align="center" class="text-info"><strong>Fecha de Pago</strong></p>
          <input class="form-control" type="date" name="fecha" id="fecha" readonly>


          <label for="">Dinero Recibido</label>               
          <input class="form-control" type="number" name="denominacion"  step="any" id="denominacion" min="0" autocomplete="on" required/>
                   
              
            <input type="hidden" name="idventa" id="idventa">
            <input type="hidden" name="tpagar" id="tpagar">

            <input type="hidden" name="inputCliente" id="inputCliente">
            <input type="hidden" name="inputIDCliente" id="inputIDCliente">
            <input type="hidden" name="inputiccid" id="inputiccid">
            <input type="hidden" name="opcion" id="opcion" value="2">

            <label for="ccpago">Abona a Cuenta</label>
            <input class="form-control" type="number" name="ccpago" id="ccpago" onkeyup="minInput();" step="any" min="0" autocomplete="on" required />
               
            <div id="divICCID"  style="display:none">
              <label for="" class="control">ICCID</label>
              <input class="form-control" type="text" name="finaliccid" id="finaliccid" placeholder="ICCID"/>
            </div>
            
            <br>

            <input type="submit" class="btn btn-success" name="button" id="button" value="Cobrar Dinero Recibido" />
          </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>
<!-- ***************************************************************************** -->


<!-- modal muestra cambio si lo hay -->


<div id="Cambio" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">CAMBIO DEL PAGO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <p align="center" class="text-info"><strong>Cantidad cambio</strong></p>
      <pre style="font-size:30px; text-align:center" id="cambioresto"><center>$ <?php echo $_GET['cambio']; ?></center></pre>
      <input type="submit" onclick="aceptar()" class="btn btn-success" name="button" id="button" value="Aceptar" />
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>



<!-- -------------------------- modal Filtros ---------------------------------- -->

<div id="filtro" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">DETALLE DE VENTA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <table class="table" id="tablafiltro">
        </table>
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>



<!-- ******************************************************************************************************************************************** -->
<script>
$(document).ready(function() 
{
  $("#loading").show();  
  var data = $('#formCA').serialize()+ "&opcion=" + 1;
    //data.push({name: 'tag', value: 'login'});
    $.ajax({
        method: "POST",
        url: "VentasCredito2.php",
        data: data
    }).done(function(respuesta){

      $("#listadoPrincipal").html(respuesta);
      tabla();
      $("#loading").hide(); 

        });
});
</script>

<script>

$('#formCA').submit(function(e) {
  $("#loading").show(); 

    e.preventDefault();
    var data = $(this).serialize()+ "&opcion=" + 1;
    //data.push({name: 'tag', value: 'login'});
    $.ajax({
        method: "POST",
        url: "VentasCredito2.php",
        data: data
    }).done(function(respuesta){

      $("#listadoPrincipal").html(respuesta);
      tabla();
      $("#loading").hide();
        });
    
});

</script>


<script>

function verProdcutos(id)
{

  $("#tablaPoductos").html("");

  $.ajax({
    method: "POST",
    url: "VentasCredito2.php",
    data: { idCA: id, opcion: 2}

    }).done(function(respuesta){

        $("#tablaPoductos").html(respuesta);
        tablaB();
        
    });
    $('#modalProductos').modal('show');
}

</script>

<script>
function verPagos(id){

$("#tablaPagos").html("");

$.ajax({
  method: "POST",
  url: "VentasCredito2.php",
  data: { idCA: id, opcion: 3}
  })
  .done(function(respuesta){

      $("#tablaPagos").html(respuesta);
      
  });
  $('#modalPagos').modal('show');
}
</script>

<script>
function enviar(id){
    $.ajax({ 
        type: "POST", 
        url: "PostAbono.php",
        data: "id="+id+"&opcion="+1,
        success: function(msg){
        var valores = msg.split(";");
        //------------------------------
        document.getElementById('idventa').value = id;
        document.getElementById('tpagar').value = valores[0];
        //alert(valores[0]);

        $("#mont").text("$ "+valores[0]);
        document.getElementById('fecha').valueAsDate = new Date();
        $("#cliente").text("Cliente: "+valores[2]);
        $("#inputCliente").val(valores[2]);
        $("#inputIDCliente").val(valores[3]);
        $("#inputiccid").val(valores[4]);


        $('#Apertura').modal('show');
        } 
    }); 
  }


$( document ).ready(function() {

  $( "#ccpago" ).keyup(function() {
      var restante = $("#tpagar").val();
      restante = parseFloat(restante);

      var pago = $("#ccpago").val();
      pago = parseFloat(pago);

      var iccidantes = $("#inputiccid").val();
      //alert(iccidantes);

      if(iccidantes == "")
      {

         if(pago == restante){
          $("#divICCID").show();
        }else{
          $("#divICCID").hide();
        }

      }

     
  
  });
    
});






</script>


<script>
function minInput(){

$("#ccpago").removeAttr("max");

  var denominacion = $("#denominacion").val();
  denominacion = parseFloat(denominacion);
  
  var ccpago = $("#ccpago").val();
  ccpago = parseFloat(ccpago);
  
  if(denominacion < ccpago){
    //alert("ño");
      $("#ccpago").attr({"max" : denominacion});
  }else{
    $("#ccpago").removeAttr("max");
    
  }

}
</script>

<script>
        
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

<script>

// $(document).ready(function() {
//   tabla();
// } );


function tabla(){

  $('#exampleA').DataTable({
                "ordering": true,
                "language": {
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
                    }
                },
                language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
                },
               
            });

}

function tablaB(){

$('#exampleB').DataTable({
              "ordering": true,
              "language": {
                  "paginate": {
                      "previous": "<i class='mdi mdi-chevron-left'>",
                      "next": "<i class='mdi mdi-chevron-right'>"
                  }
              },
              language: {
              "decimal": "",
              "emptyTable": "No hay información",
              "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
              "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
              "infoFiltered": "(Filtrado de _MAX_ total entradas)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar _MENU_ Entradas",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscar:",
              "zeroRecords": "Sin resultados encontrados",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              }
              },
             
          });

}
       
 </script>