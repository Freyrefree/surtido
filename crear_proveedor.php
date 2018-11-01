<?php
		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		/*$can=mysql_query("SELECT MAX(codigo)as numero FROM proveedor");
		if($dato=mysql_fetch_array($can)){
			$numero=$dato['numero']+1;
		}*/ //genera codigo autimaticamente
		
		$contacto='';$correo='';$celular='';
		$empresa=''; $calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono=''; //new dates;
		if(!empty($_GET['codigo'])){
			$codigo=$_GET['codigo'];
			$can=mysql_query("SELECT * FROM proveedor where codigo=$codigo");
			if($dato=mysql_fetch_array($can)){//actualizacion de datos (obtencion)
				
				$contacto=$dato['nom'];$correo=$dato['correo'];$celular=$dato['cel'];$pais=$dato['pais'];$rfc=$dato['rfc'];$regimen=$dato['regimen'];
				$empresa=$dato['empresa'];$calle=$dato['calle'];$cp=$dato['cp'];$colonia=$dato['colonia'];$estado=$dato['lestado'];$municipio=$dato['ciudad'];$next=$dato['next'];$nint=$dato['nint'];$telefono=$dato['tel'];
				$boton="Actualizar Proveedor";
			}
		}else{//nuevo registro
			$boton="Guardar Proveedor";
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
    <style>
	input{
        text-transform:uppercase;
    }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

  <?php 
	if(!empty($_POST['empresa'])){

		$rfc=strtoupper($_POST['rfc']);					$calle=strtoupper($_POST['calle']);
		$empresa=strtoupper($_POST['empresa']);			$cp=strtoupper($_POST['cp']);				
		$contacto=strtoupper($_POST['contacto']);		$next=strtoupper($_POST['next']);
		$pais=strtoupper($_POST['pais']);       		$nint=strtoupper($_POST['nint']);
		$estado=strtoupper($_POST['estado']);			$correo=$_POST['correo'];
		$municipio=strtoupper($_POST['municipio']);		$telefono=$_POST['telefono'];
		$colonia=strtoupper($_POST['colonia']);			$celular=$_POST['celular'];
		$regimen=strtoupper($_POST['regimen']);
		
				
		$can=mysql_query("SELECT * FROM proveedor where codigo=$codigo");
		if($dato=mysql_fetch_array($can)){
			if($boton=='Actualizar Proveedor'){
				$xSQL="UPDATE proveedor SET  
								empresa =  	 '$empresa',
								calle =    	 '$calle',
								cp =       	 '$cp',
								colonia =  	 '$colonia',
								lestado =    '$estado',
								ciudad =     '$municipio',
								next =       '$next',
								nint =       '$nint',
								regimen =    '$regimen',
								tel =   	 '$telefono',
								cel = 	 	 '$celular',
								correo =	 '$correo',
								nom =	 	 '$contacto',
								pais = 		 '$pais'
							WHERE codigo=$codigo";
				mysql_query($xSQL);
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Proveedor! </strong> Actualizado con Exito
					</div>';
			}		
		}else{
			$sql = "INSERT INTO  proveedor (rfc,empresa,calle,cp,colonia,lestado,ciudad,next,nint,regimen,tel,cel,correo,nom,pais,estado)
					VALUES ('$rfc','$empresa','$calle','$cp','$colonia','$estado','$municipio','$next','$nint','$regimen','$telefono','$celular','$correo','$contacto','$pais','s');";
			mysql_query($sql);	
			echo '	<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">X</button>
					  <strong>Proveedor! </strong> Guardado con Exito
					</div>';
				$contacto='';$correo='';$celular='';
				$empresa=''; $rfc='';$calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono=''; //new dates;
		}
	}
?>
<div align="center">
<div class="control-group info">
<form name="form1" method="post" action="">
  <table width="80%" border="0" class="table">
  <tr class="warning">
    <td colspan="2"><center><strong>Crear Proveedor</strong></center></td>
    </tr>
  <tr>
    <td>
    <?php 
    	if(!empty($_GET['codigo'])){
    		?><label for="textfield">* RFC: </label><input type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15" required ><?php
    	}else{
    		?><label for="textfield">* RFC: </label><input type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15" required><?php
    	}
     ?>
    	<label for="textfield">* Empresa/Razon social: </label><input type="text" name="empresa" id="empresa" value="<?php echo $empresa; ?>" required maxlength="100">
        <label for="textfield">Pais: </label><input type="text" name="pais" id="pais" value="<?php echo $pais; ?>" maxlength="30">
        <label for="textfield">Estado: </label><input type="text" name="estado" id="estado" value="<?php echo $estado; ?>" maxlength="50">
        <label for="textfield">Municipio: </label><input type="text" name="municipio" id="municipio" value="<?php echo $municipio; ?>" maxlength="50">
        <label for="textfield">Colonia: </label><input type="text" name="colonia" id="colonia" value="<?php echo $colonia; ?>" maxlength="50">
    	<label for="textfield">* Calle: </label><input type="text" name="calle" id="calle" value="<?php echo $calle; ?>" required maxlength="100">
        <label for="textfield">* Codigo Postal: </label><input type="text" name="cp" id="cp" value="<?php echo $cp; ?>" required maxlength="10">
      	
		<br>
    	<button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
     	<?php if($boton=='Actualizar Proveedor'){ ?> <a href="crear_proveedor.php" class="btn btn-large">Cancelar</a><?php } ?>

    </td>
    <td>
        <label for="textfield">N. Ext: </label><input type="text" name="next" id="next" value="<?php echo $next; ?>" maxlength="10">
        <label for="textfield">N. Int: </label><input type="text" name="nint" id="nint" value="<?php echo $nint; ?>" maxlength="10">
        <label for="textfield">* Correo: </label><input type="email" name="correo" id="correo" value="<?php echo $correo; ?>" required>
    	<label for="textfield">* Contacto: </label><input type="text" name="contacto" id="contacto" value="<?php echo $contacto; ?>" required maxlength="50">
        <label for="textfield">* Telefono: </label><input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" required maxlength="20">
        <label for="textfield">* Celular: </label><input type="text" name="celular" id="celular" value="<?php echo $celular; ?>" required maxlength="20">
        <label for="textfield">Regimen: </label><input type="text" name="regimen" id="regimen" value="<?php echo $regimen; ?>">
    </td>
  </tr>
</table>
</form>
</div>
</div>
</body>
</html>