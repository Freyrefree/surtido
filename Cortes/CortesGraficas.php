<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		include("../MPDF/mpdf.php");
    	$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cortes Gráficas</title>

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

<!-- Chart -->

<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- ** -->



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

<?php include_once "../layout.php"; ?>
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
											<p class="black font-weight-bold titulo text-center">REPORTE GRÁFICAS DE CORTES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-6">                        
                                            
                                        </div>

                                        <div class="col-md-3">
											                   
                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-2">
											<i class="fa fa-calendar" aria-hidden="true"></i>
											<label for="">Fecha</label>
											<select class="form-control" class name="year" id="year">
												
												<?php 
													$can=mysql_query("SELECT DISTINCT YEAR(fecha_op) FROM detalle");
													while($dato=mysql_fetch_array($can)){
												?>
												<option value="<?php echo $dato['YEAR(fecha_op)']; ?>" <?php if($seccion==$dato['usu']){ echo 'selected'; } ?>><?php echo $dato['YEAR(fecha_op)']; ?></option>
												<?php } ?>
												<option value="" selected>Seleccionar Año</option>										
											</select>
										</div>
										<div class="col-md-2">

											<i class="fa fa-user" aria-hidden="true"></i>
											<label for="">Usuario</label>
											<select class="form-control" name="seccion" id="seccion">
												<?php 
													$can=mysql_query("SELECT * FROM usuarios ORDER BY nom ASC");
													while($dato=mysql_fetch_array($can)){
												?>
												<option value="<?php echo $dato['usu']; ?>" <?php if($seccion==$dato['usu']){ echo 'selected'; } ?>><?php echo $dato['usu']; ?></option>
												<?php } ?>
												<option value="Todos" selected>Todos </option>
											</select>

										</div>
										<div class="col-md-2">
											<i class="fa fa-shopping-basket" aria-hidden="true"></i>
											<label for="">Sucursal</label>

											<select class="form-control" name="empresa" id="empresa">
												<?php 
													$can=mysql_query("SELECT * FROM empresa ORDER BY empresa ASC");
													while($dato=mysql_fetch_array($can)){
														
												?>
												<option value="<?php echo $dato['id']; ?>" <?php if($seccion==$dato['empresa']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
												<?php } ?>
												<option value="Todos" selected>Todos </option>
											</select>


										</div>
										<div class="col-md-2">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<label for="">Producto</label>
											<select class="form-control" name="product" id="product">
												<?php 
														$can=mysql_query("SELECT DISTINCT codigo, nombre FROM detalle WHERE codigo IN(SELECT cod FROM producto) OR codigo IN(SELECT codigo FROM compania_tl) OR codigo IN(SELECT NombreServicio FROM servicio) ORDER BY Codigo ASC ");
														while($dato=mysql_fetch_array($can)){
													?>
												<option value="<?php echo $dato['codigo']; ?>" <?php if($product==$dato['nom']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
												<?php } ?>
												<option value="Todos" selected>Todos </option>
											</select>

										</div>

										<div class="col-md-2">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<label for="">Tipo Producto</label>
											<select class="form-control" name="categoria" id="categoria">
												<option value="" selected>Seleccione una Categoría</option>
												<?php 
														$can=mysql_query("SELECT id_comision, nombre FROM comision WHERE tipo!='RECARGA'");
														while($dato=mysql_fetch_array($can)){
												?>
												<option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>
												<?php } ?>
												<option value="RECARGA">RECARGAS</option>
											</select>
										</div>

										<div class="col-md-2"><br>
											<button type="button" class="btn btn-primary" onClick="consultacortes();" >Consultar</button>
											<i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">

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

function consultacortes(){
	$("#loading").show();

	var year         = document.getElementById("year").value;
	var cajero       = document.getElementById("seccion").value;
	var producto     = document.getElementById("product").value;
	var categoria    = document.getElementById("categoria").value;
	var empresa 	   = document.getElementById("empresa").value;
	$.post("ConsultasGraficas.php", 
	{cajero: cajero,
	year: year,
	producto: producto,
	empresa: empresa,
	categoria: categoria},
	function(data){		
	$("#recargado").html(data);
	$("#loading").hide();
	});	

}

</script>