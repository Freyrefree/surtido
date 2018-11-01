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
    <title>Listado Comisiones</title>
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
<table width="100%" border="0">
  <tr>
    <!-- reportes y pdf -->
    <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <!-- <button type="button" class="btn btn-primary" onClick="window.location='PDFproducto.php'">Reporte PDF</button> -->
        <button type="button" class="btn btn-primary" onClick="window.location='crear_comision.php'">Nueva Comision</button>
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
                $can=mysql_query("SELECT * FROM comision");
                while($dato=mysql_fetch_array($can)){
                    echo '<option value="'.$dato['nombre'].'">';
                }
              ?>
            </datalist>
            <button class="btn" type="submit">Buscar por Nombre!</button>
      </div>
    </form>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="7"><center><strong>Listado de Comisiones</strong></center></td>
  </tr>
  <tr>
    <td width="3%"><strong>ID</strong></td>
    <td width="10%"><strong>Nombre</strong></td>
    <td width="7%"><strong>Tipo</strong></td>
    <td width="7%"><strong>% Porcentaje Público</strong></td>
    <td width="7%"><strong>% Porcentaje Mayoreo</strong></td>
    <td width="7%"><strong>% Porcentaje Especial</strong></td>
    <td width="20%"><strong>Descripcion</strong></td>
  </tr>
    <?php 
	if(empty($_POST['bus'])){
		$can=mysql_query("SELECT * FROM comision");
	}else{
		$buscar=$_POST['bus'];
		$can=mysql_query("SELECT * FROM comision where nombre LIKE '$buscar%'");
	}	
	while($dato=mysql_fetch_array($can)){
		$codigo=$dato['id_comision'];
	?>
  <tr>
    <td><?php echo $codigo; ?></td>
    <td><a href="crear_comision.php?codigo=<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?> </a></td>
    <td><?php echo $dato['tipo']; ?></td>
    <td><?php echo $dato['porcentaje']. "%"; ?></td>
    <td><?php echo $dato['porcentajemayoreo']. "%"; ?></td>
    <td><?php echo $dato['porcentajeespecial']. "%"; ?></td>
    <td><?php echo $dato['descripcion']; ?></td>
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>