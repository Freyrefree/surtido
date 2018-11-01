<?php
		session_start();
		$usu=$_SESSION['username'];
		include('php_conexion.php'); 
		
		include("MPDF/mpdf.php");
		$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
		
		#fecha para input
		$hoy = date("Y-m-d H:i:s");
		$fechaInput = date("m/d/Y", strtotime($hoy));
		###
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Corte del Día</title>

	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="Cortes/themes/base/jquery.ui.all.css">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>    
	<script src="Cortes/jquery-1.9.1.js"></script>
	<script src="Cortes/ui/jquery.ui.core.js"></script>
	<script src="Cortes/ui/jquery.ui.widget.js"></script>
	<script src="Cortes/ui/jquery.ui.datepicker.js"></script>
    <script src="Cortes/ui/jquery.ui.button.js"></script>
	<link rel="stylesheet" href="Cortes/demos/demos.css">
	
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
		$( "#fechaini" ).datepicker({
			//defaultDate: "+1w",
			//changeMonth: true,
			//numberOfMonths: 2,
			onClose: function( selectedDate ) {
			}
		});
		$( "#to" ).datepicker({
			//defaultDate: "+1w",
			//changeMonth: true,
			//numberOfMonths: 2,
			onClose: function( selectedDate ) {
			}
		});
	});
	
	
	function consultacortes(){

	var fecha_ini = document.getElementById("fechaini").value;

    var mes = fecha_ini.substring(0,2);
    var dia = fecha_ini.substring(3,5);
    var ano = fecha_ini.substring(6,10);
        var divide = "-"
            var fecha_i = ano + divide +  mes + divide + dia;
     
	var fecha_fin = document.getElementById("to").value;
	
	var mes1 = fecha_fin.substring(0,2);
    var dia1 = fecha_fin.substring(3,5);
	var ano1 = fecha_fin.substring(6,10);
   	var divide1 = "-"
    var fecha_f = ano1 + divide +  mes1 + divide + dia1;

	var cajero       = "<?php echo $usu; ?>";
	var categoria    = "";
	var codigo       = "";
	var coincidencia = "";
	

	var f1 = $("#fechaini").val();
	var f2 = $("#to").val();

	if(f1 == "" && f2 != ""){
		$("#fechaini").css("border-color", "red");
	}else if(f1 != "" && f2 == ""){
		$("#to").css("border-color", "red");

	}else{
		$("#fechaini").css("border-color", "");
		$("#to").css("border-color", "");

		$.post("Cortes/reportecorte.php", 
		{fecha_ini11: fecha_i, 
		fecha_fin11: fecha_f,
		cajero: cajero,
		//producto: producto,
		categoria: categoria,
		coincidencia: coincidencia,
		codigo:codigo},
		function(data){		
		$("#recargado").html(data);
		//alert("j");
		});	
	}		
}


	
	</script>
    
 
</head>
<body><table width="100%" border="0" align="center" class="ui-widget-content ui-widget-header">
  <tr>
    <td align="center" style="font-size:14px">Cosulta Corte de Ventas</td>
  </tr>
</table>
<p>
<table width="90%" border="0"  align="center">
  <tr>
    <td width="60%" height="19" align="center" class="ui-widget-content ui-corner-all"> <img src="img/calendar_view_month.png" width="32" height="32"> Selecciona Fecha</td>
    <td width="37%" align="center" class="ui-widget-content ui-corner-all"><a href="#" onClick="consultacortes();" ><img src="img/report.png" width="32" height="32">Consultar</a></td>
  </tr>
  
  <tr>
    <td width="60%" height="48"  class="ui-widget-content ui-state-hover">Desde
		<input type="text" id="fechaini" name="fechaini" value="<?php echo $fechaInput; ?>"/>
		<label for="to">hasta</label>
		<input type="text" id="to" name="to" value="<?php echo $fechaInput; ?>"/>
	</td>

    
            
    <td width="37%"  class="ui-widget-content ui-state-hover" align="center"><a href="#" id="cmd" onClick="pdfcorte();" ><img src="img/file_extension_pdf.png" width="32" height="32"> Exportar</a></td>
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

<script>
$( document ).ready(function() {

	
    

});
</script>





<script>
// function consultaPDFMiCorte(){

// var fecha_ini = document.getElementById("fechainicio").value;
// var mes = fecha_ini.substring(0,2);
// var dia = fecha_ini.substring(3,5);
// var ano = fecha_ini.substring(6,10);
// var divide = "-";
// var fecha_i = ano + divide +  mes + divide + dia;
 
// var fecha_fin = document.getElementById("fechafin").value;	
// var mes1 = fecha_fin.substring(0,2);
// var dia1 = fecha_fin.substring(3,5);
// var ano1 = fecha_fin.substring(6,10);
//  var divide1 = "-";
// var fecha_f = ano1 + divide1 +  mes1 + divide1 + dia1;

// // $.ajax({
// //         method: "POST",
// //         url: "PDFmiCorte.php",
// //         data: { fechainicio: fecha_i, fechafin: fecha_f}
// //         })
// //         .done(function(respuesta) {
// // 					//$("#recargado").html(respuesta);
// //         });

// window.location.href = "PDFmiCorte.php?fechainicio=" + fecha_i + "&fechafin=" + fecha_f;
// }
</script>