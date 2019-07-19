<?php
session_start();
include('php_conexion.php'); 
$usu=$_SESSION['username'];
$tipo_usu=$_SESSION['tipo_usu'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
    header('location:error.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario Ineficaz</title>

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
											<p class="black font-weight-bold titulo text-center">INVENTARIO DE PRODUCTOS DEFECTUOSOS</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">                        
                                           
                                        </div>

                                        <div class="col-md-2">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">


                                        <?php    
   
                                            $consulta = "SELECT * FROM inventarioineficaz";
                                            $query = (mysql_query($consulta));
                                            
                                            $codigo = '<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                            <th>ID</th>
                                            <th>Factura</th>
                                            <th>Código</th>
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Usuario Garantía Entrada</th>
                                            <th>Sucursal Garantía Entrada</th>
                                            <th>Usuario Garantía Salida</th>
                                            <th>Sucursal Garantía Salida</th>
                                            <th>Fecha Salida</th>
                                            
                                            </tr></thead><tbody>';

                                            // Vamos acumulando de a una fila "tr" por vuelta:
                                            while ( $fila = mysql_fetch_array($query) )
                                            {
                                                $idsucursalentrada = $fila['id_sucursal_entrada'];
                                                $idsucursalsalida = $fila['id_sucursal_salida'];

                                                $consulta2 = "SELECT empresa FROM empresa WHERE id = '$idsucursalentrada'";
                                                $query2 = mysql_query($consulta2);
                                                $fila2 = mysql_fetch_array($query2);
                                                $nombresucursalentrada = $fila2['empresa'];

                                                $consulta3 = "SELECT empresa FROM empresa WHERE id = '$idsucursalsalida'";
                                                $query3 = mysql_query($consulta3);
                                                $fila3 = mysql_fetch_array($query3);
                                                $nombresucursalsalida = $fila3['empresa'];

                                                
                                                
                                                $codigo .= '<tr>';
                                                
                                                // Vamos acumulando tantos "td" como sea necesario:
                                                $codigo .= '<td>'.utf8_encode($fila["idi"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila["id_venta"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila["codigo"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila["producto"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila["descripcion"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila["usuario_garantia_entrada"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($nombresucursalentrada).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila["usuario_garantia_salida"]).'</td>';
                                                $codigo .= '<td>'.utf8_encode($nombresucursalsalida).'</td>';
                                                $codigo .= '<td>'.utf8_encode($fila['fechasalida']).'</td>';
                                                
                                                // Cerramos un "tr":
                                                $codigo .= '</tr>';
                                            }

                                            // Finalizado el bucle, cerramos por única vez la tabla:
                                            $codigo .= '</tbody></table>';
                                            echo $codigo;


                                        ?>
                      

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
