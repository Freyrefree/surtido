<?php
        include_once 'APP/config.php';
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $usuario_a = $_SESSION['tipo_usu'];
       
?>

<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Solicitudes</title>

    

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
											<p class="black font-weight-bold titulo text-center">LISTADO DE SOLICITUDES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                          <button type="button" class="btn btn-info" onClick="window.location='crear_solicitud.php'">Ingresar Nuevo</button>
                                        </div>

                                         
                                          <div class="col-md-3">
                                          <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
                                         
                                            <div class="form-group">
                                              <label for="">Fecha Inicio</label>
                                              <input type="date" class="form-control" name="inicio" id="inicio">
                                            </div>

                                          </div>

                                          <div class="col-md-3"> 

                                            <div class="form-group">
                                              <label for="">Fecha Inicio</label>
                                              <input type="date" class="form-control" name="fin" id="fin">
                                            </div>

                                                <?php 
                                                    $datestart  = $_POST['inicio'];
                                                    $datefinish = $_POST['fin'];
                                                ?>
                                                                       
                                               
                                          </div>

                                          <div class="col-md-3">
                                            <br>
                                            <button class="btn btn-primary" type="submit">Buscar</button>
                                            </form>
                                          </div>
                                          
                                        
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">


                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Producto/Servicio</th>
                        <th>Solicitante</th>
                        <th>Sucursal</th>
                        <th>Marca</th>
                        <th>Especificación</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>

                        <?php 
                        if(empty($_POST['inicio']) && empty($_POST['inicio'])){
                          if($usuario_a == 'a'){
                            $can=mysql_query("SELECT * FROM solicitud  ORDER BY fecha DESC, id_solicitud DESC");

                          }else{
                            $can=mysql_query("SELECT * FROM solicitud WHERE id_sucursal = '$id_sucursal' ORDER BY fecha DESC, id_solicitud DESC");
                          }
                          }else{
                            $datestart  = $_POST['inicio'];
                            $datefinish = $_POST['fin'];
                            if($usuario_a == 'a')
                            {
                              $can=mysql_query("SELECT * FROM solicitud where fecha BETWEEN '".$datestart."' AND '".$datefinish."' ");
                            }else{
                            $can=mysql_query("SELECT * FROM solicitud where fecha BETWEEN '".$datestart."' AND '".$datefinish."' AND id_sucursal = '$id_sucursal'");
                            }
                          }
                        while($dato=mysql_fetch_array($can)){
                          $idempresa = $dato['id_sucursal'];
                          $query=mysql_query("SELECT empresa FROM empresa WHERE  id = '$idempresa'");
                          $dato2=mysql_fetch_array($query);
                          $nombreempresa=$dato2['empresa'];
                        ?>

                      <tr>
                        <td><?php echo $dato['id_solicitud']; ?></td>
                        <td>
                            <a href="crear_solicitud.php?codigo=<?php echo $dato['id_solicitud']; ?>"><?php echo $dato['producto']; ?></a>
                        </td>
                        <td><?php echo $dato['usuario']; ?></td>
                        <td><?php echo $nombreempresa; ?></td>
                        <td><?php echo $dato['marca']; ?></td>
                        <td><?php echo $dato['especificacion']; ?></td>
                        
                        <td><?php echo $dato['fecha']; ?></td>
                        <td><?php echo $dato['cantidad']; ?></td>
                      </tr>
                        <?php } ?>
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





