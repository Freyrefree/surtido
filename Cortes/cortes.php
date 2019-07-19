<?php
include_once '../APP/config.php';

//error_reporting(0);
include('../php_conexion.php');
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
	header('location:error.php');
}

#fecha para input
$hoy = date("Y-m-d H:i:s");
$fechaInput = date("m/d/Y", strtotime($hoy));
###

?>
<!doctype html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../img/ICONO2.ico" type="image/vnd.microsoft.icon" />
<title>Inicio</title>
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="../jsV2/tether.min.js"></script>
<script src="../jsV2/jquery-1.11.3.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

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
<body>

	<?php include_once "../layout.php"; ?>

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
											<p class="black font-weight-bold titulo text-center">Cosulta Corte de Ventas</p>
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

										<div class="col-md-1">
											
											<i class="fa fa-file-text-o" aria-hidden="true"></i>

											<div class="row">
												<div class="col">
													<label for="" class="col-form-label">Factura</label>


													<input class="form-control form-control-sm" type="text" id="codigo" name="codigo" size="7" >

												</div>
											</div>

										</div>

										<div class="col-md-2">
											
											<i class="fa fa-search" aria-hidden="true"></i>
											<div class="row">
												<div class="col">
													<label for="" class="col-form-label">Coincidencias</label>
													<input class="form-control form-control-sm" type="text" id="coincidencia" name="coincidencia" >
												</div>
											</div>

										</div>

										<div class="col-md-2">
										<i class="fa fa-user" aria-hidden="true"></i>
											<div class="row">
												<div class="col">
													<label for="" class="col-form-label">Cajero</label>

													<select class="form-control form-control-sm"  id="seccion" name="seccion">
													<?php
													$can=mysql_query("SELECT * FROM usuarios where tipo='a' or tipo='ca' or tipo='su' or tipo='te'");
													while($dato=mysql_fetch_array($can)){
													?>
													<option value="<?php echo $dato['usu']; ?>" <?php if($seccion==$dato['usu']){ echo 'selected'; } ?>><?php echo $dato['usu']; ?></option>
													<?php } ?>
													<option value="Todos" selected>TODO</option>
													</select>

												</div>
											</div>
										</div>

										<div class="col-md-2">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<div class="row">
												<div class="col">
													<label for="" class="col-form-label">Tipo Producto</label>

													<select class="form-control form-control-sm"  id="categoria" name="categoria">
													<option value="" selected>TODO</option>
													<?php
													$can=mysql_query("SELECT id_comision, nombre FROM comision WHERE tipo <> 'RECARGA' AND tipo <> 'FICHA' AND tipo <> 'REPARACION' AND tipo <> 'APARTADO'");
													while($dato=mysql_fetch_array($can)){
													?>
													<option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>

													<?php } ?>
													<option value="R">REPARACIONES</option>
													<option value="CR">CREDITO/APARTADO</option>
													<!-- <option value="RECARGA">RECARGAS</option> -->
													</select>

												</div>
											</div>
										</div>

										<div class="col-md-2">
											<div class="row">
												<div class="col">

													<a href="javascript:pdfcorte()" class="red"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>

												</div>

												<div class="col">

													<a href="javascript:excelcorte()" class="green"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>

												</div>
											</div>

											<div class="row">
												<div class="col">
												<br/>
												<button type="button" class="btn btn-primary" onClick="consultacortes();" >Consultar</button>
												<i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>

							<br>
							<div class="col-md-12">
								<div id="totalComisiones"></div>
								<div id="recargado"></div>
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


$( function() {
    $( "#fechaini" ).datepicker();

  } );
	$( function() {
    $( "#to" ).datepicker();

  } );


function consultacortes(){

	$("#loading").show();

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

	var cajero       = document.getElementById("seccion").value;
	//var producto     = document.getElementById("product").value;
	var categoria    = document.getElementById("categoria").value;
	var codigo       = document.getElementById("codigo").value;
	var coincidencia = document.getElementById("coincidencia").value;


	var f1 = $("#fechaini").val();
	var f2 = $("#to").val();

	if(f1 == "" && f2 != ""){
	$("#fechaini").css("border-color", "red");
	}else if(f1 != "" && f2 == ""){
	$("#to").css("border-color", "red");

	}else{
		$("#fechaini").css("border-color", "");
		$("#to").css("border-color", "");


		$("#recargado").html("");
		$("#totalComisiones").html("");


		$.ajax({
		method: "POST",
		url: "reportecorte.php",
		dataType: "json",
		data: {fecha_ini11: fecha_i,fecha_fin11: fecha_f,cajero: cajero,categoria: categoria,coincidencia: coincidencia,codigo: codigo},
    }).done(function(respuesta) {

		//console.log(respuesta);

		$.each(respuesta, function(key, item) {

			$("#recargado").html(item.codigohtml);
			$("#totalComisiones").html(item.codigohtmlB);
			tabla();

            });

			$("#loading").hide();
    });


	}
}

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
	var cajero       = document.getElementById("seccion").value;

	var categoria    = document.getElementById("categoria").value;
	var codigo       = document.getElementById("codigo").value;
	var coincidencia = document.getElementById("coincidencia").value;

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
		window.open('PDFreportecorte.php?fecha_ini11='+fecha_i+'&fecha_fin11='+fecha_f+'&cajero='+cajero+'&codigo='+codigo+'&coincidencia='+coincidencia+'&categoria='+categoria,'_blank');
	}

}


function excelcorte(){

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

	var cajero       = document.getElementById("seccion").value;
	var categoria    = document.getElementById("categoria").value;
	var codigo       = document.getElementById("codigo").value;
	var coincidencia = document.getElementById("coincidencia").value;
	var f1 = $("#fechaini").val();
	var f2 = $("#to").val();

	if(f1 == "" && f2 != ""){
		$("#fechaini").css("border-color", "red");
	}else if(f1 != "" && f2 == ""){
		$("#to").css("border-color", "red");
	}else{
		$("#fechaini").css("border-color", "");
		$("#to").css("border-color", "");
		window.location = 'EXCELreportecorte.php?fecha_ini11='+fecha_i+'&fecha_fin11='+fecha_f+'&cajero='+cajero+'&codigo='+codigo+'&coincidencia='+coincidencia+'&categoria='+categoria;
	}
}

</script>

<script>
// $( document ).ready(function() {
// 	$('.tablefoo').footable();
// });
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
