<?php
		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$can=mysql_query("SELECT MAX(id)as numero FROM empleado");
		if($dato=mysql_fetch_array($can)){
			$numero=$dato['numero']+1;
		} //genera codigo autimaticamente
		
		$id=''; $nombre='';$apellidos='';$direccion='';$telefono='';$sueldo='';$sexo='';
		if(!empty($_GET['id'])){	
			$id=$_GET['id'];
			$can=mysql_query("SELECT * FROM empleado where id=$id");
			if($dato=mysql_fetch_array($can)){
				$numero=$dato['id'];$nombre=$dato['nombre'];$apellidos=$dato['apellidos'];$direccion=$dato['direccion'];$telefono=$dato['telefono'];$sueldo=$dato['sueldo'];$sexo=$dato['sexo'];
				$boton="Actualizar Empleado";
			}
		}else{//nuevo registro
			$boton="Guardar Empleado";
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crear Proveedor</title>
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

  <?php 
	if(!empty($_POST['nombre'])){
		$id=$_POST['id'];					$direccion=$_POST['direccion'];		$sexo=$_POST['sexo'];
		$nombre=$_POST['nombre'];			$telefono=$_POST['telefono'];		
		$apellidos=$_POST['apellidos'];		$sueldo=$_POST['sueldo'];			
		
		
		$can=mysql_query("SELECT * FROM empleados where id=$id");
		if($dato=mysql_fetch_array($can)){
			if($boton=='Actualizar Proveedor'){
				$xSQL="Update empleado SET  
								nombre =     $nombre,
								apellidos =  $apellidos,
								direccion =  $direccion,
								telefono =   $telefono,
								sueldo =  	 $sueldo,
								sexo =       $sexo
							Where id=$id";
				mysql_query($xSQL);
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Empleado! </strong> Actualizado con Exito
					</div>';
			}		
		}else{
			$sql = "INSERT INTO  empleado (nombre,apellidos,direccion,telefono,sueldo,sexo)
					VALUES ('$nombre','$apellidos','$direccion','$telefono','$sueldo','$sexo');";
			
			mysql_query($sql);	
			echo '	<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">X</button>
					  <strong>Empleado! </strong> Guardado con Exito
					</div>';
			
				$id=''; $nombre='';$apellidos='';$direccion='';$telefono='';$sueldo='';$sexo='';//new dates;
		}
	}
?>
<div align="center">
<div class="control-group info">
<form name="form1" method="post" action="">
  <table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="2"><center><strong>Crear Emleado</strong></center></td>
    </tr>
  <tr>
    <td>
      	<label for="textfield">Numero: </label><input type="text" name="id" id="id" value="<?php echo $numero; ?>" required readonly>
    	<label for="textfield">Nombre: </label><input type="text" name="nombre" id="nombre" value="<?php echo $empresa; ?>" required>
      	<label for="textfield">Apellidos: </label><input type="text" name="apellidos" id="apellidos" value="<?php echo $calle; ?>" required>
        <label for="textfield">Direccion: </label><input type="text" name="direccion" id="direccion" value="<?php echo $cp; ?>" required>
        
			
    	<button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
     	<?php if($boton=='Actualizar Proveedor'){ ?> <a href="crear_proveedor.php" class="btn">Cancelar</a><?php } ?>
		
    </td>
    <td>
    	<label for="textfield">Telefono: </label><input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" required>
    	<label>Sueldo: </label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="sueldo" id="sueldo" value="<?php echo $sueldo; ?>" required>s
                <span class="add-on">.00</span>
            </div>
        <label for="textfield">Sexo: </label>
        <select name="sexo" id="sexo">
        	<option value="H">Hombre</option>
        	<option value="M">Mujer</option>
        </select>
    </td>
  </tr>
</table>
</form>
</div>
</div>
</body>
</html>