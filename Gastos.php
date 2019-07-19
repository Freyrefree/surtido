<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Gastos</title>


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
											<p class="black font-weight-bold titulo text-center">GASTOS<p>
										</div>
									</div>

                      <div class="row">
                          <div class="col-md-3">  
                        
                            <a href="AgregarGastos.php" class="btn btn-info">Agregar Gasto</a>
                         
                          </div>

                          <div class="col-md-3">                        
                          <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
                          <label for="">Fecha Inicio</label>
                          <input class="form-control" type="date" name="inicio" id="inicio">
                          </div>

                          <div class="col-md-3">
                          <label for="">Fecha Fin</label>
                            
                              
                                    
                                    <input class="form-control" type="date" name="fin" id="fin">
                                    <?php 
                                        $datestart  = $_POST['inicio'];
                                        $datefinish = $_POST['fin'];
                                    ?>

                                    
                              
                           

                          </div>
                          <div class="col-md-3">  <br>                      
                            <button class="btn btn-primary" type="submit">Buscar por Fechas</button>
                          </form>
                          </div>

                      </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">

                    <table class="table">
                      <thead>
                      <tr>

                        <th>ID</th>
                        <th>Concepto</th>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Iva</th>
                        <th>Descripción</th>
                        <th>Comprobante</th>

                      </tr>
                      </thead><tbody>

                        <?php 
                        if(empty($_POST['inicio']) && empty($_POST['inicio'])){
                            $can=mysql_query("SELECT * FROM gastos WHERE id_sucursal = '$id_sucursal' ORDER BY fecha DESC, id_gasto DESC ");
                        }else{
                            $datestart  = $_POST['inicio'];
                            $datefinish = $_POST['fin'];
                            
                            $can=mysql_query("SELECT * FROM gastos where fecha BETWEEN '".$datestart."' AND '".$datefinish."' AND id_sucursal = '$id_sucursal'");
                        }

                        while($dato=mysql_fetch_array($can)){
                            if($dato['documento']!=""){
                                $direccion = $dato['documento'];
                                $id = $dato['id_gasto'];
                                $estado='<a href="download_com.php?archivo='.$direccion.'&id='.$id.'&val=gasto"><span class="badge badge-success">Documento</span></a>';
                            }else{
                                $estado='<span class="badge badge-danger">No Documento</span>';
                            }
                        ?>
                      <tr>
                        <td><?php echo $dato['id_gasto']; ?></td>
                        <td>
                            <a href="AgregarGastos.php?codigo=<?php echo $dato['id_gasto']; ?>"><?php echo $dato['concepto']; ?></a>
                        </td>
                        <td><?php echo $dato['numero_fact']; ?></td>
                        <td><?php echo $dato['fecha']; ?></td>
                        <td>$ <?php echo number_format($dato['total'],2,",","."); ?></td>
                        <td>$ <?php echo number_format($dato['iva'],2,",","."); ?></td>
                        <td><?php echo $dato['descripcion']; ?></td>
                        <td><?php echo $estado; ?></td>
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