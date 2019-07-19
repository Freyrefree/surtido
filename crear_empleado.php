<?php
        session_start();
        include('php_conexion.php');
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if($_SESSION['tipo_usu']!='a'){
            header('location:error.php');
        }
        //-------------------------------------------------------
        $can=mysql_query("SELECT MAX(ced)as numero FROM usuarios");
        if($dato=mysql_fetch_array($can)){
            $numero=$dato['numero']+1;
        } //genera codigo autimaticamente
        $sucursal = $_SESSION['id_sucursal'];
        $nombre_sucursal = $_SESSION['sucursal'];
        $cedula=''; $nombre='';$usuarioA='';$ciudad='';$direccion='';$telefono='';$celular='';$tipo='';$barrio='';$sexo='';$sueldo='';
        if(!empty($_GET['codigo'])){    
            $codigo=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM usuarios where ced='$codigo'");
            if($dato=mysql_fetch_array($can)){
                $cedula=$dato['ced'];$nombre=$dato['nom'];$usuarioA=$dato['usu'];$ciudad=$dato['ciudad'];$direccion=$dato['dir'];
                $telefono=$dato['tel'];$celular=$dato['cel'];$tipo=$dato['tipo'];$barrio=$dato['barrio'];$sueldo=$dato['sueldo'];
                $sexo=$dato['sexo'];$sucursal = $dato['id_sucursal'];
                $boton="Actualizar Empleado";
                $password   = $dato['con'];
                $correo     = $dato['correo'];
                /*echo "<script>alert('".$dato['tipo']."');</script>";*/
            }
        }else{
            $boton="Guardar Empleado";
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
                                            <button type="button" class="btn btn-info" onClick="window.location='empleado.php'">Listado</button>
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">
                                          
                                        </div>
                                    </div>

                                    <?php 
    if(!empty($_POST['cedula']) and !empty($_POST['nombre']) and !empty($_POST['usuario'])){// and !empty($_POST['tipo'])
        
        $cedula=strtoupper($_POST['cedula']);$nombre=strtoupper($_POST['nombre']);$usuarioA=strtoupper($_POST['usuario']);$ciudad=strtoupper($_POST['ciudad']);$sueldo=$_POST['sueldo'];
        $direccion=strtoupper($_POST['direccion']);$telefono=$_POST['telefono'];$celular=$_POST['celular'];$tipo=$_POST['tipo'];$barrio=strtoupper($_POST['barrio']);
        $sexo=strtoupper($_POST['sexo']);$usuarioc=strtoupper($_POST['usuario']);$sucursal = $_POST['sucursal'];
        $correoPOST = $_POST['correo']; 
        if (empty($_POST['tipo'])) {
            $tipo="a";
        }
        if ($_POST['tipo'] == "su") {
            //$tipo = "ca";
            $id_sucursal = "";
        }
        $can=mysql_query("SELECT * FROM usuarios where ced='$cedula'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Empleado'){
                $xSQL="UPDATE usuarios SET  nom='$nombre',
                                            dir='$direccion',
                                            tel='$telefono',
                                            cel='$celular',
                                            cupo='$cupo',
                                            barrio='$barrio',
                                            ciudad='$ciudad',
                                            tipo='$tipo',
                                            sueldo='$sueldo',
                                            sexo='$sexo',
                                            id_sucursal='$sucursal',
                                            correo  = '$correoPOST'
                                WHERE ced='$cedula'";
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Empleado</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de documento ingreso le pertenece al Empleado '.$dato['nom'].'</div>';
            }       
        }else{
            if (preg_match("/\\s/", $usuarioA)){ 
                echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error!</strong> No se permiten espacios en la cuenta de Empleado.</div>';$usuarioA='';
                }else{
                    $sql = "INSERT INTO usuarios (ced, estado, nom, dir, tel, cel, barrio, ciudad, usu, con, tipo, sueldo, sexo, id_sucursal, correo)
                             VALUES ('$cedula','s','$nombre','$direccion','$telefono','$celular','$barrio','$ciudad','$usuarioA','$usuarioc',
                                '$tipo','$sueldo','$sexo','$sucursal','$correoPOST')";
                    mysql_query($sql);
                
                $cedula=''; $nombre='';$usuarioA='';$ciudad='';$sueldo='';$direccion='';$telefono='';$celular='';$tipo='';$barrio='';$sexo='';$correoPOST = '';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Usuario / Empleado!</strong> Guardado con Exito</div>';
                      }
                  }
              }
