<?php
		session_start();
		include('php_conexion.php'); 
		
		$usu=$_SESSION['username'];
		$tipo_usu=$_SESSION['tipo_usu'];
        //error al inicio de session
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        //inicializa variables a usar
		$cedula='';	$nombre='';$usuario='';$ciudad='';$cupo='0';$direccion='';$telefono='';$celular='';$tipo='cl';$barrio='';	
		if(!empty($_GET['codigo'])){//si el codigo no esta vacio obtiene el codigo	(para realizar una actualizacion)
			$codigo=$_GET['codigo'];
			$can=mysql_query("SELECT * FROM usuarios where ced='$codigo'");
			if($dato=mysql_fetch_array($can)){
				$cedula=$dato['ced'];$nombre=$dato['nom'];$usuario=$dato['usu'];$ciudad=$dato['ciudad'];$cupo=$dato['cupo'];$direccion=$dato['dir'];
				$telefono=$dato['tel'];$celular=$dato['cel'];$tipo=$dato['tipo'];$barrio=$dato['barrio'];
                $boton="Actualizar Usuario";	
			}//actualizacion 
		}else{
			$boton="Guardar Usuario";
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crear Clientes</title>
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

  <?php //si los datos cedula, nombre, usuario, no viene vacios
	if(!empty($_POST['cedula']) and !empty($_POST['nombre']) /*and !empty($_POST['usuario']) and !empty($_POST['tipo'])*/){
		$cedula=$_POST['cedula'];$nombre=$_POST['nombre'];$usuario=$_POST['usuario'];$ciudad=$_POST['ciudad']/*;$cupo=$_POST['cupo']*/;$direccion=$_POST['direccion'];$telefono=$_POST['telefono'];$celular=$_POST['celular'];$tipo="cl";$barrio=$_POST['barrio'];$usuarioc="123456";
        $can=mysql_query("SELECT * FROM usuarios where ced='$cedula'");
		if($dato=mysql_fetch_array($can)){//si existe el registro
			if($boton=='Actualizar Usuario'){ //si el boton actualizar es actualizar manda nuevos datos a la base de datos
				$xSQL="Update usuarios Set  nom='$nombre',dir='$direccion',tel='$telefono',cel='$celular',cupo='$cupo',barrio='$barrio',ciudad='$ciudad',
											tipo='$tipo' Where ced=$cedula";
				mysql_query($xSQL);	
                echo '	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Cliente / Usuario!</strong> Actualizado con Exito</div>';
                          //si la instruccion es corecta mensaje sussesfull
                        }else{ //si el registro existe mensaje error muestra cliente registrado
                            echo '	<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de documento ingreso le pertenece al cliente '.$dato['nom'].'</div>';
			             }		
		}else{ //si no existe el registro nuevo registro
            /*if (preg_match("/\\s/", $usuario))
        { echo '	<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error!</strong> No se permiten espacios en la cuenta de usuario.</div>';
					$usuario='';
                    }else{*/ //validacion si el campo cuanta  usuario esta mal escrita descartado
                        $sql = "INSERT INTO usuarios (ced, estado, nom, dir, tel, cel, barrio, ciudad/*, usu*/, con, tipo) 
							 VALUES ('$cedula','s','$nombre','$direccion','$telefono','$celular','$cupo','$barrio','$ciudad'/*,'$usuario'*/,'$usuarioc','$tipo')";
				mysql_query($sql);
                /*$numero=0;
                $ca=mysql_query("SELECT * FROM permisos_tmp");
                while($dat=mysql_fetch_array($ca)){ 
                    $numero=$numero+1;
					if($tipo=='a' or $tipo=='ca'){
                        if($tipo=='ca'){
                            if($numero==4 or $numero==5 or $numero==6 or $numero==7 or $numero==8 or $numero==14){
								$very=1;}else{
                                    $very=0;}	
                                }else{$very=1;
                                }
                                $sql = "INSERT INTO permisos (usu,per,est) VALUES ('$usuario','$numero','$very')";
						mysql_query($sql);	}
                    }*/
				
				
				$cedula='';	$nombre='';$usuario='';$ciudad='';$cupo='0';$direccion='';$telefono='';$celular='';$tipo='';$barrio='';	
				echo '	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Cliente / Usuario!</strong> Guardado con Exito</div>';/*}*/}}
?>

<div class="control-group info">
  <form name="form1" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="2"><center><strong>Crear Cliente / Usuario</strong></center></td>
  </tr>
  <tr>
    <td>
    	<label for="textfield">RFC:</label>
        <input type="text" name="cedula" id="cedula" <?php if(!empty($cedula)){echo 'readonly';} ?> value="<?php echo $cedula; ?>" autocomplete="off" required>
        <label for="textfield">Nombre y Apellido: </label><input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" required>
        
        <label for="textfield">Ciudad: </label><input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" autocomplete="off" required><br>
        <label for="textfield">C.P.: </label><input type="text" name="cp" id="cp" value="<?php echo $cp; ?>" autocomplete="off" required><br>
        <!-- <div class="input-prepend input-append">
            <label for="textfield">Cupo: </label>
            <span class="add-on">$</span><input type="text" name="cupo" id="cupo" value="<?php echo $cupo; ?>" autocomplete="off" required><span class="add-on">.00</span>
        </div> -->
        <!-- <label for="textfield">Cuenta de Usuario: </label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>" <?php if(!empty($usuario)){echo 'readonly';} ?> autocomplete="off" required> -->
        <?php if($boton=='Actualizar Usuario' and $tipo_usu=='a'){ ?>
        	<a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal">Ver Contraseña</a>
		<?php } ?>
        <br><br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Usuario'){ ?> <a href="crear_clientes.php" class="btn">Cancelar</a><?php }  ?>
    </td>
    <td>
    	<label for="textfield">Direccion: </label><input type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>" autocomplete="off" required>
        <label for="textfield">Barrio / Localidad: </label><input type="text" name="barrio" id="barrio" value="<?php echo $barrio; ?>" autocomplete="off">
        <label for="textfield">Telefono: </label><input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" autocomplete="off" required>
        <label for="textfield">Celular / Mobil: </label><input type="text" name="celular" id="celular" value="<?php echo $celular; ?>" autocomplete="off">
        <!-- <label for="radio">Tipo de Usuario</label>
                  <?php if($tipo_usu=='a'){ ?>
        <label class="radio">
        <input type="radio" name="tipo" id="optionsRadios1" value="a" <?php if($tipo=="a"){ echo 'checked'; } ?>>Administrador</label>
        <?php } ?>
        <label class="radio">
        <input type="radio" name="tipo" id="optionsRadios2" value="cl" <?php if($tipo=="cl"){ echo 'checked'; } if(empty($_GET['codigo'])){ echo 'checked';} ?>>Cliente</label>
        <label class="radio">
        <input type="radio" name="tipo" id="optionsRadios3" value="ca" <?php if($tipo=="ca"){ echo 'checked'; } ?>>Cajera</label> -->
    </td>
  </tr>
</table>
</form>
</div>
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Recordar Contraseña</h3>
            </div>
            <div class="modal-body">
            <p><?php echo $nombre; ?></p>
            <p>Contraseña:<strong> <?php echo $dato['con']; ?></strong></p>
            </div>
            <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
</body>
</html>