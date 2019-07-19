<?php
         include_once 'APP/config.php';
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        $id_sucursal = $_SESSION['id_sucursal'];
        $sucursal = $_SESSION['sucursal'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        //-------------------------------------------------------
        function generaid(){
            $id_sucursal = $_SESSION['id_sucursal'];
            $can=mysql_query("SELECT MAX(id_solicitud)as numero FROM solicitud WHERE id_sucursal = '$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
                $numero=$dato['numero'] + 1;
            } //genera codigo autimaticamente
            return $numero;
        }
        $id_solicitud='';$producto='';$marca='';$especificacion='';$cantidad='';$fecha='';
        if(!empty($_GET['codigo'])){
            $id_solicitud=$_GET['codigo'];

            $can=mysql_query("SELECT * FROM solicitud where id_solicitud = '$id_solicitud'");
            if($dato=mysql_fetch_array($can)){

                $id_solicitud=$dato['id_solicitud'];$producto=$dato['producto'];$marca=$dato['marca'];
                $especificacion=$dato['especificacion'];$cantidad=$dato['cantidad'];$fecha=$dato['fecha'];
                $boton="Actualizar Solicitud";
            }
        }else{
            $boton="Guardar Solicitud";
            $id_solicitud = generaid();
            $fecha=date("Y-m-d");
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agregar Solicitud</title>


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
											<p class="black font-weight-bold titulo text-center">NUEVA SOLICITUD <?= $sucursal ?></p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-6">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='Solicitudes.php'">Listado Solicitudes</button>
                                        </div>

                                        <div class="col-md-4">                        
                                        
                                        </div>

                                        <div class="col-md-2">                        
                                                            
                                        </div>
                                    </div>
                                    
                                    <br>

									<div class="row">
										<div class="col-md-12">



                                            <?php
                                            if(!empty($_POST['id'])){

                                                $id_solucitud=$_POST['id'];$producto=strtoupper($_POST['producto']);$marca=strtoupper($_POST['marca']);
                                                $especificacion=strtoupper($_POST['especificacion']);$cantidad=$_POST['cantidad'];$fecha=$_POST['fecha'];

                                                $can=mysql_query("SELECT * FROM solicitud where id_solicitud='$id_solicitud' AND id_sucursal = '$id_sucursal'");
                                                if($dato=mysql_fetch_array($can)){
                                                    if($boton=='Actualizar Gasto'){
                                                        $nombre_archivo == "";$nombres_archivos="";
                                                        $xSQL="UPDATE solicitud SET id_solicitud = '$id_solicitud',
                                                        id_sucursal='$id_sucursal',
                                                        usuario='$usu',
                                                        producto='$producto',
                                                        marca='$marca',
                                                        especificacion='$especificacion',
                                                        cantidad='$cantidad',
                                                        fecha='$fecha',
                                                        WHERE id_solicitud='$id_solicitud'";

                                                        mysql_query($xSQL);
                                                        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                                                        <strong>Solicitud</strong> Actualizado con Exito</div>';
                                                    }else{
                                                        echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>Solicitud Existente</div>';
                                                    }
                                                }else{
                                                    $sql = "INSERT INTO solicitud (id_solicitud,id_sucursal,usuario,producto,marca,especificacion,cantidad,fecha)
                                                    VALUES ('$id_solicitud','$id_sucursal','$usu','$producto','$marca','$especificacion','$cantidad','$fecha')";
                                                    mysql_query($sql);
                                                    echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                                                    <strong>Solicitud!</strong> Guardado con Exito</div>';
                                                    $id_solicitud='';$producto='';$marca='';$especificacion='';$cantidad='';
                                                    $id_solicitud = generaid();
                                                }
                                            }
                                            ?>

                                            <form name="form1" enctype="multipart/form-data" method="post" action="">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Identificador</label>
                                                        <input type="text" class="form-control" name="id" id="id" <?php if(!empty($id_solicitud)){echo 'readonly';} ?> value="<?php echo $id_solicitud; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Tipo de Producto</label>
                                                        <select class="form-control" name="producto" id="producto">
                                                            <option value="telefono">EQUIPO / TELEFONO</option>
                                                            <option value="accesorio">ACCESORIO</option>
                                                            <option value="servicio">SERVICIO</option>
                                                            <option value="otro">OTRO</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Marca</label>
                                                        <input type="text" class="form-control" name="marca" id="marca" value="<?php echo $marca; ?>" autocomplete="off" maxlength="70">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Especificación</label>
                                                        <input type="text" class="form-control" name="especificacion" id="especificacion" value="<?php echo $especificacion; ?>" autocomplete="off" maxlength="80">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Fecha</label>
                                                        <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Cantidad</label>
                                                        <input type="text" class="form-control" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" autocomplete="off" maxlength="30">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                <br>
                                                    <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                                                    <?php if($boton=='Actualizar Solicitud'){ ?> <a href="crear_solicitud.php" class="btn btn-large btn-danger">Cancelar</a><?php }  ?>
                                                </div>

                                            </div>
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