?>
<hr>
                                    <div class="row">
                                      <div class="col-md-3">
                                      <form name="form1" method="post" action="">
                                        <label for="">CURP</label>
                                        <input class="form-control" type="text" name="cedula" id="cedula" <?php if(!empty($cedula)){echo 'readonly';} ?> value="<?php echo $cedula; ?>" maxlength="20" required>
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Nombre y Apellido</label>
                                        <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" maxlength="50" required>  
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Sueldo</label>
                                        <input class="form-control" type="number" name="sueldo" id="sueldo" value="<?php echo $sueldo; ?>" autocomplete="off" required> 
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Cuenta de Usuario</label>
                                        <input class="form-control" type="text" name="usuario" id="usuario" value="<?php echo $usuarioA; ?>" <?php if(!empty($usuarioA)){echo 'readonly';} ?> autocomplete="off" maxlength="30" required>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-3">
                                        <label for="radio">Sexo:</label>
       
                                        <label class="radio">
                                        <input type="radio" name="sexo" id="optionsRadios1" value="H" <?php if($sexo=="h" OR $sexo=="H"){ echo 'checked'; } if(empty($_GET['codigo'])){ echo 'checked';} ?>>Hombre
                                        </label>

                                        <label class="radio">
                                        <input type="radio" name="sexo" id="optionsRadios2" value="M" <?php if($sexo=="m" OR $sexo=="M"){ echo 'checked'; } ?>>Mujer
                                        </label>

                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Ciudad</label>
                                        <input class="form-control" type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" autocomplete="off" maxlength="30" required> 
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Direccion / Calle</label>
                                        <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>" autocomplete="off" required maxlength="100">
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Barrio / Localidad</label>
                                        <input class="form-control" type="text" name="barrio" id="barrio" value="<?php echo $barrio; ?>" autocomplete="off" maxlength="100">                                         
                                      </div>
                                    </div>

                                    <div class="row">
										<div class="col-md-3">
                                            <label for="">Telefono</label>
                                            <input class="form-control" type="text" minlength="10" maxlength="10" name="telefono" id="telefono" value="<?php echo $telefono; ?>"autocomplete="off" pattern="[0-9]{10}" required>
										</div>
                                        <div class="col-md-3">
                                            <label for="">Celular / Mobil</label>
                                            <input class="form-control" type="text" name="celular" id="celular" value="<?php echo $celular; ?>" autocomplete="off"  pattern="[0-9]{10}" minlength="10" maxlength="10">
										</div>
                                        <div class="col-md-3">
                                            <label for="">Correo</label>
                                            <input class="form-control" type="email" name="correo" id="correo" value="<?php echo $correo; ?>" required>
										</div>
                                        <div class="col-md-3">
                                            <label>Sucursal</label>
                                            <select class="form-control" name="sucursal" id="sucursal">
                                            <?php 
                                                $can=mysql_query("SELECT * FROM empresa");
                                                while($dato=mysql_fetch_array($can)){
                                            ?>
                                            <option value="<?php echo $dato['id']; ?>" <?php if($sucursal==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
                                            <?php } ?>
                                            </select>
										</div>
									</div>

                                    <div class="row">
										<div class="col-md-3">
                                            <?php
                                                if ($tipo == 'a')$visible = 'hidden';
                                                else$visible = '';
                                            ?>
                                            <label for="radio" style="visibility:<?php echo $visible ?>" >Tipo de Empleado</label>

                                            <label class="radio" style="visibility:<?php echo $visible ?>">
                                            <input type="radio"   name="tipo" id="optionsRadios1" value="ca" <?php if($tipo=="ca"){ echo 'checked'; } if(empty($_GET['codigo'])){ echo 'checked';} ?>>Cajero
                                            </label><br>

                                            <label class="radio" style="visibility:<?php echo $visible ?>">
                                            <input type="radio"   name="tipo" id="optionsRadios2" value="te" <?php if($tipo=="te"){ echo 'checked'; } ?>>Tecnico
                                            </label><br>

                                            <label class="radio" style="visibility:<?php echo $visible ?>">
                                            <input type="radio"   name="tipo" id="optionsRadios2" value="su" <?php if($tipo=="su"){ echo 'checked'; } ?>>Supervisor
                                            </label>

										</div>
                                        <div class="col-md-3">

										</div>
                                        <div class="col-md-3"><br>

                                        <?php 
                                        if($boton=='Actualizar Empleado' and $tipo_usu=='a'){ ?>
                                            <a href="#myModalA" role="button" class="btn btn-info" data-toggle="modal">Ver Contraseña</a>
                                        <?php } ?>

										</div>
                                        <div class="col-md-3"><br>

                                            <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                                            <?php if($boton=='Actualizar Empleado'){ ?> <a href="crear_empleado.php" class="btn btn-danger">Cancelar</a><?php }  ?>
                                        </form>
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



<!-- Modal -->
<div id="myModalA" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recordar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p><?php echo $nombre; ?></p>
            <p>Contraseña:<strong> <?php echo $password; ?></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>
