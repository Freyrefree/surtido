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
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script>
	 $.datepicker.regional['es'] = {
	 closeText: 'Cerrar',
	 prevText: '<Ant',
	 nextText: 'Sig>',
	 currentText: 'Hoy',
	 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	 weekHeader: 'Sm',
	 dateFormat: 'dd/mm/yy',
	 firstDay: 1,
	 isRTL: false,
	 showMonthAfterYear: false,
	 yearSuffix: ''
	 };
	 $.datepicker.setDefaults($.datepicker.regional['es']);
	$(function () {
	$("#fecha").datepicker();
	});
	</script>
	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        $.ajax({
          type:'post', 
          url:'consulta_timbres.php',
        }).done(function(result){
          var json =  $.parseJSON(result);
          var data = google.visualization.arrayToDataTable([
          ['Concepto', 'Timbres'],	
          ['Timbres Consumidos',  parseInt(json[0])],
          ['Timbres Disponibles',  parseInt(json[1])],
          ['Timbres Nuevos',  parseInt(json[2])]
        ]);
          var options = {
          title: 'CONSUMOS'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);

          }); 
      }
    </script>
	<style type="text/css">
	body{
		font-family: "Trebuchet MS", Arial, Helvetica, Verdana, sans-serif;
		background-color: #FFF;
	}
	div.ui-datepicker{
	 font-size:90%;
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
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			dateFormat: 'yy-mm-dd',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				$( "#fechaini" ).datepicker( "option", "maxDate", selectedDate );
			}
		});

	});
	
	function consulta(){
		var fi = $('#fechaini').val();
		var ff = $('#to').val();
		$.ajax({
			type: 'POST',
			data: {fi:fi,ff:ff},
			url: 'historico_timbres.php',
		}).done(function(data){
			$("#tabla").html(data);
		
		});
	}
	</script>
    
 
</head>
<body>
<div class="container">
  <h2>Timbres</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Detalle</a></li>										
    <li><a data-toggle="tab" href="#menu1">Consulta de consumos</a></li>									
  </ul>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active" style="height:290px">
      	<div id="piechart" style="width: 700px; height: 360px;"></div>
    </div>
     <div id="menu1" class="tab-pane fade" style="height:300px">
     <br>
     		Fecha Inicial <input type="text" name="fechaini" id="fechaini"> &nbsp; 
     		Fecha Final <input type="text" name="to" id="to" > &nbsp; &nbsp;
     		<button class="btn btn-large btn-primary" type="submit" onclick="consulta()" >Consultar</button>
     <br><br><p>
     	<center>
     		<div id="tabla"></div>
     	</center>
     </p>		
     </div>
  </div>

</div>




</body>
</html>
