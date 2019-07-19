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
            $can=mysql_query("SELECT MAX(id_comision)as numero FROM comision");
            if($dato=mysql_fetch_array($can)){
                $id=$dato['numero']+1;
            }//genera codigo autimaticamente
            return $id;
        }

        $nombre='';$tipo='';$porcentaje='';$descripcion='';
        if(!empty($_GET['codigo'])){
            $codigo=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM comision where id_comision='$codigo'");
            if($dato=mysql_fetch_array($can)){
                $codigo=$dato['id_comision'];$nombre=$dato['nombre'];$tipo=$dato['tipo'];
                $porcentaje=$dato['porcentaje'];
                $porcentajemay=$dato['porcentajemayoreo'];
                $porcentajeesp=$dato['porcentajeespecial'];
                $descripcion=$dato['descripcion'];
                $boton="Actualizar Comision";
            }
        }else{
            $boton="Guardar Comision";
        }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Comision</title>

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
											<p class="black font-weight-bold titulo text-center">COMISIONES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            <button type="button" class="btn btn-info" onClick="window.location='Comisiones.php'">Listado</button>
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">

                                        </div>
                                    </div>
<hr>
                                        <?php 
                                            if(!empty($_POST['codigo']) and !empty($_POST['nombre'])){

                                                $codigo=$_POST['codigo'];$nombre=strtoupper($_POST['nombre']);$tipo=$_POST['tipo'];
                                                $porcentaje=$_POST['porcentaje'];
                                                $porcentajemaypost=$_POST['porcentajemay'];
                                                $porcentajeesppost=$_POST['porcentajeesp'];
                                                $descripcion=strtoupper($_POST['descripcion']);

                                                $can=mysql_query("SELECT * FROM comision where id_comision='$codigo'");
                                                if($dato=mysql_fetch_array($can)){
                                                    if($boton=='Actualizar Comision'){
                                                        $xSQL="UPDATE comision SET nombre='$nombre',
                                                                                        tipo='$tipo',
                                                                                        porcentaje='$porcentaje',
                                                                                        porcentajemayoreo='$porcentajemaypost',
                                                                                        porcentajeespecial='$porcentajeesppost',
                                                                                        descripcion='$descripcion'
                                                                            WHERE id_comision='$codigo'";
                                                        mysql_query($xSQL); 
                                                        echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                                                                <strong>Comision</strong> Actualizado con Exito</div>';
                                                        }else{
                                                            echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El codigo Comision ya existe '.$dato['nombre'].'</div>';
                                                    }       
                                                }else{
                                                    $sql = "INSERT INTO comision (nombre, tipo, porcentaje, descripcion,porcentajemayoreo,porcentajeespecial)
                                                                    VALUES ('$nombre','$tipo','$porcentaje','$descripcion','$porcentajemaypost','$porcentajeesppost')";
                                                        mysql_query($sql);
                                                        
                                                        $nombre='';$tipo='';$porcentaje='';$descripcion='';
                                                        echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                                                                <strong>Comision</strong> Guardado con Exito</div>';
                                                        $codigo = genera();      
                                                        }
                                                    }
                                        ?>


                                    <div class="row">
                                        <div class="col-md-3">
                                        <form name="form1" method="post" action="">
                                            <label for="">Codigo</label>
                                            <input class="form-control" type="text" name="codigo" id="codigo" <?php if(!empty($codigo)){echo 'readonly';} ?> value="<?php echo $codigo; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Nombre Comision</label>
                                            <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" required maxlength="40">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Tipo:</label>
                                                <select class="form-control" name="tipo" id="tipo">
                                                <option value="TELEFONO"   <?php if($tipo=="TELEFONO"){ echo 'selected'; } ?> >TELEFONIA</option>
                                                <option value="CHIP"       <?php if($tipo=="CHIP"){ echo 'selected'; } ?> >CHIPS</option>
                                                <option value="FICHA"      <?php if($tipo=="FICHA"){ echo 'selected'; } ?> >FICHAS</option>
                                                <option value="ACCESORIO"  <?php if($tipo=="ACCESORIO"){ echo 'selected'; } ?> >ACCESORIOS</option>
                                                <option value="REPARACION" <?php if($tipo=="REPARACION"){ echo 'selected'; } ?> >REPARACIONES</option>
                                                <option value="REFACCION"  <?php if($tipo=="REFACCION"){ echo 'selected'; } ?> >REFACCIONES</option>
                                                <option value="RECARGA"  <?php if($tipo=="RECARGA"){ echo 'selected'; } ?> >TAE</option>
                                            </select>

                                        </div>
                                        <div class="col-md-3">
                                            <label>Porcentaje Público:</label>                                            
                                            <input class="form-control" type="text" name="porcentaje" id="porcentaje" value="<?php echo $porcentaje; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Porcentaje Mayoreo:</label>                                            
                                            <input class="form-control" type="text" name="porcentajemay" id="porcentajemay" value="<?php echo $porcentajemay; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Porcentaje Especial:</label>
                                            <input class="form-control" type="text" name="porcentajeesp" id="porcentajeesp" value="<?php echo $porcentajeesp; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Descripcion</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion"  value="" maxlength="280"><?php echo $descripcion; ?></textarea>
                                        </div>
                                        <div class="col-md-3"><br>
                                            <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                                            <?php if($boton=='Actualizar Comision'){ ?> <a href="Comisiones.php" class="btn btn-danger">Cancelar</a><?php } ?>
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