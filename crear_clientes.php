<?php
		session_start();
		include('php_conexion.php'); 
		
		$usu=$_SESSION['username'];
		$tipo_usu=$_SESSION['tipo_usu'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		$contacto='';$correo='';$celular='';$estatus = '';
        $empresa=''; $calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono=''; //new dates;
		if(!empty($_GET['codigo'])){
            
            $codigo=$_GET['codigo'];
            
			$can=mysql_query("SELECT * FROM cliente where codigo = '$codigo'");
			if($dato=mysql_fetch_array($can)){
                $rfc=$dato['rfc'];
                $contacto=$dato['nom'];
                $apaterno=$dato['apaterno'];
                $amaterno=$dato['amaterno'];                
                $correo=$dato['correo'];
                $telefono=$dato['tel'];
                $celular=$dato['cel'];
                $empresa= explode(" ",$dato['empresa']);                
                $pais=$dato['pais'];
                $estado=$dato['estado'];
                $municipio=$dato['municipio'];
                $colonia=$dato['colonia'];
                $cp=$dato['cp'];
                $next=$dato['next'];
                $nint=$dato['nint'];
                $regimen=$dato['regimen'];
                $calle=$dato['calle'];
                $fecha=$dato['fecha'];
                
                $nomb = $empresa[0];$apat = $empresa[1];$amat = $empresa[2];
                $boton="Actualizar Cliente";
                //echo $codigo;	
			}
		}else{
			$boton="Guardar Cliente";
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
    <style>
    /* style="text-transform:uppercase;" */
    input{
        text-transform:uppercase;
    }

    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

  <?php 
	if(!empty($_POST['apat'])){

	        $calle=strtoupper($_POST['calle']);
            $cp=strtoupper($_POST['cp']);
            $next=strtoupper($_POST['next']);
            $pais=strtoupper($_POST['pais']);               $nint=strtoupper($_POST['nint']);
            $estado=strtoupper($_POST['estado']);           $correo=strtoupper($_POST['correo']);
            $municipio=strtoupper($_POST['municipio']);     $telefono=strtoupper($_POST['telefono']);
            $colonia=strtoupper($_POST['colonia']);         $celular=strtoupper($_POST['celular']);
            $estatus = "s";                                 $regimen=strtoupper($_POST['regimen']);
      
            $paterno = strtoupper($_POST['apat']);
            $materno = strtoupper($_POST['amat']);
            $nombre  = strtoupper($_POST['nomb']);

            $rfcpaterno = substr($paterno, 0, 2);
            $rfcmaterno = substr($materno, 0, 1);
            $rfcnombre  = substr($nombre , 0, 1);

            $first_part = $rfcpaterno.$rfcmaterno.$rfcnombre;
            $fecha   = explode("-", $_POST['fecha']);
            $secon_part = substr($fecha[0], -2).$fecha[1].$fecha[2];
            $rfc = $first_part.$secon_part;
            $empresa = strtoupper($_POST['nomb']." ".$_POST['apat']." ".$_POST['amat']);
            $contacto=strtoupper($_POST['nomb']);/*$_POST['contacto']*/
            $fech = $_POST['fecha'];
        /*}*/
        $can=mysql_query("SELECT * FROM cliente where rfc='$rfc'");
		if($dato=mysql_fetch_array($can)){
			if($boton=='Actualizar Cliente'){
				$xSQL="UPDATE cliente SET   
                nom =        '$contacto',
                empresa =    '$empresa',
                apaterno = '$paterno',
                amaterno = '$materno',
                correo =     '$correo',
                tel =        '$telefono',
                cel =        '$celular',
                pais =       '$pais',
                estado =     '$estado',
                municipio =  '$municipio',
                colonia =    '$colonia',
                cp =         '$cp',
                next =       '$next',
                nint =       '$nint',
                regimen =    '$regimen',
                calle =      '$calle',
                fecha =      '$fech'                             
                Where codigo='$codigo'";

				mysql_query($xSQL);
                echo '	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Cliente / Cliente!</strong> Actualizado con Exito</div>';
                        }else{
                            echo '	<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de RFC ingreso le pertenece al cliente '.$dato['nom'].'</div>';
			}		
		}else{
                $sql = "INSERT INTO cliente (rfc,nom,apaterno,amaterno,correo,tel,cel,empresa,pais,estado,municipio,colonia,cp,next,nint,regimen,calle,estatus,fecha)
                VALUES ('$rfc','$nombre','$paterno','$materno','$correo','$telefono','$celular','$empresa','$pais','$estado','$municipio','$colonia','$cp','$next','$nint','$regimen','$calle','s','$fech');";
				mysql_query($sql);
                
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Cliente / Cliente!</strong> Guardado con Exito</div>';/*}*/
				$contacto='';$correo='';$celular='';$estatus ='';
                $empresa='';$rfc=''; $calle='';$cp='';$colonia='';$estado='';$municipio='';$next='';$nint='';$pais='';$regimen='';$telefono='';
          }
      }
?>

<div class="control-group info">
  <form name="form1" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="warning">
    <td colspan="2"><center><strong>Nuevo Cliente</strong></center></td>
  </tr>
  <tr>
    <td>
    <?php 
        if(!empty($_GET['codigo'])){
            ?><label for="textfield"> RFC / CURP: </label><input type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15" readonly><?php
        }else{
            ?><label for="textfield"> RFC / CURP: </label><input type="text" name="rfc" id="rfc" value="<?php echo $rfc; ?>" maxlength="15"><?php
        }
     ?>
        <!-- <label for="textfield">* Razon social / Nombre: </label><input type="text" name="empresa" id="empresa" value="<?php echo $empresa; ?>" maxlength="50"> --><!-- onkeyup="javascript:this.value=this.value.toUpperCase();" -->
        <label for="textfield">* Apellido Paterno: </label><input type="text" name="apat" id="apat" value="<?php echo $apaterno; ?>" maxlength="20" required>
        <label for="textfield">* Apellido Materno: </label><input type="text" name="amat" id="amat" value="<?php echo $amaterno; ?>" maxlength="20" required>
        <label for="textfield">* Nombre: </label><input type="text" name="nomb" id="nomb" value="<?php echo $contacto; ?>" maxlength="20" required>
        <label for="textfield">* Fecha de Nacimiento: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>" required>
        <label for="textfield">Lugar de Nacimiento: </label><input type="text" name="pais" id="pais" value="<?php echo $pais; ?>" maxlength="20">
        <label for="textfield">Estado: </label><input type="text" name="estado" id="estado" value="<?php echo $estado; ?>" maxlength="30">
        <label for="textfield">Municipio: </label><input type="text" name="municipio" id="municipio" value="<?php echo $municipio; ?>" maxlength="50">
        <label for="textfield">Colonia: </label><input type="text" name="colonia" id="colonia" value="<?php echo $colonia; ?>" maxlength="100">
        <label for="textfield">Calle: </label><input type="text" name="calle" id="calle" value="<?php echo $calle; ?>" maxlength="100">
        <label for="textfield">Codigo Postal: </label><input type="text" name="cp" id="cp" value="<?php echo $cp; ?>" maxlength="10">
        <br>

        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Cliente'){ ?> <a href="crear_clientes.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>
    	<label for="textfield">N. Ext: </label><input type="text" name="next" id="next" value="<?php echo $next; ?>" maxlength="10">
        <label for="textfield">N. Int: </label><input type="text" name="nint" id="nint" value="<?php echo $nint; ?>" maxlength="10">
        <label for="textfield">Correo: </label><input type="email" name="correo" id="correo" value="<?php echo $correo; ?>" >
        <label for="textfield">Contacto / Negocio: </label><input type="text" name="contacto" id="contacto" value="<?php echo $contacto; ?>" maxlength="50">
        <label for="textfield">Teléfono de contacto: </label><input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" maxlength="10">
        <label for="textfield">Número de Recargas: </label><input type="text" name="celular" id="celular" value="<?php echo $celular; ?>" maxlength="10" pattern="[0-9]{10}">
        <label for="textfield">Regimen: </label><input type="text" name="regimen" id="regimen" value="<?php echo $regimen; ?>" maxlength="50">
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