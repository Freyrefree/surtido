<?php
		include_once 'APP/config.php';
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		/*$can=mysql_query("SELECT MAX(codigo)as numero FROM proveedor");
		if($dato=mysql_fetch_array($can)){
			$numero=$dato['numero']+1;
		}*/ //genera codigo autimaticamente
		
		$contacto='';$correo='';$celular='';
		$empresa=''; $calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono=''; //new dates;
		if(!empty($_GET['codigo'])){
			$codigo=$_GET['codigo'];
			$can=mysql_query("SELECT * FROM proveedor where codigo=$codigo");
			if($dato=mysql_fetch_array($can)){//actualizacion de datos (obtencion)
				
				$contacto=$dato['nom'];$correo=$dato['correo'];$celular=$dato['cel'];$pais=$dato['pais'];$rfc=$dato['rfc'];$regimen=$dato['regimen'];
				$empresa=$dato['empresa'];$calle=$dato['calle'];$cp=$dato['cp'];$colonia=$dato['colonia'];$estado=$dato['lestado'];$municipio=$dato['ciudad'];$next=$dato['next'];$nint=$dato['nint'];$telefono=$dato['tel'];
				$boton="Actualizar Proveedor";
			}
		}else{//nuevo registro
			$boton="Guardar Proveedor";
		}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Crear Proveedor</title>


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

<?php 
	if(!empty($_POST['empresa'])){

		$rfc=strtoupper($_POST['rfc']);					$calle=strtoupper($_POST['calle']);
		$empresaa=strtoupper($_POST['empresa']);			$cp=strtoupper($_POST['cp']);				
		$contacto=strtoupper($_POST['contacto']);		$next=strtoupper($_POST['next']);
		$pais=strtoupper($_POST['pais']);       		$nint=strtoupper($_POST['nint']);
		$estado=strtoupper($_POST['estado']);			$correo=$_POST['correo'];
		$municipio=strtoupper($_POST['municipio']);		$telefono=$_POST['telefono'];
		$colonia=strtoupper($_POST['colonia']);			$celular=$_POST['celular'];
		$regimen=strtoupper($_POST['regimen']);
		
				
		$can=mysql_query("SELECT * FROM proveedor where codigo=$codigo");
		if($dato=mysql_fetch_array($can)){
			if($boton=='Actualizar Proveedor'){
				$xSQL="UPDATE proveedor SET  
								empresa =  	 '$empresaa',
								calle =    	 '$calle',
								cp =       	 '$cp',
								colonia =  	 '$colonia',
								lestado =    '$estado',
								ciudad =     '$municipio',
								next =       '$next',
								nint =       '$nint',
								regimen =    '$regimen',
								tel =   	 '$telefono',
								cel = 	 	 '$celular',
								correo =	 '$correo',
								nom =	 	 '$contacto',
								pais = 		 '$pais'
							WHERE codigo=$codigo";
				mysql_query($xSQL);
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Proveedor! </strong> Actualizado con Exito
					</div>';
			}		
		}else{
			$sql = "INSERT INTO  proveedor (rfc,empresa,calle,cp,colonia,lestado,ciudad,next,nint,regimen,tel,cel,correo,nom,pais,estado)
					VALUES ('$rfc','$empresaa','$calle','$cp','$colonia','$estado','$municipio','$next','$nint','$regimen','$telefono','$celular','$correo','$contacto','$pais','s');";
			mysql_query($sql);	
			echo '	<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">X</button>
					  <strong>Proveedor! </strong> Guardado con Exito
					</div>';
				$contacto='';$correo='';$celular='';
				$empresaa=''; $rfc='';$calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono=''; //new dates;
		}
	}
?>

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
											<p class="black font-weight-bold titulo text-center">NUEVO PROVEEDOR</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-6">                        
											<button type="button" class="btn btn-info" onClick="window.location='proveedor.php'">Listado Proveedores</button>
                                        </div>

                                        <div class="col-md-4">                        
                                        
                                        </div>

                                        <div class="col-md-2">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">

										<form name="form1" method="post" action="">
										<div class="row">
                                            <div class="col-md-3">
                                                <?php 
												if(!empty($_GET['codigo'])){
													?>
														<div class="form-group">
														<label for="">RFC</label>
														<input  class="form-control" type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15" required >
														</div>
													<?php
												}else{
													?>
														<div class="form-group">
														<label for="">RFC</label>
														<input  class="form-control" type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15" required>
														</div>
													<?php
												}
                                                ?>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
													<label for="">Empresa/Razon social</label>
													<input class="form-control" type="text" name="empresa" id="empresa" value="<?php echo $empresaa; ?>" required maxlength="100">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Pais</label>
													<input class="form-control" type="text" name="pais" id="pais" value="<?php echo $pais; ?>" maxlength="30">  
												</div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Estado</label>
													<input class="form-control" type="text" name="estado" id="estado" value="<?php echo $estado; ?>" maxlength="50">
												</div>
                                            </div>


                                        </div>

										<div class="row">
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Municipio</label>
													<input class="form-control"  type="text" name="municipio" id="municipio" value="<?php echo $municipio; ?>" maxlength="50">
												</div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">												
													<label for="">Colonia</label>
													<input class="form-control" type="text" name="colonia" id="colonia" value="<?php echo $colonia; ?>" maxlength="50">
												</div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Calle</label>
													<input class="form-control"  type="text" name="calle" id="calle" value="<?php echo $calle; ?>" required maxlength="100">  
												</div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Codigo Postal</label>
													<input class="form-control" type="text" name="cp" id="cp" value="<?php echo $cp; ?>" required maxlength="10">
												</div>
                                            </div>


                                        </div>
										<div class="row">
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">N. Ext</label>
													<input class="form-control" type="text" name="next" id="next" value="<?php echo $next; ?>" maxlength="10">
												</div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">												
													<label for="">N. Int</label>
													<input class="form-control" type="text" name="nint" id="nint" value="<?php echo $nint; ?>" maxlength="10">
												</div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Correo</label>
													<input class="form-control" type="email" name="correo" id="correo" value="<?php echo $correo; ?>" required>
												</div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Contacto</label>
													<input class="form-control" type="text" name="contacto" id="contacto" value="<?php echo $contacto; ?>" required maxlength="50">
												</div>
                                            </div>
                                        </div>

										<div class="row">
                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Telefono</label>
													<input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" required maxlength="20">
												</div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">												
													<label for="">Celular</label>
													<input class="form-control" type="text" name="celular" id="celular" value="<?php echo $celular; ?>" required maxlength="20">
												</div>
                                            </div>

                                            <div class="col-md-3">
												<div class="form-group">
													<label for="">Regimen: </label>
													<input class="form-control" type="text" name="regimen" id="regimen" value="<?php echo $regimen; ?>">
												</div>
                                            </div>

                                            <div class="col-md-3">                                           
												<br>
												<button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
												<?php if($boton=='Actualizar Proveedor'){ ?> <a href="crear_proveedor.php" class="btn btn-large btn-danger">Cancelar</a><?php } ?>
                                            
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