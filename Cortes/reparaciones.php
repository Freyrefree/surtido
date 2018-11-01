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
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Mi Corte</title>
	<link rel="stylesheet" href="themes/base/jquery.ui.all.css">


 
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>    
	<script src="jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.datepicker.js"></script>
    <script src="ui/jquery.ui.button.js"></script>
    
	<link rel="stylesheet" href="demos/demos.css">


    	<link rel="stylesheet" href="themes/base/jquery.ui.all.css">

	<style type="text/css">





    
	body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, Verdana, sans-serif;
}
body {
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
		$( "#fechainicio" ).datepicker({
			// defaultDate: "+1w",
			changeMonth: true,
			// numberOfMonths: 2,
			onClose: function( selectedDate ) {
			}
		});
		$( "#fechafin" ).datepicker({
			// defaultDate: "+1w",
			changeMonth: true,
			// numberOfMonths: 2,
			onClose: function( selectedDate ) {
			}
		});

        //fecha entrada
        $( "#fechainicioen" ).datepicker({
			// defaultDate: "+1w",
			changeMonth: true,
			// numberOfMonths: 2,
			onClose: function( selectedDate ) {
			}
		});
		$( "#fechafinen" ).datepicker({
			// defaultDate: "+1w",
			changeMonth: true,
			// numberOfMonths: 2,
			onClose: function( selectedDate ) {
			}
		});
	});


function corteReparaciones(){
    //Usuario
    var cajero = document.getElementById("seccion").value;
    //alert(cajero);

    var fecha_ini = document.getElementById("fechainicio").value;
    var mes = fecha_ini.substring(0,2);
    var dia = fecha_ini.substring(3,5);
    var ano = fecha_ini.substring(6,10);
    var divide = "-";
    var fecha_i = ano + divide +  mes + divide + dia;
     
	var fecha_fin = document.getElementById("fechafin").value;	
	var mes1 = fecha_fin.substring(0,2);
    var dia1 = fecha_fin.substring(3,5);
	var ano1 = fecha_fin.substring(6,10);
   	var divide1 = "-";
    var fecha_f = ano1 + divide1 +  mes1 + divide1 + dia1;
//fecha entrada

    var fecha_inien = document.getElementById("fechainicioen").value;
    var mesen = fecha_inien.substring(0,2);
    var diaen = fecha_inien.substring(3,5);
    var anoen = fecha_inien.substring(6,10);
    var divideen = "-";
    var fecha_ien = anoen + divideen +  mesen + divideen + diaen;
     
	var fecha_finen = document.getElementById("fechafinen").value;	
	var mes1en = fecha_finen.substring(0,2);
    var dia1en = fecha_finen.substring(3,5);
	var ano1en = fecha_finen.substring(6,10);
   	var divide1en = "-";
    var fecha_fen = ano1en + divide1en +  mes1en + divide1en + dia1en;



    $.ajax({
        method: "POST",
        url: "listaReparacionesCorte.php",
        data: { fechainicio: fecha_i, fechafin: fecha_f,fechainicioen: fecha_ien, fechafinen: fecha_fen, cajero: cajero}
        })
        .done(function(respuesta) {
					$("#recargado").html(respuesta);
        });
}

function consultaPDFMiCorte(){

var fecha_ini = document.getElementById("fechainicio").value;
var mes = fecha_ini.substring(0,2);
var dia = fecha_ini.substring(3,5);
var ano = fecha_ini.substring(6,10);
var divide = "-";
var fecha_i = ano + divide +  mes + divide + dia;
 
var fecha_fin = document.getElementById("fechafin").value;	
var mes1 = fecha_fin.substring(0,2);
var dia1 = fecha_fin.substring(3,5);
var ano1 = fecha_fin.substring(6,10);
 var divide1 = "-";
var fecha_f = ano1 + divide1 +  mes1 + divide1 + dia1;


window.location.href = "PDFmiCorte.php?fechainicio=" + fecha_i + "&fechafin=" + fecha_f;
}
	
	
</script> 
</head>

<body><table width="100%" border="0" align="center" class="ui-widget-content ui-widget-header">
  <tr>
    <td align="center" style="font-size:14px">Ventas Por Caja</td>
  </tr>
</table>
<p>
<table width="90%" border="0"  align="center">
  <tr>

    <td width="60%" height="19" align="center" class="ui-widget-content ui-corner-all"> <img src="../img/calendar_view_month.png" width="32" height="32"> Fecha Entrada </td>

    <td width="60%" height="19" align="center" class="ui-widget-content ui-corner-all"> <img src="../img/calendar_view_month.png" width="32" height="32"> Fecha Entrega </td>

    <td width="37%" align="center" class="ui-widget-content ui-corner-all"><img src="../img/user_orange.png" width="32" height="32"> Selecciona Cajero</td>

    <td width="37%" align="center" class="ui-widget-content ui-corner-all"><a href="#" onClick="corteReparaciones();" ><img src="../img/report.png" width="32" height="32">Consultar</a></td>
  </tr>
  
  <tr>
    <td width="20%" height="48"  class="ui-widget-content ui-state-hover">Desde
		<input type="text" id="fechainicioen" name="fechainicioen" value=""/>
		<label for="fechafin">hasta</label>
		<input type="text" id="fechafinen" name="fechafinen" value=""/>
	</td>

    <td width="20%" height="48"  class="ui-widget-content ui-state-hover">Desde
		<input type="text" id="fechainicio" name="fechainicio" value=""/>
		<label for="fechafin">hasta</label>
		<input type="text" id="fechafin" name="fechafin" value=""/>
	</td>
    <td width="20%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
            <select name="seccion" id="seccion">
            <?php 
				$can=mysql_query("SELECT * FROM usuarios where tipo='a' or tipo='ca' ");
				while($dato=mysql_fetch_array($can)){
					
			?>
              <option value="<?php echo $dato['usu']; ?>" <?php if($seccion==$dato['usu']){ echo 'selected'; } ?>><?php echo $dato['usu']; ?></option>
            <?php } ?>
            <option value="" selected>Todos </option>
            </select>
    </td>            
             <!-- <td width="37%"  class="ui-widget-content ui-state-hover" align="center"><a href="#" id="cmd" onClick="consultaPDFMiCorte();" ><img src="../img/file_extension_pdf.png" width="32" height="32"> Exportar</a></td> -->
  </tr>
  <tr>
  	<p id="resultado"></p>
  </tr>
</table>
<center><table width="85%" border="0" align="ceneter">
  <tr>
    <td><p><div id="recargado"></div></p></td>
  </tr>
</table></center>



</body>
</html>
