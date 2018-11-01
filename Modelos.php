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
    <title>Modelo</title>
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
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td><center><strong>Administrar Modelos</strong></center></td>
  </tr>
  <td>
<table width="80%" border="0">
  <tr>
    <td width="48%" colspan="2">
    <div style="width: 90%; height: 250px; overflow-y: scroll;">
    <table width="80%" border="0" class="table">
      <tr>
        <td width="8%"><strong><center>ID</center></strong></td>
        <td width="40%"><strong>Nombre</strong></td>
        <td width="40%"><strong>Marca</strong></td>
        <td width="38%"><center><strong>Estado</strong></center></td>
      </tr>
      <?php 
		$can=mysql_query("SELECT * FROM modelo");
		while($dato=mysql_fetch_array($can)){
			$nombre=$dato['nombre'];
			$id=$dato['id_modelo'];
            $id_marca = $dato['id_marca'];
            $can2=mysql_query("SELECT * FROM marca WHERE id_marca = '$id_marca'");
            while($dato2=mysql_fetch_array($can2)){
                $marca = $dato2['nombre'];
            }
			if($dato['estado']=="n"){
				$estado='<span class="label label-important">Inactivo</span>';
			}else{
				$estado='<span class="label label-success">Activo</span>';
			}
	  ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><a href="seccion.php?codigo=<?php echo $id; ?>"><?php echo $nombre; ?></a></td>
        <td><?php echo $marca; ?></td>
        <td><center><a href="php_estado_seccion.php?id=<?php echo $id; ?>"><?php echo $estado; ?></a></center></td>
      </tr>
      <?php } ?>
    </table>
    </div>
    </center>
    </td>
    <td width="4%">&nbsp;</td>
    <td width="48%">
   
    <?php 
		if(empty($_GET['codigo'])){
			$can=mysql_query("SELECT MAX(id_modelo) as numero FROM modelo");
			if($dato=mysql_fetch_array($can)){
				$s_codigo=$dato['numero']+1;
				$s_nombre="";
				$boton="Guardar Modelo";
			}
		}else{
			$s_codigo=$_GET['codigo'];
			$can=mysql_query("SELECT * FROM modelo WHERE id_modelo=$s_codigo");
			if($dato=mysql_fetch_array($can)){
				$s_nombre=$dato['nombre'];
                $s_idmarca=$dato['id_marca'];
			}
			$boton="Actualizar Modelo";
		}
		
	?>
    <div class="control-group info">
    <form name="form1" method="post" action="">
        <label for="textfield">Codigo:</label>
        <input type="text" name="s_codigo" id="s_codigo" value="<?php echo $s_codigo; ?>" readonly>
        <label>* Marca:</label>
            <select name="marca" id="marca">
            <?php 
                $can=mysql_query("SELECT * FROM marca where estado='s'");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id_marca']; ?>" <?php if($s_idmarca==$dato['id_marca']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>
        <label for="textfield2">Nombre</label>
        <input type="text" name="s_nombre" id="s_nombre" value="<?php echo $s_nombre; ?>" required><br><br>
        <button tabindex="submit" class="btn btn-primary"><?php echo $boton; ?></button>
         <?php if($boton=='Actualizar Seccion'){ ?> <a href="seccion.php" class="btn">Cancelar</a><?php } ?>
    </form>
    </div>
    <?php
	if(!empty($_POST['s_nombre'])){
		$ss_codigo=$_POST['s_codigo'];	$ss_nombre=$_POST['s_nombre']; $ss_idmarca=$_POST['marca'];
		$can=mysql_query("SELECT * FROM modelo WHERE id_modelo=$ss_codigo");
		if($dato=mysql_fetch_array($can)){
		//actualizar seccion
			$xSQL="Update modelo Set nombre='$ss_nombre', id_marca = '$ss_idmarca' Where id_marca=$ss_codigo";
			mysql_query($xSQL);
			echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Modelo!</strong> Actualizado con Exito <a href="Modelos.php">[Clic Para Actualizar]</a>
					</div>';
		}else{
		//guardar seccion
			$sql="INSERT INTO modelo (nombre, id_marca, estado) VALUES ('$ss_nombre','$ss_idmarca','s')";
				mysql_query($sql);
			echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Modelo!</strong> Guardado con Exito <a href="Modelos.php">[Clic Para Actualizar]</a>
					</div>';
		}
	}
	?>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>
</div>
</body>
</html>