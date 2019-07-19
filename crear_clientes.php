<?php
		include_once 'APP/config.php';
		include('php_conexion.php'); 
		
		$usu=$_SESSION['username'];
		$tipo_usu=$_SESSION['tipo_usu'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$contacto='';$correo='';$celular='';$estatus = '';
        $empresa=''; $calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono=''; //new dates;
		if(!empty($_GET['codigo'])){
            
            $codigo=$_GET['codigo'];
            
			$can=mysql_query("SELECT * FROM cliente where codigo = '$codigo'");
			if($dato=mysql_fetch_array($can)){
                $rfc=$dato['rfc'];
                $contacto=$dato['nom'];
                $apaterno=$dato['apaterno'];
                $amaterno=$dato['amaterno'];                
                $correo=$dato['correo'];
                $telefono=$dato['tel'];
                $celular=$dato['cel'];
                $empresa= explode(" ",$dato['empresa']);                
                $pais=$dato['pais'];
                $estado=$dato['estado'];
                $municipio=$dato['municipio'];
                $colonia=$dato['colonia'];
                $cp=$dato['cp'];
                $next=$dato['next'];
                $nint=$dato['nint'];
                $regimen=$dato['regimen'];
                $calle=$dato['calle'];
                $fecha=$dato['fecha'];
                
                $nomb = $empresa[0];$apat = $empresa[1];$amat = $empresa[2];
                $boton="Actualizar Cliente";
                //echo $codigo;	
			}
		}else{
			$boton="Guardar Cliente";
		}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Clientes</title>

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

if(!empty($_POST['apat'])){

        $calle=strtoupper($_POST['calle']);
        $cp=strtoupper($_POST['cp']);
        $next=strtoupper($_POST['next']);
        $pais=strtoupper($_POST['pais']);               $nint=strtoupper($_POST['nint']);
        $estado=strtoupper($_POST['estado']);           $correo=strtoupper($_POST['correo']);
        $municipio=strtoupper($_POST['municipio']);     $telefono=strtoupper($_POST['telefono']);
        $colonia=strtoupper($_POST['colonia']);         $celular=strtoupper($_POST['celular']);
        $estatus = "s";                                 $regimen=strtoupper($_POST['regimen']);
    
        $paterno = strtoupper($_POST['apat']);
        $materno = strtoupper($_POST['amat']);
        $nombre  = strtoupper($_POST['nomb']);

        $rfcpaterno = substr($paterno, 0, 2);
        $rfcmaterno = substr($materno, 0, 1);
        $rfcnombre  = substr($nombre , 0, 1);

        $first_part = $rfcpaterno.$rfcmaterno.$rfcnombre;
        $fecha   = explode("-", $_POST['fecha']);
        $secon_part = substr($fecha[0], -2).$fecha[1].$fecha[2];
        $rfc = $first_part.$secon_part;
        $empresa = strtoupper($_POST['nomb']." ".$_POST['apat']." ".$_POST['amat']);
        $contacto=strtoupper($_POST['nomb']);/*$_POST['contacto']*/
        $fech = $_POST['fecha'];
    /*}*/
    $can=mysql_query("SELECT * FROM cliente where rfc='$rfc'");
    if($dato=mysql_fetch_array($can)){
        if($boton=='Actualizar Cliente'){
            $xSQL="UPDATE cliente SET   
            nom =        '$contacto',
            empresa =    '$empresa',
            apaterno = '$paterno',
            amaterno = '$materno',
            correo =     '$correo',
            tel =        '$telefono',
            cel =        '$celular',
            pais =       '$pais',
            estado =     '$estado',
            municipio =  '$municipio',
            colonia =    '$colonia',
            cp =         '$cp',
            next =       '$next',
            nint =       '$nint',
            regimen =    '$regimen',
            calle =      '$calle',
            fecha =      '$fech'                             
            Where codigo='$codigo'";

            mysql_query($xSQL);
            echo '	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                        <strong>Cliente / Cliente!</strong> Actualizado con Exito</div>';
                    }else{
                        echo '	<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de RFC ingreso le pertenece al cliente '.$dato['nom'].'</div>';
        }		
    }else{
            $sql = "INSERT INTO cliente (rfc,nom,apaterno,amaterno,correo,tel,cel,empresa,pais,estado,municipio,colonia,cp,next,nint,regimen,calle,estatus,fecha)
            VALUES ('$rfc','$nombre','$paterno','$materno','$correo','$telefono','$celular','$empresa','$pais','$estado','$municipio','$colonia','$cp','$next','$nint','$regimen','$calle','s','$fech');";
            mysql_query($sql);
            
            echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                        <strong>Cliente / Cliente!</strong> Guardado con Exito</div>';/*}*/
            $contacto='';$correo='';$celular='';$estatus ='';
            $empresa='';$rfc=''; $calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono='';
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
											<p class="black font-weight-bold titulo text-center">NUEVO CLIENTE</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-6">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='clientes.php'">Listado Clientes</button>
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
                                                            <label for="">RFC / CURP</label>
                                                            <input class="form-control" type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15" readonly>
                                                        </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <div class="form-group">
                                                            <label for="">RFC / CURP</label>
                                                            <input class="form-control" type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15">
                                                        </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Apellido Paterno</label>
                                                    <input class="form-control" type="text" name="apat" id="apat" value="<?php echo $apaterno; ?>" maxlength="20" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="">Apellido Materno</label>
                                                        <input class="form-control" type="text" name="amat" id="amat" value="<?php echo $amaterno; ?>" maxlength="20" required>
                                                        
                                            </div>
                                            </div>

                                            <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="">Nombre</label>
                                                        <input class="form-control" type="text" name="nomb" id="nomb" value="<?php echo $contacto; ?>" maxlength="20" required>
                                                        
                                            </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                <label for="">Fecha de Nacimiento</label>
                                                <input class="form-control" type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>" required>
                                                        
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">

                                                <label for="">Lugar de Nacimiento</label>
                                                <input class="form-control" type="text" name="pais" id="pais" value="<?php echo $pais; ?>" maxlength="20">
                                                        
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">

                                                <label for="">Estado</label>
                                                <input class="form-control" type="text" name="estado" id="estado" value="<?php echo $estado; ?>" maxlength="30">
                                                        
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">


                                                <label for="">Municipio</label>
                                                <input class="form-control" type="text" name="municipio" id="municipio" value="<?php echo $municipio; ?>" maxlength="50">
                                                              
                                                </div>
                                            </div>



                                        </div>



                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label for="">Colonia</label>
                                                        <input class="form-control" type="text" name="colonia" id="colonia" value="<?php echo $colonia; ?>" maxlength="100">
                                                        
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label for="">Calle</label>
                                                        <input class="form-control" type="text" name="calle" id="calle" value="<?php echo $calle; ?>" maxlength="100">
                                                        
      
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label for="">Codigo Postal</label>
                                                        <input class="form-control" type="text" name="cp" id="cp" value="<?php echo $cp; ?>" maxlength="10">
                                                        
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">

                                                <label for="">N. Ext</label>
                                                        <input class="form-control" type="text" name="next" id="next" value="<?php echo $next; ?>" maxlength="10">
                                                        
                                                                                                            
                                                </div>
                                            </div>



                                        </div>



                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                <label for="">N. Int</label>
                                                        <input class="form-control" type="text" name="nint" id="nint" value="<?php echo $nint; ?>" maxlength="10">
                                                       
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label for="">Correo</label>
                                                        <input class="form-control" type="email" name="correo" id="correo" value="<?php echo $correo; ?>" >
                                                        
      
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">

                                                <label for="">Contacto / Negocio</label>
                                                        <input class="form-control" type="text" name="contacto" id="contacto" value="<?php echo $contacto; ?>" maxlength="50">
                                                       
                                                
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Teléfono de contacto</label>
                                                    <input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" maxlength="10">                                       
                                                </div>
                                            </div>



                                        </div>



                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                <label for="">Número de Recargas</label>
                                                        <input class="form-control" type="text" name="celular" id="celular" value="<?php echo $celular; ?>" maxlength="10" pattern="[0-9]{10}">
                                                        
 
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">

                                                
                                                <label for="">Regimen</label>
                                                        <input class="form-control" type="text" name="regimen" id="regimen" value="<?php echo $regimen; ?>" maxlength="50">


      
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <br>

                                                <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button><br>
                                                        <?php if($boton=='Actualizar Cliente'){ ?><br> <a href="crear_clientes.php" class="btn btn-large btn-danger">Cancelar</a><?php }  ?>

                                                
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">

                                                </div>
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



<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Recordar Contraseña</h3>
        </div>
        <div class="modal-body">
        <p><?php echo $nombre; ?></p>
        <p>Contraseña:<strong> <?php echo $dato['con']; ?></strong></p>
        </div>
        <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
