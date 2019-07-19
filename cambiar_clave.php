<?php
 		session_start();
		include('php_conexion.php'); 
		
		if(!$_SESSION['tipo_usu']=='a'){
			header('location:error.php');
		}
		$usuarioA=$_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cambiar Contraseña</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
											<p class="black font-weight-bold titulo text-center">CONTRASEÑA</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">
                                          
                                        </div>
                                    </div>

                                    <?php 
	if(!empty($_POST['c1']) and !empty($_POST['c2']) and !empty($_POST['contra'])){
		if($_POST['c1']==$_POST['c2']){
			$contra=$_POST['contra'];
			$can=mysql_query("SELECT * FROM usuarios WHERE usu='".$usuarioA."' and con='".$contra."'");
			if($dato=mysql_fetch_array($can)){
				$cnueva=$_POST['c2'];
				$sql="Update usuarios Set con='$cnueva' Where usu='$usuarioA'";
				mysql_query($sql);
				echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  <strong>Contraseña!</strong> Actualizada con exito
					</div>';
			}else{
				echo '<div class="alert alert-danger">
					  <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Contraseña!</strong> Digitada no corresponde a la antigua
					</div>';
			}
		}else{
			echo '<div class="alert alert-danger">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  <strong>Las dos Contraseña!</strong> Digitadas no soy iguales
					</div>';
		}
	}
	?>


<hr>
                                    <div class="row">
                                      <div class="col-md-12">
                                                 
                                      </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-3">
                      <form name="form1" method="post" action="">
                      <label>Contraseña Antigua</label>
                      <input class="form-control" type="password" name="contra" id="contra">
										</div>
                    <div class="col-md-3">
                      <label>Nueva Contraseña</label>
                      <input class="form-control" type="password" name="c1" id="c1" required>
										</div>
                    <div class="col-md-3">
                      <label>Repita Nueva Contraseña</label>
                      <input class="form-control" type="password" name="c2" id="c2" required>
										</div>
                    <div class="col-md-3"><br>
                      <input type="submit" name="button" id="button" class="btn btn-primary" value="Cambiar Contraseña">
                      </form>
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