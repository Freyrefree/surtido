<?php
    session_start();
    include('php_conexion.php'); 
    $usu=$_SESSION['username'];
    $tipo_usu=$_SESSION['tipo_usu'];
    if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
        header('location:error.php');
    }
        $codigo = genera();

    //-------------------------------------------------------
    function genera(){
        $can=mysql_query("SELECT MAX(id)as numero FROM unidad_medida");
        if($dato=mysql_fetch_array($can)){
            $id=$dato['numero']+1;
        }//genera codigo autimaticamente
        return $id;
    }

    $nombre='';$abreviatura='';$equivalente='';$descripcion='';
    if(!empty($_GET['codigo'])){    
        $codigo=$_GET['codigo'];
        $can=mysql_query("SELECT * FROM unidad_medida where id='$codigo'");
        if($dato=mysql_fetch_array($can)){
            $codigo=$dato['id'];$nombre=$dato['nombre'];$abreviatura=$dato['abreviatura'];$descripcion=$dato['descripcion'];
            $equivalente=$dato['equivalencia'];
            $boton="Actualizar Unidad";   
        }
    }else{
        $boton="Guardar Unidad";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Unidad Medida</title>

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
											<p class="black font-weight-bold titulo text-center">UNIDAD DE MEDIDA</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='UnidadMedida.php'">Listado</button>
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">

                                            
                                        </div>
                                        <div class="col-md-3">

                    

                                        </div>
                                    </div>

                                    <?php 
                                    if(!empty($_POST['codigo']) and !empty($_POST['nombre'])){

                                        $codigo=$_POST['codigo'];
                                        $nombre=strtoupper($_POST['nombre']);
                                        $equivalente=strtoupper($_POST['equivalente']);
                                        $descripcion=strtoupper($_POST['descripcion']);
                                        $abreviatura=strtoupper($_POST['abreviatura']);

                                        $can=mysql_query("SELECT * FROM unidad_medida where id='$codigo'");
                                        if($dato=mysql_fetch_array($can)){
                                            if($boton=='Actualizar Unidad'){
                                                $xSQL="UPDATE unidad_medida SET nombre='$nombre',
                                                                                abreviatura='$abreviatura',
                                                                                descripcion='$descripcion',
                                                                                equivalencia='$equivalente'
                                                                    WHERE id='$codigo'";
                                                mysql_query($xSQL); 
                                                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                                                        <strong>Unidad de Medida</strong> Actualizado con Exito</div>';
                                                }else{
                                                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El codigo identificador ya existe '.$dato['nombre'].'</div>';
                                            }       
                                        }else{
                                            $sql = "INSERT INTO unidad_medida (id, nombre, abreviatura, descripcion, equivalencia)
                                                            VALUES ('$codigo','$nombre','$abreviatura','$descripcion','$equivalente')";
                                                mysql_query($sql);
                                                
                                                $nombre='';$equivalente='';$descripcion='';$abreviatura='';
                                                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                                                        <strong>Unidad de Medida</strong> Guardado con Exito</div>';
                                                $codigo = genera();      
                                                }
                                            }
                                    ?>

<hr>
                                    <div class="row">                                    
                                      <div class="col-md-3">
                                      <form name="form1" method="post" action="">
                                        <label for="">Codigo</label>
                                        <input class="form-control" type="text" name="codigo" id="codigo" <?php if(!empty($codigo)){echo 'readonly';} ?> value="<?php echo $codigo; ?>">
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Nombre Unidad de Medida</label>
                                        <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" required maxlength="40">
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Abreviatura</label>
                                        <input class="form-control" type="text" name="abreviatura" id="abreviatura" value="<?php echo $abreviatura; ?>" autocomplete="off" required maxlength="10">
                                      </div>
                                      <div class="col-md-3">
                                        <label for="">Equivalente</label>
                                        <input class="form-control" type="text" name="equivalente" id="equivalente" value="<?php echo $equivalente; ?>" autocomplete="off" required maxlength="50">
                                      </div>
                                      
                                    </div>
                                    <div class="row">
                                      <div class="col-md-3">

                                        <label for="">Descripcion</label>
                                        <textarea class="form-control" name="descripcion" id="descripcion" cols="20" rows="10" value="" maxlength="280"><?php echo $descripcion; ?></textarea>
                                       
                                      </div>
                                      <div class="col-md-3">
                                        
                                      </div>
                                      <div class="col-md-3">
                                        
                                      </div>
                                      <div class="col-md-3"><br>
                                        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                                        <?php if($boton=='Actualizar Unidad'){ ?> <a href="UnidadMedida.php" class="btn btn-danger">Cancelar</a><?php }  ?>
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