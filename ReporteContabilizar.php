<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $usu = $_SESSION['username'];
?>
<?php 
$datestart  = $_POST['inicio'];
$datefinish = $_POST['fin'];
if(!isset($datestart) or !isset($datefinish)){
    $datestart  = date("Y-m-d");
    $datefinish = date("Y-m-d");
}
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Billetes y Monedas </title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
											<p class="black font-weight-bold titulo text-center">REPORTE DE BILLETES Y MONEDAS CONTABILIZADOS</p>
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

                                        <div class="col-md-3">
                                        <form name="f1" id="f1" action="" method="post" enctype="multipart/form-data">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <label for="">Inicio</label>
                                                <input class="form-control" type="date" name="inicio" id="inicio" value="<?php echo $datestart ?>"  required>
                                        </div>

                                        <div class="col-md-3">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <label for="">Fin</label>
                                                <input class="form-control" type="date" name="fin" id="fin" value="<?php echo $datefinish ?>" required>
                                        </div>


                                        <div class="col-md-6"><br>
                                            <input type="submit" class="btn btn-primary" value="Mostrar reporte">
                                            <i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>
                                            </div>
                                        </form>

									</div>

									<div class="row">
										<div class="col-md-12"><br>

                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Cajero</th>
                                                    <th>Sucursal</th>
                                                    <th>B. de $20</th>
                                                    <th>B. de $50</th>
                                                    <th>B. de $100</th>
                                                    <th>B. de $200</th>
                                                    <th>B. de $500</th>
                                                    <th>B. de $1000</th>
                                                    <th>M. de  $0.50</th>
                                                    <th>M. de  $1</th>
                                                    <th>M. de  $2</th>
                                                    <th>M. de  $5</th>
                                                    <th>M. de  $10</th>
                                                    <th>M. de  $20</th>
                                                    <th>Fecha</th>
                                                    <th>Hora de Cierre</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    $query2=mysql_query("SELECT * FROM billetes_monedas WHERE Fecha BETWEEN '$datestart' AND '$datefinish'");
                                                    while($dato=mysql_fetch_array($query2)){

                                                            $IdCajero            = $dato['id_cajero'];
                                                            $sucursal            = $dato['sucursal'];

                                                        $query3=mysql_query("SELECT * FROM usuarios WHERE ced='$IdCajero'");
                                                        if($dato3=mysql_fetch_array($query3)){

                                                            $cajero          = $dato3['nom'];
                                                        
                                                        }

                                                        $query4=mysql_query("SELECT * FROM empresa WHERE id='$IdSucursal'");
                                                        if($dato4=mysql_fetch_array($query4)){

                                                            $sucursal = $dato4['empresa'];
                                                        
                                                        }


                                            ?>        
                                                <tr>
                                                    <td><?php echo $dato['id'] ?></td>
                                                    <td><?php echo $cajero ?></td>
                                                    <td><?php echo $sucursal ?></td>
                                                    <td><?php echo $dato['b20'] ?></td>
                                                    <td><?php echo $dato['b50'] ?></td>
                                                    <td><?php echo $dato['b100'] ?></td>
                                                    <td><?php echo $dato['b200'] ?></td>
                                                    <td><?php echo $dato['b500'] ?></td>
                                                    <td><?php echo $dato['b1000'] ?></td>
                                                    <td><?php echo $dato['m050'] ?></td>
                                                    <td><?php echo $dato['m1'] ?></td>
                                                    <td><?php echo $dato['m2'] ?></td>
                                                    <td><?php echo $dato['m5'] ?></td>
                                                    <td><?php echo $dato['m10'] ?></td>
                                                    <td><?php echo $dato['m20'] ?></td>
                                                    <td><?php echo $dato['Fecha'] ?></td>
                                                    <td><?php echo $dato['HoraCierre'] ?></td>
                                                </tr>
                                            <?php   
                                                    }
                                            ?>          
                                            </tbody>
                                            </table>

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
	function GenerarExcel(){
	var datestart = document.getElementById("inicio").value;
	var datefinish = document.getElementById("fin").value;;
	var parametros = {
		   		datestart: datestart,
		   		datefinish: datefinish
        };
        $.ajax({
                data:  parametros,
                url:   'ExcelSaldoVirtual.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (data) {
					window.location = 'ExcelSaldoVirtual.php?datestart='+datestart+'&datefinish='+datefinish;
                }
        });
	}


    $(document).ready(function() {
    tabla();
} );

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