<?php
		session_start();
		include('php_conexion.php'); 
		$usu=$_SESSION['username'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cliente</title>
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="ico/favicon.png">

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<table width="100%" border="0">
  <tr>
    <td>
        <div class="btn-group" data-toggle="buttons-checkbox">
          <button type="button" class="btn btn-primary" onClick="window.location='PDFproveedores.php'">Reporte PDF</button>
          <button type="button" class="btn btn-primary" onClick="window.location='crear_proveedor.php'">Ingresar Nuevo</button>
        </div>
    </td>
    <td>
        <div align="right">
      		<form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
              <div class="input-append">
                     <input name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar">
                      <datalist id="characters">
                      <?php
                        $buscar=$_POST['bus'];
                        $can=mysql_query("SELECT * FROM proveedor");	
                        while($dato=mysql_fetch_array($can)){
                            echo '<option value="'.$dato['nom'].'">';
                            echo '<option value="'.$dato['empresa'].'">';
                        }
                      ?>
                      
                       <option value="Bart">
                       <option value="Fred Flinstone">
                  </datalist>
                    <button class="btn" type="submit">Buscar por Nombre!</button>
              </div>
            </form>
    </td>
  </tr>
</table>
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="warning">
    <td colspan="7"><strong><p align="center">Listado de Proveedores</p></strong></td>
  </tr>
  <tr>
    <td width="7%"><strong>RFC</strong></td>
    <td width="19%"><strong>Empresa</strong></td>
    <td width="20%"><strong>Contacto</strong></td>
    <td width="7%"><strong>Estado</strong></td>
    <td width="13%"><strong>Telefono</strong></td>
    <td width="14%"><strong>Celular</strong></td>
    <td width="20%"><strong>Correo</strong></td>
  </tr>
    <?php 
	if(empty($_POST['bus'])){
		$can=mysql_query("SELECT * FROM proveedor");
	}else{
		$buscar=$_POST['bus'];
		$can=mysql_query("SELECT * FROM proveedor where nom LIKE '$buscar%' or empresa LIKE '$buscar%'");
	}	
	while($dato=mysql_fetch_array($can)){
		if($dato['estado']=="n"){
			$estado='<span class="label label-important">Inactivo</span>';
		}else{
			$estado='<span class="label label-success">Activo</span>';
		}				
	?>
  <tr>
    <td><?php echo $dato['rfc']; ?></td>
    <td><a href="crear_proveedor.php?codigo=<?php echo $dato['codigo']; ?>"><?php echo $dato['empresa']; ?></a></td>
    <td><?php echo $dato['nom']; ?></td>
    <td><a href="php_estado_proveedor.php?id=<?php echo $dato['codigo']; ?>"><?php echo $estado; ?></a></td>
    <td><?php echo $dato['tel']; ?></td>
    <td><?php echo $dato['cel']; ?></td>
    <td><?php echo $dato['correo']; ?></td>
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>