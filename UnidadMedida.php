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
  <title>Unidad de Medida</title>

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
											<p class="black font-weight-bold titulo text-center">UNIDAD DE MEDIDA</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='CrearUnidadMedida.php'">Nueva Unidad de Medida</button>
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
                                                      $can=mysql_query("SELECT * FROM unidad_medida");	
                                                      while($dato=mysql_fetch_array($can)){
                                                        echo '<option value="'.$dato['id'].'"';
                                                        echo '<option value="'.$dato['nombre'].'">';
                                                        echo '<option value="'.$dato['abreviatura'].'">';
                                                      }
                                                    ?>                                                 
                                                   
                                                </datalist>
                                                <button class="btn btn-primary" type="submit">Buscar</button>
                                            
                                            </form>                        

                                        </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-12">

                                      <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                          <td>Codigo</td>
                                          <td>Nombre</td>
                                          <td>Abreviatura</td>
                                          <td><strong>equivalencia</td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                          if(empty($_POST['bus'])){
                                            $can=mysql_query("SELECT * FROM unidad_medida");
                                          }else{
                                            $buscar=$_POST['bus'];
                                            $can=mysql_query("SELECT * FROM unidad_medida where nombre LIKE '$buscar%' or abreviatura LIKE '$buscar%'");
                                          }	
                                          while($dato=mysql_fetch_array($can)){
                                            $codigo=$dato['id'];
                                          ?>
                                          <tr>
                                            <td><?php echo $codigo; ?></td>
                                            <td><a href="CrearUnidadMedida.php?codigo=<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?> </a></td>
                                            <td><?php echo $dato['abreviatura']; ?></td>
                                            <td><?php echo $dato['equivalencia']; ?></td>
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
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>


