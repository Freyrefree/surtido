<?php
        session_start();
		include('php_conexion.php'); 
		$mensaje="0";
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		if(!empty($_POST['empresa']) and !empty($_POST['nit'])){
			$nameimagen = $_FILES['imagen']['name'];
			$tmpimagen = $_FILES['imagen']['tmp_name'];
			$extimagen = pathinfo($nameimagen);
			$ext = array("png","jpg");
			$urlnueva = "img/logo.png";			
			if(is_uploaded_file($tmpimagen)){
				if(array_search($extimagen['extension'],$ext)){
					copy($tmpimagen,$urlnueva);	
				}
			}
			$nempresa=$_POST['empresa'];		$ndireccion=$_POST['direccion'];		$ntel1=$_POST['telefono'];	$ntel2=$_POST['celular'];
			$ncorreo=$_POST['correo'];			$nweb=$_POST['web'];					$nciudad=$_POST['ciudad'];	$nnit=$_POST['nit'];
			$iva=$_POST['iva'];					$tamano=$_POST['tamano'];
			$xSQL="Update empresa Set empresa='$nempresa',
								  rfc='$nnit',
								  direccion='$ndireccion',
								  ciudad='$nciudad',
								  tel1='$ntel1',
								  tel2='$ntel2',
								  web='$nweb',
								  correo='$ncorreo',
								  iva='$iva',
								  tamano='$tamano'
							Where id=1";
			mysql_query($xSQL);
			$mensaje="1";
		}
			
			$can=mysql_query("SELECT * FROM empresa where id=1");
			if($dato=mysql_fetch_array($can)){
				$empresa=$dato['empresa'];
				$nit=$dato['rfc'];
				$direccion=$dato['direccion'];
				$ciudad=$dato['ciudad'];
				$tel1=$dato['tel1'];
				$tel2=$dato['tel2'];
				$web=$dato['web'];
				$correo=$dato['correo'];
				$tamano=$dato['tamano'];
				if(empty($dato['iva'])){
					$iva="0";
				}else{
					$iva=$dato['iva'];
				}
					
			}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Empresa</title>
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

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<button type="button" class="btn" onClick="window.location='empresa.php'"><i class="icon-fast-backward"></i> Regresar</li></ul></button><br><br>
<table width="80%" border="0" class="table">
  <tr class="info">
    <td><center><strong>Actualizar Datos de la Empresa</strong></center></td>
  </tr>
  <tr>
    <td>

         <form action="" method="post" enctype="multipart/form-data" name="form1">
          	<table width="80%" border="0">
              <tr>
                <td width="31%">
                  	<label for="textfield">Nombre Empresa: </label><input type="text" name="empresa" id="empresa" value="<?php echo $empresa; ?>" required>
                    <label for="textfield">Direccion: </label><input type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>">
                    <label for="textfield">Celular: </label><input type="text" name="celular" id="celular" value="<?php echo $tel2; ?>">
                    <label for="textfield">Correo: </label><input type="text" name="correo" id="correo" value="<?php echo $correo; ?>">
                </td>
                <td width="38%" rowspan="2">
                	<label for="textfield">RFC: </label><input type="text" name="nit" id="nit" value="<?php echo $nit; ?>" required>
                    <label for="textfield">Ciudad: </label><input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>">
                    <label for="textfield">Telefono: </label><input type="text" name="telefono" id="telefono" value="<?php echo $tel1 ?>">
                    <label for="textfield">Pagina Web: </label><input type="text" name="web" id="web" value="<?php echo $web; ?>">
                    <div class="input-append">
                   	 	<label for="textfield">IVA: </label><input type="number" min="0" max="100" name="iva" id="iva" value="<?php echo $iva; ?>">
                   	 	<span class="add-on">%</span>
                    </div><br>
                    <label>Tamaño de Impresion del Ticket</label>
                    <input type="number" min="0" max="100" name="tamano" id="tamano" value="<?php echo $tamano; ?>">
                </td>
                <td width="31%" rowspan="2">
                <center><label for="fileField">Subir Logo Empresarial</label></center>
                <center><img src="img/logo.png" width="200" height="200" class="img-polaroid"></center><br>
                <input type="file" name="imagen" id="imagen">
                </td>
              </tr>
              <tr>
                <td height="85" colspan="3"><button class="btn btn-large btn-primary" type="submit">Actualizar Datos</button></td>
              </tr>
              <tr>
                <td colspan="3">
                	<?php 
						if($mensaje=="1"){
							echo '	<div class="alert alert-success">
										  <button type="button" class="close" data-dismiss="alert">X</button>
										  <strong>Datos de la Empresa! </strong> Actualizado con Exito
									</div>';
						}
					?>
                </td>
              </tr>
            </table>
          </form>
          </div>
        </div>
     </td>
  </tr>
</table>
</body>
</html>