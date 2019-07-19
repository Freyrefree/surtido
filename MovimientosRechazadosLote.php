<?php

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
    <title>Movimientos</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


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

<script>

$(document).ready(function() {
 tabla();
});

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
											<p class="black font-weight-bold titulo text-center">MOVIMIENTOS RECHAZADOS</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <a href="NuevoMovimientoLote.php" class="btn btn-info">Nuevo Movimiento</a>
                                        </div>

                                        <div class="col-md-3">                        
                                            <a href="MovimientosLote.php" class="btn btn-warning">Movimientos Pendientes</a>
                                        </div>

                                        <div class="col-md-3">                        
                                            <a href="MovimientosAceptadosLote.php" class="btn btn-success">Movimientos Autorizados</a>
                                        </div>

                                        <div class="col-md-3">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">

                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            
                                            <thead>
                                            <tr>
                                                <th>No. Lote</th>
                                                <th>Sucursal Salida</th>
                                                <th>Sucursal Entrada</th>
                                                <th>Código producto</th>
                                                <th>Producto</th>
                                                <th>Cantidad Enviada</th>
                                                <th>Cantidad Recibida</th>
                                                <th>Fecha Entrada</th>
                                                <th>Recibido</th>
                                                <th>Razón del Rechazo</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr>
                                        <?php
                                                if($tipo_usu=="a"){
                                                    $query2=mysql_query("SELECT * FROM movimientosxlote WHERE recibido=2 ORDER BY FechaEntrada DESC");
                                                }else{
                                                    $query2=mysql_query("SELECT * FROM movimientosxlote WHERE (IdSucSalida=$id_sucursal OR IdSucEntrada=$id_sucursal) AND recibido=2 ORDER BY FechaEntrada DESC");
                                                }
                                                
                                                while($dato=mysql_fetch_array($query2)){
                                                    $y=$y+1;  

                                                    $Id           =$dato['Id'];
                                                    $IdSucSalida  =$dato['IdSucSalida'];
                                                    $IdSucEntrada =$dato['IdSucEntrada'];
                                                    $IdProducto   =$dato['IdProducto'];
                                                    $IMEI         =$dato['IMEI'];
                                                    $ICCID        =$dato['ICCID'];
                                                    $IdFciha      =$dato['IdFciha'];

                                                    $QSucSal=mysql_query("SELECT * FROM empresa WHERE id=$IdSucSalida");
                                                    if($DSucSal=mysql_fetch_array($QSucSal)){
                                                        $SucursalSalida=$DSucSal['empresa'];
                                                    }

                                                    $QSucEnt=mysql_query("SELECT * FROM empresa WHERE id=$IdSucEntrada");
                                                    if($DSucEnt=mysql_fetch_array($QSucEnt)){
                                                        $SucursalEntrada=$DSucEnt['empresa'];     
                                                    }

                                                    $QProduc=mysql_query("SELECT * FROM producto WHERE cod='$IdProducto'"); 
                                                    if($DProduc=mysql_fetch_array($QProduc)){
                                                        $NombreProducto=$DProduc['nom'];
                                                    }     

                                        ?>        
                                            
                                                <td><?php echo $dato['IdLote'] ?></td>
                                                <td><?php echo $SucursalSalida ?></td>
                                                <td><?php echo $SucursalEntrada ?></td>
                                                <td><?php echo $dato['IdProducto'] ?></td>
                                                <td><?php echo $NombreProducto ?></td>
                                                <td><?php echo $dato['Cantidad'] ?></td>
                                                <td><?php echo $dato['CantRecibida'] ?></td>
                                                <td><?php echo $dato['FechaEntrada'] ?></td>
                                                <td>X</td>
                                                <td><?php echo $dato['RazonRechazo'] ?></td>
                                            </tr>

                                            <?php }?>


                                            </tbody>
                                        </table>
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
    </div>

</body>
</html>

