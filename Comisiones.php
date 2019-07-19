<?php
 		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
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
  <title>Listado Comisiones</title>

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
											<p class="black font-weight-bold titulo text-center">COMISIONES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='crear_comision.php'">Nueva Comision</button>
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>
                                        <div class="col-md-3">                        
                                            
                                        </div>



                                        <div class="col-md-3">
                                        <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
                                        
                                        <input class="form-control" name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar">
                                          <datalist id="characters">
                                          <?php
                                            $buscar=$_POST['bus'];
                                            $can=mysql_query("SELECT * FROM comision");
                                            while($dato=mysql_fetch_array($can)){
                                                echo '<option value="'.$dato['nombre'].'">';
                                            }
                                          ?>
                                        </datalist>
                                        <button class="btn btn-primary" type="submit">Buscar</button>
                                        
                                      </form>

                      

                                        </div>
                                    </div>
<hr>
                                    <div class="row">
                                      <div class="col-md-12">

                                      <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                          <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>%  Público</th>
                                            <th>%  Mayoreo</th>
                                            <th>%  Especial</th>
                                            <th>Descripcion</th>
                                          </tr>
                                        </thead><tbody>

                                            <?php 
                                          if(empty($_POST['bus'])){
                                            $can=mysql_query("SELECT * FROM comision");
                                          }else{
                                            $buscar=$_POST['bus'];
                                            $can=mysql_query("SELECT * FROM comision where nombre LIKE '$buscar%'");
                                          }	
                                          while($dato=mysql_fetch_array($can)){
                                            $codigo=$dato['id_comision'];
                                          ?>
                                          <tr>
                                            <td><?php echo $codigo; ?></td>
                                            <td><a href="crear_comision.php?codigo=<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?> </a></td>
                                            <td><?php echo $dato['tipo']; ?></td>
                                            <td><?php echo $dato['porcentaje']. "%"; ?></td>
                                            <td><?php echo $dato['porcentajemayoreo']. "%"; ?></td>
                                            <td><?php echo $dato['porcentajeespecial']. "%"; ?></td>
                                            <td><?php echo $dato['descripcion']; ?></td>
                                          </tr>
                                            <?php } ?>
                                            </tbody>
                                      </table>          
                                      </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">
                      

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


</script>



