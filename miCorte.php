<?php

include_once 'APP/config.php';
		// session_start();
		$usu=$_SESSION['username'];
		include('php_conexion.php'); 
		
		//include("MPDF/mpdf.php");
		//$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
		
		#fecha para input
		$hoy = date("Y-m-d H:i:s");
		$fechaInput = date("m/d/Y", strtotime($hoy));
		###
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Corte del Día</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<!-- DATA TABLE -->
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
											<p class="black font-weight-bold titulo text-center">CORTE DIARIO</p>
										</div>
									</div>

                                    <div class="row">


									<div class="col-md-3">

																				
										<i class="fa fa-calendar" aria-hidden="true"></i>Selecciona Fecha

										<div class="row">
											<div class="col">
												<label for="" class="col-form-label">Desde</label>
												<input class="form-control form-control-sm" type="text" id="fechaini" name="fechaini" value="<?php echo $fechaInput; ?>" >
											</div>

											<div class="col">
												<label for="" class="col-form-label">Hasta</label>
												<input class="form-control form-control-sm" type="text" id="to" name="to" value="<?php echo $fechaInput; ?>" >
											</div>
										</div>

									</div>

                                        <div class="col-md-3">                        
                                       
                                        
                                        </div>

                                        <div class="col-md-6">

											<!-- <a href="" onClick="pdfcorte();" class="red"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a> -->
											<button type="button" class="btn btn-primary" onClick="consultacortes();" >Consultar</button>
												<i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>
                                          
                                        </div>

                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">
										<div id="totalComisiones"></div>
										<div id="recargado"></div>
                      

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




	<script>
	// $(function() {
	// 	$( "input[type=submit], a, button" )
	// 		.button()
	// 		.click(function( event ) {
	// 			event.preventDefault();
	// 		});
	// });
	

	
	
	function consultacortes(){
		$("#loading").show();
		$("#recargado").html('');
		$("#totalComisiones").html('');

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

		// $.post("Cortes/reportecorte.php", 
		// {fecha_ini11: fecha_i, 
		// fecha_fin11: fecha_f,
		// cajero: cajero,
		// //producto: producto,
		// categoria: categoria,
		// coincidencia: coincidencia,
		// codigo:codigo},
		// function(data){		
		// $("#recargado").html(data);
		
		// });	

		$.ajax({
		method: "POST",
		url: "Cortes/reportecorte.php",
		dataType: "json",
		data: {fecha_ini11: fecha_i,fecha_fin11: fecha_f,cajero: cajero,categoria: categoria,coincidencia: coincidencia,codigo: codigo},
    }).done(function(respuesta) {

		if(respuesta.length>0){

			//console.log(respuesta);

		$.each(respuesta, function(key, item) {

$("#recargado").html(item.codigohtml);
$("#totalComisiones").html(item.codigohtmlB);
tabla();

});



		}

		
    });



	}
	$("#loading").hide();	
}


	
	</script>

<script>

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


function pdfcorte(){

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

	var cajero       = ""
	//var producto     = document.getElementById("product").value;
	var categoria    = ""
	var codigo       = ""
	var coincidencia = ""


	var f1 = $("#fechaini").val();
	var f2 = $("#to").val();

	if(f1 == "" && f2 != ""){
		$("#fechaini").css("border-color", "red");
	}else if(f1 != "" && f2 == ""){
		$("#to").css("border-color", "red");

	}else{
		$("#fechaini").css("border-color", "");
		$("#to").css("border-color", "");
		//window.location = 'PDFreportecorte.php?fecha_ini11='+fecha_i+'&fecha_fin11='+fecha_f+'&cajero='+cajero+'&codigo='+codigo+'&coincidencia='+coincidencia+'&categoria='+categoria;
		window.open('PDFmiCorte.php?fecha_ini11='+fecha_i+'&fecha_fin11='+fecha_f+'&cajero='+cajero+'&codigo='+codigo+'&coincidencia='+coincidencia+'&categoria='+categoria,'_blank');
	}

}


</script>

<script>
function tabla(){

  $('#example').DataTable({
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