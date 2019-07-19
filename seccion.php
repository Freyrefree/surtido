<?php
 		include_once 'APP/config.php';
		include('php_conexion.php'); 
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
  <title>Seccionde de Inventario</title>
</head>

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

        /* Extra */
        input{
          text-transform:uppercase;
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
											<p class="black font-weight-bold titulo text-center">SECCIONES DE INVENTARIO</p>
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

                    <div class="row">
                      <div class="col-md-6">

                      <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $can=mysql_query("SELECT * FROM seccion");
                            while($dato=mysql_fetch_array($can)){
                            $nombre=$dato['nombre'];
                            $id=$dato['id'];
                            if($dato['estado']=="n"){
                              $estado='<span class="label label-important">Inactivo</span>';
                            }else{
                              $estado='<span class="label label-success">Activo</span>';
                            }
                          ?>
                          <tr>
                            <td><?php echo $id; ?></td>
                            <td><a href="seccion.php?codigo=<?php echo $id; ?>"><?php echo $nombre; ?></a></td>
                            <td><a href="php_estado_seccion.php?id=<?php echo $id; ?>"><?php echo $estado; ?></a></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>

                      </div>

                      <div class="col-md-6">

                        <?php 
                        if(empty($_GET['codigo'])){
                          $can=mysql_query("SELECT MAX(id) as numero FROM seccion");
                          if($dato=mysql_fetch_array($can)){
                            $s_codigo=$dato['numero']+1;
                            $s_nombre="";
                            $boton="Guardar Seccion";
                          }
                        }else{
                          $s_codigo=$_GET['codigo'];
                          $can=mysql_query("SELECT * FROM seccion WHERE id=$s_codigo");
                          if($dato=mysql_fetch_array($can)){
                            $s_nombre=$dato['nombre'];
                          }
                          $boton="Actualizar Seccion";
                        }
                        
                        ?>

                        <form name="form1" method="post" action="">
                          <div class="form-group">
                            <label for="">Codigo:</label>
                            <input class="form-control" type="text" name="s_codigo" id="s_codigo" value="<?php echo $s_codigo; ?>" readonly>
                          </div>

                          <div class="form-group">
                            <label for="">Nombre</label>
                            <input class="form-control" type="text" name="s_nombre" id="s_nombre" value="<?php echo $s_nombre; ?>" required><br><br>
                          </div>

                            <button tabindex="submit" class="btn btn-primary"><?php echo $boton; ?></button>
                            <?php if($boton=='Actualizar Seccion'){ ?> <a href="seccion.php" class="btn btn-danger">Cancelar</a><?php } ?>
                        </form>

                        <?php 
                          if(!empty($_POST['s_nombre'])){
                            $ss_codigo=$_POST['s_codigo'];	$ss_nombre=strtoupper($_POST['s_nombre']);

                            $can=mysql_query("SELECT * FROM seccion WHERE id=$ss_codigo");
                            if($dato=mysql_fetch_array($can)){
                              //actualizar seccion
                              $xSQL="Update seccion Set nombre='$ss_nombre' Where id=$ss_codigo";
                              mysql_query($xSQL);
                              echo '	<div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Seccion!</strong> Actualizado con Exito <a href="seccion.php">[Clic Para Actualizar]</a>
                              </div>';
                            }else{
                              //guardar seccion
                              $sql="INSERT INTO seccion (nombre, estado) VALUES ('$ss_nombre','s')";
                              mysql_query($sql);
                              echo '	<div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Seccion!</strong> Guardado con Exito <a href="seccion.php">[Clic Para Actualizar]</a>
                              </div>';
                            }
                          }
                        ?>


                      
                      </div>
                      
                    </div>



                      

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


