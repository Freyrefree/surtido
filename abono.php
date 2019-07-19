<?php
session_start();
include('funciones.php');
include('host.php');
include('IMP_abono.php');


$idSucursal   = $_SESSION['id_sucursal']; 
$usuario      = $_SESSION['username'];




  $denominacion = $_GET['denominacion'];
  $abono        = $_GET['abono'];
  $cambio       = $_GET['cambio'];
  $resto        = $_GET['resto'];
  $idCredito    = $_GET['idCredito'];
  


//$ruta = "Facturas/CA".$factura."_".$idSucursal;
$ruta = "Facturas/ABONO"."_".$idCredito."_".$idSucursal;



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crédito</title>


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
											<p class="black font-weight-bold titulo text-center">CRÉDITO<p>
										</div>
									</div>

                      <div class="row">
                          <div class="col-md-6">  
                        
                            <a href="VentasCredito.php" class="btn btn-info">REGRESAR A CRÉDITO/APARTADO</a>
                         
                          </div>

                          <div class="col-md-2">                        
                          
                          
                          </div>

                          <div class="col-md-4">

            
                            
                          </div>

                      </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">

                    

                      <div class="row">

                        <div class="col-md-3">

                            <p style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></p>
                            <p style="font-size:24px"><strong>$<?php echo number_format($denominacion,2)?></strong></p>

                            <p style="font-size:24px"><strong class="text-success">Usted Abona</strong></p>
                            <p style="font-size:24px"><strong>$<?php echo number_format($abono,2)?></strong></p>

                            <p style="font-size:24px"><strong class="text-success">Cambio</strong></p>
                            <p style="font-size:24px"><strong>$<?php echo number_format($cambio,2)?></strong></p>

                            <p style="font-size:24px"><strong class="text-success">Usted Resta</strong></p>
                            <p style="font-size:24px"><strong>$<?php echo number_format($resto,2)?></strong></p>
                           
                        </div>

                        <div class="col-md-9">
                        
                        <embed src="<?php echo $ruta; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
                        

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