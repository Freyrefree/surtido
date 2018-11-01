<?php
		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inventario</title>
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
        .thumb{
             height: 200px;
             border: 1px solid #000;
             margin: 10px 5px 0 0;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="4"><center><strong>Creacion de Productos</strong></center></td>
  </tr>
   <tr>
    <td colspan="3">
    <div class="control-group info">
    <form name="form1" method="post" action="">
    	<div class="input-append">
   			 <input class="span2" id="ccodigo" name="ccodigo" type="text" placeholder="Codigo del Articulo">
    	 	 <button class="btn" type="submit">Confirmar Codigo</button>
   		</div>
    </form>
    </div>
    <?php 
		
		if(!empty($_POST['ccodigo']) or !empty($_GET['codigo'])){	
			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$codigo='';
			$venta='0';$cprov='';
			$fechax=date("d").'/'.date("m").'/'.date("Y");
			$fechay=date("Y-m-d");
			if(!empty($_GET['codigo'])){
				$codigo=$_GET['codigo'];
			}
			if(!empty($_POST['ccodigo'])){
				$codigo=$_POST['ccodigo'];
			}
			$can=mysql_query("SELECT * FROM producto where cod='$codigo'");
			if($dato=mysql_fetch_array($can)){
				$prov=$dato['prov'];
				$cprov=$dato['cprov'];
				$nom=$dato['nom'];
				$costo=$dato['costo'];
				$mayor=$dato['mayor'];
				$venta=$dato['venta'];
				$cantidad=$dato['cantidad'];
				$minimo=$dato['minimo'];
				$seccion=$dato['seccion'];
				$fechay=$dato['fecha'];
				$boton="Actualizar Producto";
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Producto / Articulo '.$nom.' </strong> con el codigo '.$codigo.' ya existe
					</div>';	
			}else{
				$boton="Guardar Producto";
			}
	?>
    </td>    
    <div class="control-group info">
    <form name="form2" method="post" enctype="multipart/form-data" action="">
  	<tr>
    	<td width="24%">
        	<label>Codigo: </label><input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
            <label>Nombre: </label><input type="text" name="nom" id="nom" value="<?php echo $nom; ?>" required>
            <label>Proveedor</label>
            <select name="prov" id="prov">
            <?php 
				$can=mysql_query("SELECT * FROM proveedor where estado='s'");
				while($dato=mysql_fetch_array($can)){
			?>
              <option value="<?php echo $dato['codigo']; ?>" <?php if($prov==$dato['codigo']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
            <?php } ?>
            </select>
            <label>Cod. Articulo del Proveedor: </label><input type="text" name="cprov" id="cprov" value="<?php echo $cprov; ?>" required>
            <label>Fecha: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fechay; ?>" required>
            <label>Precio Costo</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="costo" id="costo" value="<?php echo $costo; ?>" required> 
                <span class="add-on">.00</span>
            </div>
            
        </td>
    	<td width="28%">
        	<label>Presio Mayoreo: </label>
             <div class="input-prepend input-append">
                <span class="add-on">$</span>
            	<input type="text" name="mayor" id="mayor" value="<?php echo $mayor; ?>" required>
                <span class="add-on">.00</span>
            </div>
            
            <label>Cantidad Actual: </label><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" required>
            <label>Cantidad Minima: </label><input type="text" name="minimo" id="minimo" value="<?php echo $minimo; ?>" >
            <label>Seccion del Articulo: </label> 
            <select name="seccion" id="seccion">
            <?php 
				$can=mysql_query("SELECT * FROM seccion where estado='s'");
				while($dato=mysql_fetch_array($can)){
					
			?>
              <option value="<?php echo $dato['id']; ?>" <?php if($seccion==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>
            <label>Precio Venta: </label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="venta" id="venta" value="<?php echo $venta; ?>" required> 
                <span class="add-on">.00</span>
            </div><br><br>
           
            	<button type="submit" class="btn btn-primary"><?php echo $boton; ?></button>
           
        </td>
    	<td width="48%">
       		<center><label>Imagen del Producto</label></center>
            <center>
			<?php
				if (file_exists("articulo/".$codigo.".jpg")){
					echo '<img src="articulo/'.$codigo.'.jpg" width="200" height="200" class="img-polaroid">';
				}else{
                ?> 
                <!-- <img src="" alt=""> -->
                    <!-- echo '<img src="articulo/producto.png" width="200" height="200" class="img-polaroid">'; -->
                <?php
                }
            ?>
                    </center><br>
                    <center><output id="list"></output><br />
                    <input type="file" name="files[]" id="files"></center>
        
        </td>      
	</tr>
    </form>
    </div>
	<?php } ?>  
  </table>
   <?php 
		if(!empty($_POST['nom'])){
			$gnom=$_POST['nom'];		$gprov=$_POST['prov'];			$gcosto=$_POST['costo'];
			$gmayor=$_POST['mayor'];	$gventa=$_POST['venta'];		$gcantidad=$_POST['cantidad'];
			$gminimo=$_POST['minimo'];	$gseccion=$_POST['seccion'];	$gfecha=$_POST['fecha'];
			$gcodigo=$_POST['codigo'];	$gcprov=$_POST['cprov'];
			
			$can=mysql_query("SELECT * FROM producto where cod='$gcodigo'");
			if($dato=mysql_fetch_array($can)){
				$sql="Update producto Set  prov='$gprov',
											cprov='$gcprov',
											nom='$gnom',
											costo='$gcosto',
											mayor='$gmayor',
											venta='$gventa',
											cantidad='$gcantidad',
											minimo='$gminimo',
											seccion='$gseccion',
											fecha='$gfecha'			
							Where cod='$gcodigo'";
				mysql_query($sql);
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Producto / Articulo '.$gnom.' </strong> Actualizado con Exito
					</div>';
				$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$fecha='';$codigo='';$venta='0';$cprov='';
			}else{
				$sql = "INSERT INTO producto (cod, prov, cprov, nom, costo, mayor, venta, cantidad, minimo, seccion, fecha, estado) 
							 VALUES ($gcodigo,'$gprov','$gcprov','$gnom','$gcosto','$gmayor','$gventa','$gcantidad','$gminimo','$gseccion','$gfecha','s')";
				mysql_query($sql);	
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Producto / Articulo '.$gnom.' </strong> Guardado con Exito
						</div>';
			}
			//subir la imagen del articulo
			$nameimagen = $_FILES['imagen']['name'];
			$tmpimagen = $_FILES['imagen']['tmp_name'];
			$extimagen = pathinfo($nameimagen);
			$ext = array("png","jpg");
			$urlnueva = "articulo/".$gcodigo.".jpg";			
			if(is_uploaded_file($tmpimagen)){
				if(array_search($extimagen['extension'],$ext)){
					copy($tmpimagen,$urlnueva);	
				}
			}
		}
		?>
</div>
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
</body>
</html>