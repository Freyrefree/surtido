<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $usuario_a = $_SESSION['tipo_usu'];
       
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Solicitudes</title>
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
        <!-- <button type="button" class="btn btn-primary" onClick="window.location='PDFusuarios.php'">Reporte PDF</button> -->
        <button type="button" class="btn btn-primary" onClick="window.location='crear_solicitud.php'">Ingresar Nuevo</button>
    </div>
    </td>
    <td>
    <div align="right">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-append">
            <input type="date" name="inicio" id="inicio">
            <input type="date" name="fin" id="fin">
            <?php 
                $datestart  = $_POST['inicio'];
                $datefinish = $_POST['fin'];
             ?>
            <button class="btn" type="submit">Buscar por Fechas</button>
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
    <td colspan="8"><center><strong>Listado de Solicitudes</strong></center></td>
  </tr>
  <tr>
    <td width="6%"><strong>ID</strong></td>
    <td width="15%"><strong>Producto/Servicio</strong></td>
    <td width="6%"><strong>Solicitante</strong></td>
    <td width="6%"><strong>Sucursal</strong></td>
    <td width="10%"><strong>Marca</strong></td>
    <td width="10%"><strong>Especificación</strong></td>
    <td width="10%"><strong>Fecha</strong></td>
    <td width="8%"><strong>Cantidad</strong></td>
  </tr>
    <?php 
    if(empty($_POST['inicio']) && empty($_POST['inicio'])){
      if($usuario_a == 'a'){
        $can=mysql_query("SELECT * FROM solicitud  ORDER BY fecha DESC, id_solicitud DESC");

      }else{
        $can=mysql_query("SELECT * FROM solicitud WHERE id_sucursal = '$id_sucursal' ORDER BY fecha DESC, id_solicitud DESC");
      }
      }else{
        $datestart  = $_POST['inicio'];
        $datefinish = $_POST['fin'];
        if($usuario_a == 'a')
        {
          $can=mysql_query("SELECT * FROM solicitud where fecha BETWEEN '".$datestart."' AND '".$datefinish."' ");
        }else{
        $can=mysql_query("SELECT * FROM solicitud where fecha BETWEEN '".$datestart."' AND '".$datefinish."' AND id_sucursal = '$id_sucursal'");
        }
      }
    while($dato=mysql_fetch_array($can)){
      $idempresa = $dato['id_sucursal'];
      $query=mysql_query("SELECT empresa FROM empresa WHERE  id = '$idempresa'");
      $dato2=mysql_fetch_array($query);
      $nombreempresa=$dato2['empresa'];
    ?>
  <tr>
    <td><?php echo $dato['id_solicitud']; ?></td>
    <td>
        <a href="crear_solicitud.php?codigo=<?php echo $dato['id_solicitud']; ?>"><?php echo $dato['producto']; ?></a>
    </td>
    <td><?php echo $dato['usuario']; ?></td>
    <td><?php echo $nombreempresa; ?></td>
    <td><?php echo $dato['marca']; ?></td>
    <td><?php echo $dato['especificacion']; ?></td>
    
    <td><?php echo $dato['fecha']; ?></td>
    <td><?php echo $dato['cantidad']; ?></td>
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>