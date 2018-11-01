<?php
		session_start();
		include('php_conexion.php'); 
        $usuario = $_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        $id_sucursal = $_SESSION['id_sucursal'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movimientos</title>
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
<table width="100%" border="0" class="table">
<tr>
  <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='movimientos.php'">Lista Movimientos</button>
    </div>
    </td>
</tr>
  <tr class="info">
    <td colspan="4"><center><strong>Nuevo Movimiento</strong></center></td>
  </tr>
   <tr>
    <td colspan="3">
    <?php 
		
		//if(!empty($_POST['ccodigo']) or !empty($_GET['codigo'])){	
			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$codigo='';
			$venta='0';$cprov='';$unidad='';
			$fechax=date("d").'/'.date("m").'/'.date("Y");
			$fechay=date("Y-m-d");

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
				$boton="Guardar Movimiento";
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  Producto / Articulo:<strong> '.$nom.' </strong> codigo<strong> '.$codigo.'
					</strong></div>';	
			}else{
				$boton="o";
			}
	?>
    </td>    
    <div class="control-group info">
    <tr>
        <td width="14%">
            <form name="form1" method="get" action="">
                <label>Nombre de Producto: </label>
                <label>
                  <input type="text" autofocus class="input-xlarge" id="nombre" name="nombre" list="characters" placeholder="Nombre del producto" autocomplete="off">
                      <datalist id="characters" >
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
            <input type="hidden" name="nom" id="nom" style="visibility:hidden" value="<?php echo $nom; ?>" >

            <?php if ($_SESSION['tipo_usu'] == 'a') { ?>
            <label>Precio Costo</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="costo" id="costo" value="<?php echo $costo; ?>" readonly>
                <span class="add-on">.00</span>
            </div>

            <label>Precio Mayoreo: </label>
             <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="mayor" id="mayor" value="<?php echo $mayor; ?>" readonly>
                <span class="add-on">.00</span>
            </div>
            <?php } ?>

            <label>Precio Venta: </label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="venta" id="venta" value="<?php echo $venta; ?>"readonly>
                <span class="add-on">.00</span>
            </div>
            <br><br>
            <?php if ($boton != "o") { ?>
                <button type="submit" class="btn btn-large btn-primary"><?php echo $boton; ?></button>
             <?php } ?>
        </td>
        <td width="28%">
            <label>Fecha de Movimiento: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fechay; ?>" required>
            <label>Cantidad Actual: </label>
            <div class="input-prepend input-append">
            <input type="text" name="cantact" id="cantact" value="<?php echo $cantidad; ?>" required maxlength="25" readonly>
            <span class="add-on"><?php echo $textounidad; ?>'s</span>
            </div>
            <label>* Sucursal:</label>
            <select name="sucursal" id="sucursal">
            <?php
                $can=mysql_query("SELECT * FROM empresa WHERE id != '$id_sucursal'");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id']; ?>"><?php echo $dato['empresa']; ?></option>
            <?php } ?>
            </select>
            <!-- <?php if ($tipo_comision == "TELEFONO") {  ?>
            
            <?php } ?> -->

            
            <!-- <br> -->
            
            <!-- <br> -->

            <label <?php if ($tipo_comision == 'TELEFONO' OR $tipo_comision == 'CHIP' OR $tipo_comision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>>* Cantidad a Mover: </label>
                <input type="text" name="cantidad" id="cantidad" value="0" required maxlength="25" <?php if ($tipo_comision == 'TELEFONO' OR $tipo_comision == 'CHIP' OR $tipo_comision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>>
        </td>
        <td width="48%">
            <label    id="lidentifi" for="textfield" <?php if ($tipo_comision != 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?> >IDENTIFICADOR: </label>
            <textarea name="identifi" id="identifi" cols="15" rows="8" value="" <?php if ($tipo_comision != 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea>
            <label    id="limei" for="textfield" <?php if ($tipo_comision != 'TELEFONO') { echo 'style="display:none;visibility:hidden;"'; } ?> >IMEI: </label>
            <textarea name="imei" id="imei" cols="15" rows="8" value="" <?php if ($tipo_comision != 'TELEFONO') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea>
            <label    id="liccid" for="textfield" <?php if ($tipo_comision != 'TELEFONO' and $tipo_comision != 'CHIP') { echo 'style="display:none;visibility:hidden;"'; } ?>>ICCID: </label>
            <textarea name="iccid" id="iccid" cols="15" rows="8" value="" <?php if ($tipo_comision != 'TELEFONO' and $tipo_comision != 'CHIP') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea>
        </td>
	</tr>
    </form>
</div>
<?php //} ?>  
</table>
   <?php 
        $imei = $_POST['imei'];
        $iccid = $_POST['iccid'];
        $identifi = $_POST['identifi'];
        #identiticadores unicos
            $imeis  = explode("\n", $imei);
            $iccids = explode("\n", $iccid);
            $identifis = explode("\n", $identifi);
        #fin identificadores unicos
		if(!empty($_POST['codigo']) AND (!empty($_POST['cantidad']) OR count($imeis) > 0 OR count($imeis) > 0 OR count($imeis) > 0) ){
            $can=mysql_query("SHOW TABLE STATUS LIKE 'movimiento'");
            if($dato=mysql_fetch_array($can)){
                $id_movimiento=$dato['Auto_increment'];
            }
			$gnom=$_POST['nom'];		$gfecha=$_POST['fecha'];
			$gcodigo=$_POST['codigo'];
            $id_sucursalfin = $_POST['sucursal']; //id de sucursal entrada
                $conticcid=0;
                $contimei=0;
                $contidentifi=0;
            #foreach identificador iccid
                foreach ($iccids as &$identificador) {
                    
                    //$identificador = $imeis($i);//$_POST['identificador'];
                    $identificador = trim($identificador);
                    $consulta = "SELECT * FROM codigo_producto where identificador = '$identificador' AND id_sucursal = '$id_sucursal'";
                    $queryi=mysql_query($consulta);
                    if($row=mysql_fetch_array($queryi)){
                        if (!empty($identificador)) {
                        $sqlc = "INSERT INTO codigo_producto_temp (identificador,id_sucursal,id_movimiento)
                                        VALUES ('$identificador','$id_sucursalfin','$id_movimiento')";
                        $answ = mysql_query($sqlc);
                        $conticcid++;
                        }
                    }else {
                        if (!empty($identificador)) {
                            echo '  <div class="alert alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>! Identificador ICCID '.$identificador.' No Existente ¡</strong>
                                    </div>';
                        }
                    }
                }
            #fin foreach identificador iccid
            #foreach identificador imei
                        
                foreach ($imeis as &$identificador) {

                    //$identificador = $iccids($i);//$_POST['identificador'];
                    $identificador = trim($identificador);
                    $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                    if($row=mysql_fetch_array($queryi)){
                        
                        if (!empty($identificador)) {
                            $sqlc = "INSERT INTO codigo_producto_temp (identificador,id_sucursal,id_movimiento)
                                        VALUES ('$identificador','$id_sucursalfin','$id_movimiento')";
                            $answ = mysql_query($sqlc);
                            $contimei++;
                        }
                    }else {
                        if (!empty($identificador)) {
                            echo '  <div class="alert alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>! Identificador IMEI '.$identificador.' No Existente ¡</strong>
                                    </div>';
                        }
                    }
                }
            #fin foreach identificador imei
            #foreach identificador unico
                        
                foreach ($identifis as &$identificador) {

                    //$identificador = $iccids($i);//$_POST['identificador'];
                    $identificador = trim($identificador);
                    $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                    if($row=mysql_fetch_array($queryi)){
                        if (!empty($identificador)) {
                            $sqlc = "INSERT INTO codigo_producto_temp (identificador,id_sucursal,id_movimiento)
                                        VALUES ('$identificador','$id_sucursalfin','$id_movimiento')";
                            $answ = mysql_query($sqlc);
                            $contidentifi++;
                        }
                    }else {
                        if (!empty($identificador)) {
                            echo '  <div class="alert alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>! Identificador unico '.$identificador.' No Existente ¡</strong>
                                    </div>';
                        }
                    }
                }
            #fin foreach identificador unico

            if ($_POST['cantact'] >= $_POST['cantidad']) { //debe existir una cantidad a mover asi como el codigo
                $gcantidad=$_POST['cantact']-$_POST['cantidad'];//cantidad a restar en almacen
            $ncantidad=$_POST['cantidad']; // cantidad a aumentar en sucursal
            $cantidad_mover = $_POST['cantidad']; //cantidad que se registra en movimiento
            if ($tipo_comision == "TELEFONO") {
                $cantidad_mover = $contimei;
            }
            if ($tipo_comision == "CHIP") {
                $cantidad_mover = $conticcid;
            }
            if ($tipo_comision == "FICHA") {
                $cantidad_mover = $contidentifi;
            }
            $can=mysql_query("SELECT * FROM producto where cod='$gcodigo' AND id_sucursal = '$id_sucursalfin'");
                if($dato=mysql_fetch_array($can)){
                    $ncantidad = $ncantidad+$dato['cantidad'];
                    $sqli = "INSERT INTO movimiento (tipo,id_suc_salida,id_suc_entrada,usu_salida,id_producto,cantidad,fecha,estado)
                         VALUES ('traslado','$id_sucursal','$id_sucursalfin','$usuario','$gcodigo','$cantidad_mover',NOW(),'1')";/*'$gfecha'*/
                    $answer = mysql_query($sqli);
                    if ($answer == 1) {
                        /*$sql="UPDATE producto SET  cantidad='$gcantidad',
                                                fecha='$gfecha'
                                          WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                                          mysql_query($sql);
                    $sql2="UPDATE producto SET  cantidad='$ncantidad',
                                            fecha='$gfecha'
                                      WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursalfin'";
                    mysql_query($sql2);*/
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Movimiento / Articulo '.$gnom.' </strong> Cantidad: '.$cantidad_mover.' Registrado con Exito!
                        </div>';
                    $prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$fecha='';
                    $codigo='';$venta='0';$cprov='';$costo = "";$mayor = "";$venta ="";
                    }
            }else{
                echo '  <div class="alert alert-warning">
                          <button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Esta sucursal no Cuenta con este Producto</strong>
                        </div>';
            }
            }else {
                echo '  <div class="alert alert-warning">
                          <button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>La cantidad Actual no es Sufuciente</strong>
                        </div>';   
            }
		}
		?>
</div>

</body>
</html>