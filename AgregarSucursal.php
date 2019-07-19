<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        
        $id_sucursal=''; $sucursal='';$numint='';$direccion='';$ciudad='';$telefono='';$web='';$correo='';
        if(!empty($_GET['codigo'])){
            $id_sucursal=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM empresa where id='$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
                $id_sucursal=$dato['id']; $sucursal=$dato['empresa'];$numint=$dato['nit'];
                $direccion=$dato['direccion'];$ciudad=$dato['ciudad'];$telefono=$dato['tel1'];
                $web=$dato['web'];$correo=$dato['correo'];
                $boton="Actualizar Sucursal";
            }
        }else{
            $boton="Guardar Sucursal";
        }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Agregar Sucursal</title>

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
											<p class="black font-weight-bold titulo text-center">SUCURSALES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='Sucursales.php'">Listado</button>
                                        </div>
                                        <div class="col-md-3">                        
                                        </div>
                                        <div class="col-md-3">                         
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div>

                                    <?php
    if(!empty($_POST['id'])){

        $id_sucursal=$_POST['id']; $sucursal=strtoupper($_POST['sucursal']);$numint=$_POST['numint'];
        $direccion=strtoupper($_POST['direccion']);$ciudad=strtoupper($_POST['ciudad']);$telefono=$_POST['telefono'];
        $web=$_POST['web'];$correo=$_POST['correo'];

        $can=mysql_query("SELECT * FROM empresa  where id=$id_sucursal");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Sucursal'){
               $xSQL="UPDATE empresa SET empresa='$sucursal',
                                        nit='$numint',
                                        direccion='$direccion',
                                        ciudad='$ciudad',
                                        tel1='$telefono',
                                        web='$web',
                                        correo='$correo'
                                WHERE id='$id_sucursal'";
                mysql_query($xSQL);
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Sucursal</strong> Actualizado con Exito</div>';
                          /*$id_sucursal='';*/ $sucursal='';$numint='';$direccion='';$ciudad='';$telefono='';$web='';$correo='';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>Identificador Exitente '.$dato['id'].'</div>';
            }       
        }else{
            $sql = "INSERT INTO empresa (id, empresa,nit, direccion, ciudad, tel1, web, correo)
                     VALUES ($id_sucursal,'$sucursal','$numint','$direccion','$ciudad','$telefono','$web','$correo')";
            mysql_query($sql);
            /*$id_sucursal='';*/ $sucursal='';$numint='';$direccion='';$ciudad='';$telefono='';$web='';$correo='';
            echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                      <strong>Sucursal</strong> Guardado con Exito!</div>';
            
        }
        //----------------------------------------------------------------------------
        $extension = end(explode('.', $_FILES['files']['name']));
        $foto = $id_sucursal."."."jpg";
        $directorio = 'img'; //dirname('articulo'); // directorio de tu elección
        
        // almacenar imagen en el servidor
        move_uploaded_file($_FILES['files']['tmp_name'], $directorio.'/'.$foto);
        $minFoto = 'min_'.$foto;
        $resFoto = 'res_'.$foto;
        resizeImagen($directorio.'/', $foto, 65, 65,$minFoto,$extension);
        resizeImagen($directorio.'/', $foto, 500, 500,$resFoto,$extension);
        unlink($directorio.'/'.$foto);
        //---------------------------------------------------------------------------
    }
    ?>
<hr>
                                    <div class="row">

                                      <div class="col-md-3">
                                      <form name="form1" enctype="multipart/form-data" method="post" action="">
                                        <label for="">Identificador: </label>
                                        <input class="form-control" type="text" name="id" id="id" <?php if(!empty($id_sucursal)){echo 'readonly';} ?> value="<?php echo $id_sucursal; ?>" required>  
                                      </div>

                                      <div class="col-md-3">
                                        <label for="">Sucursal: </label>
                                        <input class="form-control" type="text" name="sucursal" id="sucursal" value="<?php echo $sucursal; ?>" autocomplete="off" maxlength="40" required>                      
                                      </div>

                                      <div class="col-md-3">
                                        <label for="">Direccion</label>
                                        <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>" autocomplete="off" maxlength="70" required>                       
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Ciudad</label>
                                        <input class="form-control" type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" autocomplete="off" maxlength="30">                      
                                      </div>

                                    </div>
                                    <div class="row">

                                      <div class="col-md-3">
                                        <label for="">N. Interior</label>
                                        <input class="form-control" type="text" name="numint" id="numint" value="<?php echo $numint; ?>" autocomplete="off" maxlength="6" required>                     
                                      </div>
                                      <div class="col-md-3">                        
                                        <label for="">Telefono</label>
                                        <input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" autocomplete="off" maxlength="15" required>
                                      </div>
                                      <div class="col-md-3">                        
                                        <label for="">Web</label>
                                        <input class="form-control" type="text" name="web" id="web" value="<?php echo $web; ?>" autocomplete="off" maxlength="50" required>
                                      </div>
                                      <div class="col-md-3">                        
                                        <label for="">Correo</label>
                                        <input class="form-control" type="email" name="correo" id="correo" value="<?php echo $correo; ?>" autocomplete="off" maxlength="40" required>
                                      </div>

                                    </div>

                                    <div class="row">

                                      <div class="col-md-3">

                                      <?php if ($id_sucursal == "1") { ?>
                                      <label for="">Logo de Empresa</label>
                                      <output id="list"></output><br>
                                      <input  class="form-control" type="file" name="files" id="files">
                                      <?php } ?>
                    
                                      </div>
                                      <div class="col-md-3">                        
                                        
                                      </div>
                                      <div class="col-md-3">                        

                                      </div>
                                      <div class="col-md-3"><br>
                                        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                                                           
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


<script>
          function archivo(evt) {
              var files = evt.target.files; // FileList object
              // Obtenemos la imagen del campo "file".
              for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                      // Insertamos la imagen
                     document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
              }
          }
          document.getElementById('files').addEventListener('change', archivo, false);
</script>
