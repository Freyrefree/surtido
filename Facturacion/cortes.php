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
	<title>jQuery UI Datepicker - Select a Date Range</title>
	<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>    
	<script src="jquery-1.9.1.js"></script>
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
    </style>
     
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
                        /*$("#resultado").html("Procesando, espere por favor...");*/
                },
                success:  function (response) {
					//$("#resultado").html(response);
					//$( "#tabs" ).tabs({ active: 2 });
					var obj = jQuery.parseJSON(response);
					$('#subtotal').val(obj[1]);
					$('#iva').val(obj[2]);
					$('#total').val(obj[0]);
					var total = parseFloat(obj[0]);
					if(total>0){
						carga_emisor();
					}
                }
        });
		return false;
	}

 	function carga_emisor(){
 		
		 $.ajax({
				async: false,
				type: 'POST',
                url:   'dat_emisor.php',
                data: {},
               success: function(data) {
				      var json_obj = jQuery.parseJSON(data); // lo convierte a Array
				    $('#rfc_emi').val(json_obj[0]);
					$('#empresa_emi').val(json_obj[1]);
					$('#pais_emi').val(json_obj[2]);
					$('#estado_emi').val(json_obj[3]);
					$('#municipio_emi').val(json_obj[4]);
					$('#colonia_emi').val(json_obj[5]);
					$('#calle_emi').val(json_obj[6]);
					$('#cp_emi').val(json_obj[7]);
					$('#next_emi').val(json_obj[8]);
					$('#nint_emi').val(json_obj[9]);
					$('#correo_emi').val(json_obj[10]);
					$('#telefono_emi').val(json_obj[11]);
					$('#celular_emi').val(json_obj[12]);
				    },
				   error: function(data) {
				   }
				});
		return false;
	}
	

	function validaRFC(){
		var r_rfc = $('#rfc_r').val();
		var r_empresa = $('#empresa_r').val();
		var r_pais = $('#pais_r').val();
		var r_estado = $('#estado_r').val();
		var r_municipio = $('#municipio_r').val();
		var r_colonia = $('#colonia_r').val();
		var r_calle = $('#calle_r').val();
		var r_cp = $('#cp_r').val();
		var r_ext = $('#next_r').val();
		var r_int = $('#nint_r').val();
		var r_correo = $('#correo_r').val();
		var r_contacto = $('#contacto_r').val();
		var r_telefono = $('#telefono_r').val();
		var r_celular = $('#celular_r').val();
		var parametros = {rfc:r_rfc};
        $.ajax({
				async: false,
                data:  parametros,
                url:   'valida_receptor.php',
                type:  'post',
                beforeSend: function () {
                        /*$("#resultado").html("Procesando, espere por favor...");*/
                },
                success:  function (response) {
					var obj = jQuery.parseJSON(response);
					$('#empresa_r').val(obj[0]);
					$('#pais_r').val(obj[1]);
					$('#estado_r').val(obj[2]);
					$('#municipio_r').val(obj[3]);
					$('#colonia_r').val(obj[4]);
					$('#calle_r').val(obj[5]);
					$('#cp_r').val(obj[6]);
					$('#next_r').val(obj[7]);
					$('#nint_r').val(obj[8]);
					$('#correo_r').val(obj[9]);
					$('#contacto_r').val(obj[10]);
					$('#telefono_r').val(obj[11]);
					$('#celular_r').val(obj[12]);
                }
        });	
		return false;
	}	


	function factura(){
		var fecha = $('#fechaini').val();
		var folio = $('#folio').val();
		var subtotal = $('#subtotal').val();
		if(parseFloat(subtotal)<=0 || subtotal==''){
			$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">La compra no exixte, verifica fecha y folio del ticket</font>');
			return false;
		}
		var e_rfc = $('#rfc_emi').val();
		if(e_rfc.length==0){
			$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">Valida que la compra Exista.</font>');
		}
		var r_rfc = $('#rfc_r').val();
		var r_empresa = $('#empresa_r').val();
		var r_pais = $('#pais_r').val();
		var r_estado = $('#estado_r').val();
		var r_municipio = $('#municipio_r').val();
		var r_colonia = $('#colonia_r').val();
		var r_calle = $('#calle_r').val();
		var r_cp = $('#cp_r').val();
		var r_ext = $('#next_r').val();
		var r_int = $('#nint_r').val();
		var r_correo = $('#correo_r').val();
		var r_contacto = $('#contacto_r').val();
		var r_telefono = $('#telefono_r').val();
		var r_celular = $('#celular_r').val();
		if(r_rfc.length==0 || r_empresa.length==0 || r_pais.length==0 || r_estado.length==0 || r_municipio.length==0 || r_cp.length==0 ){
			if( r_rfc == ''){  $('#rfc_r').css("border", "1px solid red"); }else{  $('#rfc_r').css("border", "1px solid green");}
			if( r_empresa == ''){  $('#empresa_r').css("border", "1px solid red"); }else{  $('#empresa_r').css("border", "1px solid green");}
			if( r_pais == ''){  $('#pais_r').css("border", "1px solid red"); }else{  $('#pais_r').css("border", "1px solid green");}
			if( r_estado == ''){  $('#estado_r').css("border", "1px solid red"); }else{  $('#estado_r').css("border", "1px solid green");}
			if( r_municipio == ''){  $('#municipio_r').css("border", "1px solid red"); }else{  $('#municipio_r').css("border", "1px solid green");}
			if( r_cp == ''){  $('#cp_r').css("border", "1px solid red"); }else{  $('#cp_r').css("border", "1px solid green");}
			$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">Ingresa información de Receptor. Hay campos obligatorios vacios.</font>');
		}else{
			$('#rfc_r').css("border", "1px solid green");
			$('#empresa_r').css("border", "1px solid green");
			$('#pais_r').css("border", "1px solid green");
			$('#estado_r').css("border", "1px solid green");
			$('#municipio_r').css("border", "1px solid green");
			$('#cp_r').css("border", "1px solid green");
			crea_factura();
		}
		return false;
	}

	function crea_factura(){
		var fecha = $('#fechaini').val();
		var folio = $('#folio').val();
		var subtotal = $('#subtotal').val();
		var e_rfc = $('#rfc_emi').val();
		var r_rfc = $('#rfc_r').val();
		var r_empresa = $('#empresa_r').val();
		var r_pais = $('#pais_r').val();
		var r_estado = $('#estado_r').val();
		var r_municipio = $('#municipio_r').val();
		var r_colonia = $('#colonia_r').val();
		var r_calle = $('#calle_r').val();
		var r_cp = $('#cp_r').val();
		var r_ext = $('#next_r').val();
		var r_int = $('#nint_r').val();
		var r_correo = $('#correo_r').val();
		var r_contacto = $('#contacto_r').val();
		var r_telefono = $('#telefono_r').val();
		var r_celular = $('#celular_r').val();
		var parametros = {fecha:fecha,folio:folio,subtotal:subtotal,e_rfc:e_rfc,r_rfc:r_rfc,r_empresa:r_empresa,r_pais:r_pais,r_estado:r_estado,r_municipio:r_municipio,r_colonia:r_colonia,r_calle:r_calle,r_cp:r_cp,r_ext:r_ext,r_int:r_int,r_correo:r_correo,r_contacto:r_contacto,r_telefono:r_telefono,r_celular:r_celular};	
		 $.ajax({
				async: false,
				type: 'POST',
                url:   'facture.php',
                data: parametros,
			   beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },	
               success: function(data) {
					if(data==1){
						consulta_doc(folio);
					}else{		
					$("#resultado").html('<img src="../img/Info.png" border=0 width="40px"> <font color="red" size="3px">' + data + '</font>');	
				    $('#descarga').hide('');
				    $('#respuesta').show('');
					}
				    },
				   error: function(data) {
				   }
				});
		return false;		
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

	function consulta_doc(folio){
		$('#respuesta').hide('');
		$('#descarga').show('');
	}


	</script>
    
 
