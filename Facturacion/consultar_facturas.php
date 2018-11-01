<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		include("../MPDF/mpdf.php");
    	$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Consulta Facturas</title>
	<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>  
	<script src="tests/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.datepicker.js"></script>
	<script src="ui/jquery.ui.button.js"></script>
	<script src="../js/bootstrap-button.js"></script>
	<style type="text/css">
	body{
		font-family: "Trebuchet MS", Arial, Helvetica, Verdana, sans-serif;
		background-color: #FFF;
	}
	input{
		    height: 30px;
		    border: 1px solid #cccccc;
		    border-radius: 4px;
		    width: 206px;
		    padding: 1px 0px;
		    font-family: inherit;
	}
    </style>
     <script type="text/javascript">
     	$(function () {
  		$('[data-toggle="tooltip"]').tooltip('show')
	});
     </script>
	<script>

	$(function() {
		$( "input[type=submit], a, button" )
			.button()
			.click(function( event ) {
				event.preventDefault();
			});
	});
	
	$(function() {
		$( "#fechaini" ).datepicker({
			dateFormat: 'yy-mm-dd',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				$( "#fechaini" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

	});

	
	
	function valida_ticket(){
		//var rfc = $('#rfc').val();
		var fecha = $('#fechaini').val();
		var folio = $('#folio').val();
		var parametros = {fecha:fecha, folio:folio};
        $.ajax({
                data:  parametros,
                url:   'valida_ticket.php',
                type:  'post',
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					//$("#resultado").html(response);
					//$( "#tabs" ).tabs({ active: 2 });
					var obj = jQuery.parseJSON(response);
					$('#subtotal').val(obj[1]);
					$('#iva').val(obj[2]);
					$('#total').val(obj[0]);
					var total = obj[0];
					if(parseFloat(total)<=0 || total==''){
						$('#respuesta').show('');
						$('#descarga').hide('');
						$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">La compra no exixte, verifica fecha y folio del ticket</font>');
						return false;
					}else{
						factura()
					}
                }
        });
		return false;
	}
	




	function factura(){
		var fecha = $('#fechaini').val();
		var folio = $('#folio').val();
		var subtotal = $('#subtotal').val();
		if(parseFloat(subtotal)<=0 || subtotal==''){
			$('#respuesta').show('');
			$('#descarga').hide('');
			$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">La compra no exixte, verifica fecha y folio del ticket</font>');
			return false;
		}else{
			consulta_pdf();
			consulta_doc(folio);
		}
		return false;
	}

	function consulta_pdf(){
		var folio = $('#folio').val();
		var parametros = {folio:folio};
		 $.ajax({
				async: false,
				data: parametros,
				type: 'POST',
                url:   'consulta_folio.php',
               success: function(data) {
					
					var ruta = 'comprobantes/' + data + '.pdf';
					$('#ver_pdf').attr("data", ruta);
					
				    },
				   error: function(data) {
				   }
				});
	}

	function consulta_uuid(op){
		var folio = $('#folio').val();
		var parametros = {folio:folio};
		 $.ajax({
				async: false,
				data: parametros,
				type: 'POST',
                url:   'consulta_folio.php',
               success: function(data) {
					if(data==''){
						$('#respuesta').show('');
						$('#descarga').hide('');
						$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">La factura no existe</font>');
						return false;
					}
					
					if(op==1)
					ruta = 'comprobantes/' + data + '.pdf';
					if(op==2)
					ruta = 'comprobantes/' + data + '.xml';
					document.location = "download.php?a="+ ruta;
				    },
				   error: function(data) {
				   }
				});
	}

	function cancelar_factura(){
		var folio = $('#folio').val();
		var parametros = {folio:folio};
		 $.ajax({
				async: false,
				data: parametros,
				type: 'POST',
                url:   'consulta_folio.php',
               success: function(data) {
					if(data==''){
						$('#respuesta').show('');
						$('#descarga').hide('');
						$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">La factura no existe</font>');
						return false;
					}else{
						 $("#respuesta_folio").html('<font color="red" size="3px">¿Cancelar la factura con folio fiscal? </font><br> <h4>'+ data +'</h4>');
					}
				    },
				   error: function(data) {
				   }
				});
	}

	function consulta_doc(folio){
		$('#respuesta').hide('');
		$('#descarga').show('');
	}

	function cancelar(){
		var folio = $('#folio').val();
		var parametros = {folio:folio};
		 $.ajax({
				async: false,
				data: parametros,
				type: 'POST',
                url:   'cancelar_factura.php',
			   beforeSend: function () {
                        $("#respuesta_folio").html("Cancelación en proceso, espere por favor...");
                },	
               success: function(data) {
					// $('#myModal').modal(toggle)
				document.getElementById("cerrar").click()
				$('#respuesta').show('');
				$('#descarga').hide('');
				$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="green" size="3px">'+ data +'</font>');
				    },
				   error: function(data) {
				   }
				});
	}

	function envio_email(){
		var folio = $('#folio').val();
		if(folio.length>0){
			$('#respuesta').show('');
			$('#descarga').hide('');
		}
		var parametros = {folio:folio};
		 $.ajax({
				async: false,
				data: parametros,
				type: 'POST',
                url:   'correos.php',
				beforeSend: function () {
                        $("#resultado").html("Envio de comprobantes en proceso, espere por favor...");
                },	
               success: function(data) {
						$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="green" size="3px">Envio de información a correo electronico</font>');	
				    },
				   error: function(data) {
				   }
				});
	}

	</script>
    
 
</head>
<body>
<div class="container">
  <h2>Consultar y Cancelar Facturas</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Ticket</a></li>										
    <li><a data-toggle="tab" href="#menu1">PDF</a></li>									
  </ul>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active" style="height:290px">
      <h3>Compra</h3>
      <table width="100%">
      <tr>
      	<td><p>&nbsp; &nbsp; &nbsp; &nbsp; Folio</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" id="folio" name="folio" value=""  required onchange="valida_ticket();" style="height:30px" ></td>
      	<td colspan="2">
      	 <p>&nbsp; &nbsp; &nbsp; &nbsp; </p>
      	 &nbsp; &nbsp; &nbsp; &nbsp;<div style="display:none"> <input type="text" id="fechaini" name="fechaini" value=""  required style="height:30px"></div>
		</td>
		 </tr>
		 <tr>
		 <td><br><p>&nbsp; &nbsp; &nbsp; &nbsp; Subtotal</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:26px;">$</span><input type="text" id="subtotal" name="subtotal" value="" style="height:30px" disabled="true">
		 </td><td><br><p>&nbsp; &nbsp; &nbsp; &nbsp; I.V.A</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:26px;">$</span><input type="text" id="iva" name="iva" value="" style="height:30px" disabled="true">
		 </td><td><br><p>&nbsp; &nbsp; &nbsp; &nbsp; Total</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:26px;">$</span><input type="text" id="total" name="total" value="" style="height:30px" disabled="true"></td>
		 </tr></table>
    </div>
     <div id="menu1" class="tab-pane fade" style="height:300px">
     	<object id="ver_pdf" data="" name="ver_pdf" type="application/pdf" width="100%" height="100%"></object> 
     </div>
  </div>
  <!-- Modal -->
  <!--<div class="modal fade" id="myModal" role="dialog" style="width:140%;height:140%;top:-5px;opacity: 0.4;">-->
  <div class="modal fade" id="myModal" role="dialog" >
      <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">CANCELAR FACTURA</h4>
      </div>
      <div class="modal-body">
        <center><p id="respuesta_folio"></p></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="cancelar()" >Aceptar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div>
  <p>
<center><table  width="80%" border="0"  align="center" >
  <tr>
  	<td  align="center">
  		<div id="respuesta"><p id="resultado"></p></div>
  		<div id="descarga" style="display:none">
  			<table width="75%">
  				<tr>
  					<td align="center" width="22%"><button class="btn btn-large btn-primary" type="button" onclick="consulta_uuid(1);" data-toggle="tooltip" data-placement="top" title="DESCARGAR FACTURA EN FORMATO .PDF">DESCARGA PDF</button></td>
  					<td align="center" width="22%"><button class="btn btn-large btn-primary" type="button" onclick="consulta_uuid(2);" title="DESCARGAR FACTURA EN FORMATO .XML">DESCARGA XML</button></td>
  					<td align="center" width="28%"><button class="btn btn-large btn-primary" type="button" onclick="envio_email();" title="ENVIAR COMPROBANTES POR CORREO">ENVIAR POR CORREO</button></td>
  					<td align="center" width="28%"><button class="btn btn-large btn-primary" type="button" onclick="cancelar_factura();" title="CANCELAR FACTURA"  data-toggle="modal" data-target="#myModal">CANCELAR FACTURA</button></td>
  				</tr>
  			</table>
  		</div>
  	</td>
  	<td align="right"><button class="btn btn-large btn-primary" type="submit" onclick="factura()" >Consultar</button>&nbsp; &nbsp;</td>
  </tr>
</table></center>
</p>

</div>




</body>
</html>
