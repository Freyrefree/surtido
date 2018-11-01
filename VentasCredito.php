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
    <meta charset="utf-8">
    <title>Listado Ventas a Credito</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="css/tbl.css">

    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
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

<table width="100%" border="0" align="center" class="table">
  <tr class="info">
    <td><center><strong>Lista de ventas a Crédito/Apartado</center></strong></td>
  </tr>
</table>

<table width="100%" border="0" class="table">
  <form method="post" action="" enctype="multipart/form-data" name="formCA" id="formCA">
      <tr class="info">
      
            <td><center><strong>No</strong></center></td>
            <td><center><strong>Nombre</strong></center></td>
            <td><center><strong>Correo</strong></center></td>
            <td><center><strong>Telefono</strong></center></td>
            <td><center><strong>Tipo Producto</strong></center></td>
            <td><center><strong>Buscar</strong></center></td>
      </tr >

      <tr class="info">
        <td>      
          <input  type="text" name="noCA" id="noCA"  placeholder="No">      
        </td>
        <td>
          <input  type="text" name="nombreCA" id="nombreCA"  placeholder="Nombre">
        </td>
        <td>
          <input  type="email" name="correoCA" id="correoCA"  placeholder="Correo">
        </td>
        <td>
          <input  type="text" name="telefonoCA" id="telefonoCA"  placeholder="Telefono">
        </td>
        <td>

          <select name="categoriaCA" id="categoriaCA">
            <option value="" selected>TODO</option>
                  <?php 
                  $can=mysql_query("SELECT id_comision, nombre FROM comision WHERE tipo <> 'RECARGA' AND tipo <> 'FICHA' AND tipo <> 'REPARACION' AND tipo <> 'APARTADO' ");
                  while($dato=mysql_fetch_array($can)){
                  ?>
                    <option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>
              
                  <?php } ?>
          </select>

        </td>
        <td>
          <input  type="submit" class="btn btn-info" name="submitCA" id="submitCA" value="BUSCAR">
        </td>
      </tr>

  </form>
</table>

<table width="50%" align="center">
  <tr>
    <td><p><div id = "listadoPrincipal"></div></div></p></td>
  </tr>
</table>




<!-- *****************************MODAL PRODUCTOS******************************* -->


<div id="modalProductos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">SISTEMA CREDITO / APARTADO</h4>
      </div>
      <div class="modal-body">
        <div id="tablaPoductos"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- ***************************************************************************** -->
<!-- *****************************MODAL PAGOS******************************* -->


<div id="modalPagos" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">SISTEMA CREDITO / APARTADO</h4>
      </div>
      <div class="modal-body">
        <div id="tablaPagos"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- ***************************************************************************** -->

<!-- *****************************MODAL ABONO******************************* -->
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
          <form id="formAbono" name="formAbono" method="POST" action="PostAbono.php">
          <p align="center" class="text-info"><strong>Fecha de Pago</strong></p>
          <input type="date" name="fecha" id="fecha" readonly>


          <label for="">Dinero Recibido</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="denominacion"  step="any" id="denominacion" min="0" autocomplete="on" required/>
                    <span class="add-on">.00</span>
                </div>



            <label for="ccpago">Abona a Cuenta</label>
            <input type="hidden" name="idventa" id="idventa">
            <input type="hidden" name="tpagar" id="tpagar">

            <input type="hidden" name="inputCliente" id="inputCliente">
            <input type="hidden" name="inputIDCliente" id="inputIDCliente">
            <input type="hidden" name="inputiccid" id="inputiccid">
            <input type="hidden" name="opcion" id="opcion" value="2">

            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="number" name="ccpago" id="ccpago" onkeyup="minInput();" step="any" min="0" autocomplete="on" required />
                <span class="add-on">.00</span>
            </div>

            <div id="divICCID"  style="display:none">
              <label for="" class="control">ICCID</label>
              <input type="text" name="finaliccid" id="finaliccid" placeholder="ICCID"/>
            </div>
            
            
            <br>



            <input type="submit" class="btn btn-success" name="button" id="button" value="Cobrar Dinero Recibido" />
          </form>
        </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- ***************************************************************************** -->


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


<!-- ******************************************************************************************************************************************** -->
<script>
$(document).ready(function() 
{  
  var data = $('#formCA').serialize()+ "&opcion=" + 1;
    //data.push({name: 'tag', value: 'login'});
    $.ajax({
        method: "POST",
        url: "VentasCredito2.php",
        data: data
    }).done(function(respuesta){

      $("#listadoPrincipal").html(respuesta);

        });
});
</script>

<script>

$('#formCA').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize()+ "&opcion=" + 1;
    //data.push({name: 'tag', value: 'login'});
    $.ajax({
        method: "POST",
        url: "VentasCredito2.php",
        data: data
    }).done(function(respuesta){

      $("#listadoPrincipal").html(respuesta);

        });
    
});

</script>


<script>

function verProdcutos(id){

  $("#tablaPoductos").html("");

  $.ajax({
    method: "POST",
    url: "VentasCredito2.php",
    data: { idCA: id, opcion: 2}
    })
    .done(function(respuesta){

        $("#tablaPoductos").html(respuesta);
        
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