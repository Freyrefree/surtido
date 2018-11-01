<?php
		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        $id_sucursal = $_SESSION['id_sucursal'];
        $identifi = $_POST['identificador'];
        //echo $identifi;
        $codbar = $_GET['nombre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Orden de Compra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>
    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>
    <script src="js/jquery-barcode.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/jspdf.debug.js"></script>
    <script>
        var unicodigo = "<?= $codbar; ?>";
        //var codigo = <?= $_POST['codigo']; ?> 
        if (unicodigo != "") {
            document.getElementById("nombre").autofocus = false;
            alert(unicodigo);
        }
        
    </script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <style>
        .codebar{
            border: 1px;
            border-style: solid;
            border-color: #000;
            margin-left: 30px;
            margin-bottom: 0px;
            margin-right: 10px;
            padding: 5px;
        }
        .hr{
            /* background: blue; */
            margin-bottom: -20px;
        }
        .thumb{
             height: 140px;
             width: 200px;
             border: 1px solid #000;
             margin: 5px 5px 0 0;
        }
        .panel-compra{
            padding-left: 10px;
            padding-top: 10px;
          border-style: solid;
          border-color: #BDBDBD;
          border-top-width: 1px;
          border-right-width: 1px;
          border-bottom-width: 1px;
          border-left-width: 1px;
        }
        /* .incd{
            margin-top: 20px;
        } */
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="80%" border="0" class="table">
<tr>
  <td colspan="3">
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='compras.php'">Lista Compras</button>
    </div>
    </td>
</tr>
  <tr class="info">
    <td colspan="4"><center><strong>Nueva orden de compra</strong></center></td>
  </tr>
   <tr>
    <td colspan="3">
    <?php 
		
		//if(!empty($_POST['ccodigo']) or !empty($_GET['codigo'])){	
			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$codigo='';
			$venta='0';$cprov='';$unidad='';
			$fechax=date("d").'/'.date("m").'/'.date("Y");
			$fechay=date("Y-m-d");
            //$nuevacantidad = '0';
            
			if(!empty($_GET['nombre'])){
				$nombre=$_GET['nombre'];
			}
			$can=mysql_query("SELECT * FROM producto where (nom='$nombre' OR cod = '$nombre') AND id_sucursal = '$id_sucursal'");
			if($dato=mysql_fetch_array($can)){
                $codigo = $dato['cod'];
				$prov=$dato['prov'];
				$cprov=$dato['cprov'];
				$nom=$dato['nom'];
				$costo=$dato['costo'];
				$mayor=$dato['mayor'];
				$venta=$dato['venta'];
				$cantidad=$dato['cantidad'];
				$minimo=$dato['minimo'];
				$seccion=$dato['seccion'];
                $unidad=$dato['unidad'];
                $id_comision = $dato['id_comision'];
                $con=mysql_query("SELECT * FROM comision where id_comision = '$id_comision'");
                if($dat=mysql_fetch_array($con)){
                    $tipo_comision = $dat['tipo'];
                }
                $queryun=mysql_query("SELECT * FROM unidad_medida WHERE id=$unidad");
                while($dato=mysql_fetch_array($queryun)){
                    $textounidad = $dato['abreviatura'];
                }
				$boton="Guardar Compra";
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  Producto / Articulo:<strong> '.$nom.' </strong> codigo<strong> '.$codigo.'
					</strong></div>';	
			}else{
				$boton="";
			}
            //nueva entrada de identificador unico  del producto atual
            if (!empty($_POST['identificador'])) {
                $identificador = $_POST['identificador'];
                if (empty($codigo)) {
                    echo '  <div class="alert alert-warning">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>!Codigo producto no existe¡</strong>
                                </div>';
                }else {
                    $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                    if($row=mysql_fetch_array($queryi)){
                        echo '  <div class="alert alert-warning">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>! Identificador unico Existente ¡</strong>
                                </div>';
                        $nuevacantidad = $_POST['nuevacantidad'];
                    }else {
                        
                        $nuevacantidad = $_POST['nuevacantidad'] + 1;

                        $sqlc = "INSERT INTO codigo_producto (id_producto,identificador,fecha, estado,id_sucursal)
                                    VALUES ('$codigo','$identificador',NOW(),'s','$id_sucursal')";
                        $answ = mysql_query($sqlc);
                    }
                }
            }
            //-----------------------------------------------------------------
	?>
    <!-- <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert">X</button>
      <strong>! Validacion identificador exixtente  pendiente si exite no aumentar el numero entrate¡</strong>
    </div> -->
    </td>    
    <div class="control-group info">
    <tr>
        <td width="19%">
            <form name="form1" method="get" action="">
                    <label>Nombre ó Codigo Producto: </label>
                    <label>
                      <input type="text" autofocus class="input-xlarge" id="nombre" name="nombre" list="characters" placeholder="Nombre ó Codigo Producto" autocomplete="off">
                          <datalist id="characters">
                          <?php 
                          $can=mysql_query("SELECT * FROM producto WHERE estado = 's' and id_sucursal = '$id_sucursal'");
                          while($dato=mysql_fetch_array($can)){
                              echo '<option value="'.$dato['nom'].'">';
                              $codigo11 = $dato['cod'];
                              }
                          ?>
                        </datalist>
                    </label>
                </form>
        <form name="form2" method="post" enctype="multipart/form-data" action="">
        	<label>* Codigo: </label><input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
            <input type="text" name="nom" id="nom" style="visibility:hidden; display:none;" value="<?php echo $nom; ?>" ><!--  -->
            <label>Precio Costo</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="costo" id="costo" value="<?php echo $costo; ?>" required readonly> 
                <span class="add-on">.00</span>
            </div>
            <label>Precio Mayoreo: </label>
             <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="mayor" id="mayor" value="<?php echo $mayor; ?>" required readonly>
                <span class="add-on">.00</span>
            </div>
            <label>Precio Venta: </label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="venta" id="venta" value="<?php echo $venta; ?>" required readonly> 
                <span class="add-on">.00</span>
            </div>
            <br><br>
                <button type="submit" class="btn btn-large btn-primary"><?php echo $boton; ?></button>
        </td>
        <td width="10%">
            <label>Fecha de Compra: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fechay; ?>" required>
            <label>Cantidad Actual: </label>
            <div class="input-prepend input-append">
            <input type="text" name="cantact" id="cantact" value="<?php echo $cantidad; ?>" required maxlength="25" readonly>
            <span class="add-on"><?php echo $textounidad; ?>'s</span>
            </div>
            <label>* Nueva Cantidad: </label><input type="text" name="cantidad" id="cantidad" value="<?php echo $nuevacantidad; ?>" required <?php if ($tipo_comision == "TELEFONO" || $tipo_comision == "FICHA" || $tipo_comision == "CHIP") { echo "readonly"; }?>  maxlength="25">
            <label>* Orden de Compra: </label><input type="text" name="remision" id="remision" maxlength="25" required>
            <label for="textfield">Comprobantes Digitales: </label><input type="file" multiple="true" id="archivo" name="archivo[]">
        </form>
        </td>
        <?php if ($tipo_comision == "TELEFONO" || $tipo_comision == "FICHA" || $tipo_comision == "CHIP") { ?>
        <td>
            <div class="control-group info">
            <?php 
            /*if (!empty($_POST['identificador'])) {
                $identificador = $_POST['identificador'];
                if (empty($codigo)) {
                    echo '  <div class="alert alert-warning">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>!Codigo no existe¡</strong>
                                </div>';
                }else {
                    $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                    if($row=mysql_fetch_array($queryi)){
                        echo '  <div class="alert alert-warning">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>! Identificador Existente ¡</strong>
                                </div>';
                    }else {
                        if (!empty($_POST['identificador'])) {
                        $nuevacantidad = $_POST['nuevacantidad'] + 1;
                        }
                        $sqlc = "INSERT INTO codigo_producto (id_producto,identificador,fecha, estado,id_sucursal)
                                    VALUES ('$codigo','$identificador',NOW(),'s','$id_sucursal')";
                        $answ = mysql_query($sqlc);
                    }
                }
            }*/
             ?>
            <form name="form1" method="post" action="">
                <div class="input-append hr">
                     <input type="hidden" id="nuevacantidad" name="nuevacantidad" value="<?php echo $nuevacantidad; ?>">
                     <input class="span2 incd" autofocus id="identificador" name="identificador" type="text" placeholder="Identificador Unico" maxlength="20" >
                     <button class="btn incd btn-primary" id="btnc" onclick="idetity();" type="submit">Registrar</button>
                </div>
            </form>
            </div>
            <div style="width: 95%; height: 310px; overflow-y: scroll;">
            <table width="70%" border="0" class="table">
              <tr>
                <td width="20%"><strong><center>CODIGO</center></strong></td>
                <td width="30%"><strong>IDENTIFICADOR</strong></td>
                <td width="30%"><center><strong>ESTADO</strong></center></td>
              </tr>
              <?php 
                $con=mysql_query("SELECT * FROM codigo_producto WHERE id_producto = '$codigo;' AND id_sucursal = '$id_sucursal'");
                while($fila=mysql_fetch_array($con)){
                    $nombre=$fila['nombre'];
                    if($fila['estado']=="n"){
                        $estado='<span class="label label-important">Error</span>';
                    }else{
                        $estado='<span class="label label-success">Correcto</span>';
                    }
              ?>
              <tr>
                <td><?php echo $fila['id_producto'];; ?></td>
                <td><?php echo $fila['identificador'] ?></td>
                <td><center><?php echo $estado; ?></center></td>
              </tr>
              <?php } ?>
            </table>
            </div>
        </td>
        <?php } ?>
	</tr>
    </div>
	<?php //} ?>  
  </table>
   <?php 
		if(!empty($_POST['codigo'])){
			$gnom=$_POST['nom'];		$gfecha=$_POST['fecha'];
			$gcodigo=$_POST['codigo'];	$gcantidad=$_POST['cantidad']+$_POST['cantact'];
            $gcosto=$_POST['costo'];    $ncantidad=$_POST['cantidad'];
            $gmayor=$_POST['mayor'];    $remision = $_POST['remision'];
            $gventa=$_POST['venta'];        
            $gminimo=$_POST['minimo'];  

            $can=mysql_query("SELECT * FROM producto where cod='$gcodigo' AND id_sucursal = '$id_sucursal'");
                if($dato=mysql_fetch_array($can)){
                    $nombre_archivo == "";$nombres_archivos="";
                    for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
                        {
                            /* Lectura del archivo */
                            $nombre_archivo = $_FILES['archivo']['name'][$i];
                            $tipo_archivo   = $_FILES['archivo']['type'][$i];
                            $tamano_archivo = $_FILES['archivo']['size'][$i];
                            $tmp_archivo    = $_FILES['archivo']['tmp_name'][$i];

                            if ($nombre_archivo != "" and !empty($remision)) {
                            $nom_arch = $nombre_archivo;
                            //Guardar el archivo en la carpeta doc_compra/numero_remision
                            $num_compra=$remision;
                            if($tamano_archivo!=0){
                                $ruta_pancarta="doc_compra/".$num_compra;
                                $archivador="doc_compra/".$num_compra;
                                $dir_logo=$archivador."/".$nombre_archivo;
                                mkdir("doc_compra/$num_compra",0700);
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
                        //echo $nombres_archivos;
                        if ($ncantidad != 0 && $ncantidad != "") {
                            if (!empty($remision)) {//$nombre_archivo != "" and 
                                //----------------insetar en la base de datos compras-----------------------
                                $sqlc = "INSERT INTO compras (id_producto,nom_producto,num_remision, cantidad, fecha, costo, venta, dir_file)
                                     VALUES ('$gcodigo','$gnom','$remision','$ncantidad','$gfecha','$gcosto','$gventa','$nombres_archivos')";
                                mysql_query($sqlc);
                                //-----------------------------------------------------------------------------------
                            }
                        	 $sql="UPDATE producto SET  costo='$gcosto',
                        								mayor='$gmayor',
                        								venta='$gventa',
                        								cantidad='$gcantidad',
                        								fecha='$gfecha'
                        					      WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                        		mysql_query($sql);
                        		echo '	<div class="alert alert-success">
                        				  <button type="button" class="close" data-dismiss="alert">X</button>
                        				  <strong>Compra / Articulo '.$gnom.' </strong> Realizado con Exito!
                        			</div>';
                			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$fecha='';
                            $codigo='';$venta='0';$cprov='';$costo = "";$mayor = "";$venta ="";
                        }else {
                            echo '  <div class="alert alert-success">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>Debe agregar Cantidad / Articulo </strong>
                                    </div>';
                        }
			}else{
                
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Debes Seleccionar un Producto / Articulo </strong>
						</div>';
			}
		}
        
		?>

</div>
</body>
</html>