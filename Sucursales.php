<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Listado Sucursales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
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

</head>
<!-- ***************************************************************************************************************************************** -->
<div id="modalExistencias" class="modal hide fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
  <div class="modal-header" id="modalExistenciashead">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="">Detalle Productos</h3>
  </div>
  <div class="modal-body">
  <style type="text/css">
        #existenciastbl {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 12px;

        }
        
        #existenciastbl td, #existenciastbl th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #existenciastbl td.a {
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }

        
        #existenciastbl th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }
      </style>
    <center><div id="modalExistenciasmsgg"></div></center>
    <center><div id="modalExistenciasmsg"></div></center>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
  </div>
  </div>
</div>
<!-- ************************************************************************************************************ -->
<!-- ************************* -->
<div class="modal fade bd-example-modal-sm" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header" id="modalConfirmarhead">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="">Detalle Productos</h3>
    </div>
    <div class="modal-body">
      <center><div id="msgConfirmar"><div/></center>
    </div>
    <div class="modal-footer">
      <button class="btn" id="btnConfirmar" onclick="confirmar(this.value)" data-dismiss="modal" aria-hidden="true">Aceptar</button>
    </div>
    </div>
  </div>
</div>
<!-- ************************* -->
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
    <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='AgregarSucursal.php'">Ingresar Nuevo</button>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center" id="tablaSucursales"></div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){

  $.ajax({
      method:"POST",
      url:"listaSucursales.php",
      data: {}
    }).done(function(respuesta){
      $("#tablaSucursales").html(respuesta);
    })

});

function eliminarSucursal(id)
{
  var contador = 0;
  var table = "<table id='existenciastbl'><tr><th>Codigo Producto</th><th>Nombre Producto</th><th>Existencias</th></tr>";
  //alert(id);
  $.ajax({
      method:"POST",
      url:"eliminarSucursal.php",
      dataType: "json",      
      data: {id_sucursal : id , opc : 1},
    }).done(function(respuesta){
      if(respuesta != 1)
      {

        $.each(respuesta, function(key, item) {
        contador++;
        table += "<tr><td>"+ item.id_producto +"</td><td>"+ item.nombre_producto +"</td><td>"+ item.cantidad +"</td></tr>";
        });

        $("#modalExistenciasmsgg").html("No se puede eliminar, hay productos con existencias en esa sucursal. Se presentan a continuación:");
        $("#modalExistenciasmsg").html(table);
        $("#modalExistenciashead").css({"background-color":"#d9534f","color":"white"});
        $('#modalExistencias').modal('show');
      }else{
        //alert(respuesta);
        $("#msgConfirmar").html("¿Está seguro que desea eliminar la sucursal?")
        $("#btnConfirmar").val(id);
        $("#modalConfirmarhead").css({"background-color":"#d9534f","color":"white"});        
        $('#modalConfirmar').modal('show');
      }

    })
}
function confirmar(id)
{
  //alert(id);
  $.ajax({
    method: "POST",
    url: "eliminarSucursal.php",
    data: { id_sucursal : id, opc : 2 }
    }).done(function(respuesta) {
        //alert( "Data Saved: " + msg );
        if(respuesta == 1)
        {
          location.href = "Sucursales.php";
        }
    });
}
</script>