</head>
<body>
<div class="container">
  <h2>Nueva Factura</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Ticket</a></li>
    <li><a data-toggle="tab" href="#menu1">RFC EMISOR</a></li>
    <li><a data-toggle="tab" href="#menu2">RFC RECEPTOR</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active" style="height:290px">
      <h3>Compra</h3>
      <table width="100%">
      <tr>
      	<td>
      	 <p>&nbsp; &nbsp; &nbsp; &nbsp; Fecha</p>
      	 &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" id="fechaini" name="fechaini" value=""  required style="height:30px" >
		</td><td colspan="2"><p>&nbsp; &nbsp; &nbsp; &nbsp; Folio</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" id="folio" name="folio" value=""  required onchange="valida_ticket();" style="height:30px" ></td>
		 </tr>
		 <tr>
		 <td><p>&nbsp; &nbsp; &nbsp; &nbsp; Subtotal</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:26px;">$</span><input type="text" id="subtotal" name="subtotal" value="" style="height:30px" disabled="true">
		 </td><td><p>&nbsp; &nbsp; &nbsp; &nbsp; I.V.A</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:26px;">$</span><input type="text" id="iva" name="iva" value="" style="height:30px" disabled="true">
		 </td><td><p>&nbsp; &nbsp; &nbsp; &nbsp; Total</p>
		 &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:26px;">$</span><input type="text" id="total" name="total" value="" style="height:30px" disabled="true"></td>
		 </tr></table>
    </div>
    <div id="menu1" class="tab-pane fade" style="height:300px">
    	<p>
      	<table width="100%" border="0">
		  	<tr>
		    <td>
		    	<p>RFC: </p><input type="text" name="rfc_emi" id="rfc_emi" value="" style="height:30px" maxlength="15" disabled="true">
		    </td>
		    <td>	
		        <p>Empresa/Razon social: </p><input type="text" name="empresa_emi" id="empresa_emi" value="" style="height:30px" maxlength="50" disabled="true">
		    </td>
		    <td></td>
		    <td></td>
		    </tr>
		    <tr>
		    <td>    
		        <p>Pais: </p><input type="text" name="pais_emi" id="pais_emi" value="" style="height:30px" maxlength="20" disabled="true">
		    </td>
		    <td>     
		        <p>Estado: </p><input type="text" name="estado_emi" id="estado_emi" value="" style="height:30px" maxlength="30" disabled="true">
		    </td>
		    <td>     
		        <p>Municipio: </p><input type="text" name="municipio_emi" id="municipio_emi" value="" style="height:30px" maxlength="50" disabled="true">
		    </td>
		    <td>     
		        <p>Colonia: </p><input type="text" name="colonia_emi" id="colonia_emi" value="" style="height:30px" maxlength="99" disabled="true">
		    </td>
		    </tr>
		    <tr>
		    <td>     
		        <p>Calle: </p><input type="text" name="calle_emi" id="calle_emi" value="" style="height:30px" maxlength="99" disabled="true" required>
		    </td>
		    <td>     
		        <p>Codigo Postal: </p><input type="text" name="cp_emi" id="cp_emi" value="" style="height:30px" maxlength="10" disabled="true">
		    </td>
		    <td>
		    	<p>N. Ext: </p><input type="text" name="next_emi" id="next_emi" value="" style="height:30px" maxlength="10" disabled="true">
		    </td>
		    <td>      
		        <p>N. Int: </p><input type="text" name="nint_emi" id="nint_emi" value="" style="height:30px" maxlength="10" disabled="true">
		    </td>
		    </tr>
		    <tr>
		    <td>     
		        <p>Correo: </p><input type="email" name="correo_emi" id="correo_emi" value="" style="height:30px" disabled="true">
		    </td>
		    <td>     
		        <p>Contacto: </p><input type="text" name="contacto_emi" id="contacto_emi" value="" required style="height:30px" maxlength="50" disabled="true">
		    </td>
		    <td>     
		        <p>Telefono: </p><input type="text" name="telefono_emi" id="telefono_emi" value="" required style="height:30px" maxlength="10" disabled="true">
		    </td>
		    <td>     
		        <p>Celular: </p><input type="text" name="celular_emi" id="celular_emi" value="" required style="height:30px" maxlength="15" disabled="true">
		    </td>
		    </tr>
		</table>
      </p>  
    </div>
    <div id="menu2" class="tab-pane fade" style="height:300px">
      <p>
      	<table width="99%" border="0">
		  	<tr>
		    <td>
		    	<p>RFC: </p><input type="text" name="rfc_r" id="rfc_r" value="" style="height:30px" maxlength="15" onchange="validaRFC();" required>
		    </td>
		    <td>	
		        <p>Empresa/Razon social: </p><input type="text" name="empresa_r" id="empresa_r" value="" style="height:30px" maxlength="50" required>
		    </td>
		    <td></td>
		    <td></td>
		    </tr>
		    <tr>
		    <td>    
		        <p>Pais: </p><input type="text" name="pais_r" id="pais_r" value="" style="height:30px" maxlength="20" required>
		    </td>
		    <td>     
		        <p>Estado: </p><input type="text" name="estado_r" id="estado_r" value="" style="height:30px" maxlength="30" required>
		    </td>
		    <td>     
		        <p>Municipio: </p><input type="text" name="municipio_r" id="municipio_r" value="" style="height:30px" maxlength="50" required>
		    </td>
		    <td>     
		        <p>Colonia: </p><input type="text" name="colonia_r" id="colonia_r" value="" style="height:30px" maxlength="99">
		    </td>
		    </tr>
		    <tr>
		    <td>     
		        <p>Calle: </p><input type="text" name="calle_r" id="calle_r" value="" style="height:30px" maxlength="99">
		    </td>
		    <td>     
		        <p>Codigo Postal: </p><input type="text" name="cp_r" id="cp_r" value="" style="height:30px" maxlength="10" required>
		    </td>
		    <td>
		    	<p>N. Ext: </p><input type="text" name="next_r" id="next_r" value="" style="height:30px" maxlength="10">
		    </td>
		    <td>      
		        <p>N. Int: </p><input type="text" name="nint_r" id="nint_r" value="" style="height:30px" maxlength="10">
		    </td>
		    </tr>
		    <tr>
		    <td>     
		        <p>Correo: </p><input type="email" name="correo_r" id="correo_r" value="" style="height:30px" required>
		    </td>
		    <td>     
		        <p>Contacto: </p><input type="text" name="contacto_r" id="contacto_r" value="" style="height:30px" maxlength="50">
		    </td>
		    <td>     
		        <p>Telefono: </p><input type="text" name="telefono_r" id="telefono_r" value="" style="height:30px" maxlength="10">
		    </td>
		    <td>     
		        <p>Celular: </p><input type="text" name="celular_r" id="celular_r" value="" style="height:30px" maxlength="15">
		    </td>
		    </tr>
		</table>
      </p>
    </div>
  </div>
</div>
<p>

<center><table  width="80%" border="0"  align="center" >
  <tr>
  	<td  align="center">
  		<div id="respuesta"><p id="resultado"></p></div>
  		<div id="descarga" style="display:none">
  			<table width="60%">
  				<tr>
  					<td align="center" width="30%"><button class="btn btn-large btn-primary" type="submit" onclick="consulta_uuid(1);" title="DESCARGAR FACTURA EN FORMATO .PDF">DESCARGA PDF</button></td>
  					<td align="center" width="30%"><button class="btn btn-large btn-primary" type="submit" onclick="consulta_uuid(2);" title="DESCARGAR FACTURA EN FORMATO .XML">DESCARGA XML</button></td>
  					<td align="center" width="40%"><button class="btn btn-large btn-primary" type="submit" onclick="envio_emial();" title="ENVIAR COMPROBANTES POR CORREO">ENVIAR POR CORREO</button></td>
  				</tr>
  			</table>
  		</div>
  	</td>
  	<td align="right"><button class="btn btn-large btn-primary" type="submit" onclick="factura()" >Facturar</button>&nbsp; &nbsp;</td>
  </tr>
</table></center>
</p>



</body>
</html>
