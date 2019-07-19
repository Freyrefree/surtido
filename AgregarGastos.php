<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $sucursal = $_SESSION['sucursal'];
        //-------------------------------------------------------
        function generaid(){
            $can=mysql_query("SELECT MAX(id_gasto)as numero FROM gastos");
            if($dato=mysql_fetch_array($can)){
                $numero=$dato['numero']+1;
            } //genera codigo autimaticamente
            return $numero;
        }

        $id_gasto='';$id_camion='';$concepto='';$num_factura='';$fecha='';$total='';$iva='';$descripcion='';$nom_arch="";
        if(!empty($_GET['codigo'])){    
            $id_gasto=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM gastos where id_gasto='$id_gasto'");
            if($dato=mysql_fetch_array($can)){

                $id_gasto=$dato['id_gasto'];$concepto=$dato['concepto'];$num_factura=$dato['numero_fact'];$fecha=$dato['fecha'];
                $total=$dato['total'];$iva=$dato['iva'];$descripcion=$dato['descripcion'];$nom_arch=$dato['documento'];
                $id_camion=$dato['camion'];
                $boton="Actualizar Gasto";
            }
        }else{
            $boton="Guardar Gasto";
            $id_gasto = generaid();
            $fecha=date("Y-m-d");
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agregar Gasto</title>
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
        /* Extra */
        input{
        text-transform:uppercase;
        }

        </style>


</head>
<?php include_once "layout.php"; ?>
<body>




</head>
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
                          <div class="col-md-6">  
                        
                            <a href="Gastos.php" class="btn btn-info">Listado gastos</a>
                         
                          </div>

                          <div class="col-md-2">                        
                          
                          
                          </div>

                          <div class="col-md-4">

            
                            
                          </div>

                      </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">

                                        <?php
    if(!empty($_POST['id']) and !empty($_POST['concepto']) and !empty($_POST['factura'])){// and !empty($_POST['tipo'])
        
        $id_gasto=$_POST['id'];$concepto=strtoupper($_POST['concepto']);$num_factura=$_POST['factura'];$fecha=$_POST['fecha'];
        $total=$_POST['total'];$iva=$_POST['iva'];$descripcion=strtoupper($_POST['descripcion']);
        $id_camion = $_POST['camion'];$id_suc = $_POST['sucursal'];
        $can=mysql_query("SELECT * FROM gastos where id_gasto='$id_gasto'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Gasto'){
                $nombre_archivo == "";$nombres_archivos="";

                for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
                    {
                        /* Lectura del archivo */
                        $nombre_archivo = $_FILES['archivo']['name'][$i];
                        $tipo_archivo   = $_FILES['archivo']['type'][$i];
                        $tamano_archivo = $_FILES['archivo']['size'][$i];
                        $tmp_archivo    = $_FILES['archivo']['tmp_name'][$i];

                        if ($nombre_archivo != "" and !empty($id_gasto)) {
                        $nom_arch = $nombre_archivo;
                        //Guardar el archivo en la carpeta doc_gasto/id_gasto
                        $num_compra=$id_gasto;
                        if($tamano_archivo!=0){
                            $ruta_pancarta="doc_gasto/".$num_compra;
                            $archivador="doc_gasto/".$num_compra;
                            $dir_logo=$archivador."/".$nombre_archivo;
                            mkdir("doc_gasto/$num_compra",0700);
                            if(!move_uploaded_file($tmp_archivo,$dir_logo)) { $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');}
                            if(!copy($dir_logo,$archivador."/".$nombre_archivo)){ 
                                if (count($_FILES["archivo"]["name"]) > $i) {
                                    if ($i>=1) {
                                        $nombres_archivos = $nombres_archivos.",".$nombre_archivo;
                                    }else{
                                        $nombres_archivos = $nombre_archivo;
                                    }
                                }else{
                                    $nombres_archivos=$nombre_archivo;
                                }
                            }
                        }
                    }
                    }
            $xSQL="UPDATE gastos SET    id_camion = '$id_camion',
                                        concepto='$concepto',
                                        numero_fact='$num_factura',
                                        fecha='$fecha',
                                        total='$total',
                                        iva='$iva',
                                        descripcion='$descripcion',
                                        documento='$nom_arch',
                                        id_sucursal = '$id_suc'
                                WHERE id_gasto='$nombres_archivos'";
                
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Gasto</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de gasto le pertenece a '.$dato['id_gasto'].'</div>';
            }       
        }else{
                $nombre_archivo == "";$nombres_archivos="";
                for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
                    {
                        /* Lectura del archivo */
                        $nombre_archivo = $_FILES['archivo']['name'][$i];
                        $tipo_archivo   = $_FILES['archivo']['type'][$i];
                        $tamano_archivo = $_FILES['archivo']['size'][$i];
                        $tmp_archivo    = $_FILES['archivo']['tmp_name'][$i];

                        if ($nombre_archivo != "" and !empty($id_gasto)) {
                        $nom_arch = $nombre_archivo;
                        //Guardar el archivo en la carpeta doc_gasto/id_gasto
                        $num_compra=$id_gasto;
                        if($tamano_archivo!=0){
                            $ruta_pancarta="doc_gasto/".$num_compra;
                            $archivador="doc_gasto/".$num_compra;
                            $dir_logo=$archivador."/".$nombre_archivo;
                            mkdir("doc_gasto/$num_compra",0700);
                            if(!move_uploaded_file($tmp_archivo,$dir_logo)) { $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');}
                            if(!copy($dir_logo,$archivador."/".$nombre_archivo)){ 
                                if (count($_FILES["archivo"]["name"]) > $i) {
                                    if ($i>=1) {
                                        $nombres_archivos = $nombres_archivos.",".$nombre_archivo;
                                    }else{
                                        $nombres_archivos = $nombre_archivo;
                                    }
                                }else{
                                    $nombres_archivos=$nombre_archivo;
                                }
                            }
                        }
                    }
                    }
                $sql = "INSERT INTO gastos (id_camion,concepto, numero_fact, fecha, total, iva, descripcion,documento,id_sucursal)
                         VALUES ('$id_camion','$concepto','$num_factura','$fecha','$total','$iva','$descripcion','$nombres_archivos','$id_suc')";
                mysql_query($sql);
                $id_gasto=''; $concepto='';$num_factura='';$fecha='';$total='';$iva='';$descripcion='';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Gasto!</strong> Guardado con Exito</div>';
                    $id_gasto = generaid();
                  }
              }
    ?>

										</div>
									</div>

                                    <div class="row">
                                    <div clas="col-md-12">

                                    <div class="row">
                                    
                                        <div class="col-md-3">
                                        <form name="form1" enctype="multipart/form-data" method="post" action="">
                                            <label for="">Identificador</label>
                                            <input class="form-control" type="text" name="id" id="id" <?php if(!empty($id_gasto)){echo 'readonly';} ?> value="<?php echo $id_gasto; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Camion (Placa)/Otro</label>
                                            <select class="form-control" name="camion" id="camion">
                                                <option value="0">Otro</option>
                                                <?php 
                                                    $can=mysql_query("SELECT * FROM camion");
                                                    while($dato=mysql_fetch_array($can)){
                                                ?>
                                                <option value="<?php echo $dato['id']; ?>" <?php if($prov==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['placa']; ?></option>
                                                <?php } ?>
                                            </select>                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Concepto</label>
                                            <input class="form-control" type="text" name="concepto" id="concepto" value="<?php echo $concepto; ?>" autocomplete="off" maxlength="30" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Número de Factura</label>
                                            <input class="form-control" type="text" name="factura" id="factura" value="<?php echo $num_factura; ?>" autocomplete="off" maxlength="30" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Total</label>
                                            <input class="form-control" type="text" name="total" id="total" value="<?php echo $total; ?>" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Sucursal</label>
                                            <select class="form-control" name="sucursal" id="sucursal" required>
                                                <option value="">Selecciona sucursal</option>
                                                <?php 
                                                    $can=mysql_query("SELECT * FROM empresa");
                                                    while($dato=mysql_fetch_array($can)){
                                                ?>
                                                <option value="<?php echo $dato['id']; ?>" <?php if($prov==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
                                                <?php } ?>
                                            </select>                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Fecha</label>
                                            <input class="form-control" type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>">                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Importe de Iva</label>
                                            <input class="form-control" type="text" name="iva" id="iva" value="<?php echo $iva; ?>" autocomplete="off" required maxlength="100" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Descripcion</label>
                                            <textarea class="form-control" name="descripcion" id="descripcion" cols="20" rows="10" value="" maxlength="300"><?php echo $descripcion; ?></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Comprobantes Digitales: </label>
                                            <input class="form-control" type="file" multiple="true" id="archivo" name="archivo[]">                                        
                                        </div>
                                        <div class="col-md-3">

                                        
                                        </div>
                                        <div class="col-md-3"><br>

                                        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
                                        <?php if($boton=='Actualizar Gasto'){ ?> <a href="AgregarGastos.php" class="btn btn-danger">Cancelar</a><?php }  ?>
                                        </form>
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
<script>
        //Mostrar automaticamente el iva al 16%
        //-------------------------------------------------------------------------------------------------------
        $(document).ready(function(){
                $('#total').keyup(function(event){
                  var valor = $('#total').val();
                  var iva = valor*0.16;
                  document.getElementById('iva').value =iva.toFixed(2);
                });
            });
        //--------------------------------------------------------------------------------------------------------
    </script>

