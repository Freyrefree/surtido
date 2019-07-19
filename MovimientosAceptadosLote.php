<?php
        // session_start();
        include_once 'APP/config.php';
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $y=0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimientos Aceptados</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


 <!-- Date Picker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- ************* -->

  <!-- "DATA TABLE" -->
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
											<p class="black font-weight-bold titulo text-center">MOVIMIENTOS PENDIENTES</p>
										</div>
									</div>



                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <a href="NuevoMovimientoLote.php" class="btn btn-info">Nuevo Movimiento</a>
                                        </div>

                                        <div class="col-md-3">                        
                                        <a href="MovimientosLote.php" class="btn  btn-warning">Movimientos Pendientes</a>
                                        </div>

                                        <div class="col-md-3">                        
                                            <a href="MovimientosRechazadosLote.php" class="btn  btn-danger">Movimientos Rechazados</a>
                                        </div>

                                        <div class="col-md-3">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-3">
                                                Desde<input class="form-control" type="text" id="fechainicio" name="fechainicio" value=""/>
                                            </div>

                                            <div class="col-md-3">
                                                Hasta<input class="form-control" type="text" id="fechafin" name="fechafin" value=""/>
                                            </div>

                                            <div class="col-md-3">
                                            Categoría
                                                <select class="form-control" name="tipo" id="tipo">
                                                    <option value="0">Selecciona Una Opción</option>
                                                    <option value="1">Telefonía</option>
                                                    <option value="2">Accesorios</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                            <button onclick="consultarMA2();" type="button" class="btn btn-primary">Consultar</button>
                                            <i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>
                                            </div>

                                            

                                        </div>

									    </div>

								    </div>

                                    <div class="row">
                                    <div class="col-md-12">
                                    <br>
                                        <div id="imprimeme"></div>
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

    
</body>
</html>

<script>
    $(function() {
            $( "#fechainicio" ).datepicker({
                defaultDate: "",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                }
            });
            $( "#fechafin" ).datepicker({
                defaultDate: "",
                changeMonth: true,
                numberOfMonths: 1,
                onClose: function( selectedDate ) {
                }
            });
        });
</script>


<script>


    function consultarMA2()
    {
        $("#loading").show();
        $("#imprimeme").html("");


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

        var tipo = document.getElementById("tipo").value;



        $.ajax({
            method: "POST",
            url: "MovimientosAceptadosLote2.php",
            data: {fechainicio: fecha_i, fechafin: fecha_f, tipo: tipo}
            })
            .done(function(respuesta) 
            {
                $("#loading").hide();
                $("#imprimeme").html(respuesta);
                tabla();
            });
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

