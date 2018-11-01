<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
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
        <button type="button" class="btn btn-primary" onClick="window.location='nuevo_movimiento.php'">Nuevo Movimiento</button>
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
    <td colspan="9"><center><strong>Traslado/Productos</strong></center></td>
  </tr>
  <tr>
    <td width="2%"><strong>ID</strong></td>
    <td width="6%"><strong>PRODUCTO</strong></td>
    <td width="2%"><strong>CANTIDAD</strong></td>
    <td width="8%"><strong>SUCURSAL SALIDA</strong></td>
    <td width="8%"><strong>SUCURSAL ENTRANTE</strong></td>
    <td width="5%"><strong>ENCARGADO SALIDA</strong></td>
    <td width="6%"><strong>ENCARGADO ENTRADA</strong></td>
    <td width="5%"><strong>FECHA SALIDA</strong></td>
    <td width="5%"><strong>FECHA ENTRADA</strong></td>
    <td width="5%"><strong>ESTADO</strong></td>
  </tr>
    <?php 
    if(empty($_POST['inicio']) && empty($_POST['fin'])){
        if ($_SESSION['tipo_usu'] == "a") {
            $can=mysql_query("SELECT * FROM movimiento WHERE (id_suc_entrada = '$id_sucursal' OR id_suc_salida = '$id_sucursal') ORDER BY fecha DESC, id_movimiento DESC");
        }else{
            $can=mysql_query("SELECT * FROM movimiento WHERE (id_suc_entrada = '$id_sucursal' OR id_suc_salida = '$id_sucursal') AND estado = '1' ORDER BY fecha DESC, id_movimiento DESC");
        }
    }else{
        $datestart  = $_POST['inicio'];
        $datefinish = $_POST['fin'];
        if ($_SESSION['tipo_usu'] == "a") {
            $can=mysql_query("SELECT * FROM movimiento where fecha BETWEEN '".$datestart."' AND '".$datefinish."' AND (id_suc_entrada = '$id_sucursal' OR id_suc_salida = '$id_sucursal')");
        }else {
            $can=mysql_query("SELECT * FROM movimiento where fecha BETWEEN '".$datestart."' AND '".$datefinish."' AND (id_suc_entrada = '$id_sucursal' OR id_suc_salida = '$id_sucursal') AND estado = '1'");
        }
    }
    while($dato=mysql_fetch_array($can)){
        $cod_producto = $dato['id_producto'];
        $id_sucursal_e = $dato['id_suc_entrada'];
        $id_sucursal_s = $dato['id_suc_salida'];
        $query=mysql_query("SELECT nom FROM producto WHERE cod = '$cod_producto'");
            if($dato1=mysql_fetch_array($query)){
                $producto = $dato1['nom'];
            }
        $query2=mysql_query("SELECT empresa FROM empresa WHERE id = '$id_sucursal_e'");
            if($dato2=mysql_fetch_array($query2)){
                $sucursal_entrada = $dato2['empresa'];
            }
        $query3=mysql_query("SELECT empresa FROM empresa WHERE id = '$id_sucursal_s'");
            if($dato3=mysql_fetch_array($query3)){
                $sucursal_salida = $dato3['empresa'];
            }
        if($dato['estado']=="1"){
            $estado='<span class="label label-important">Pendiente</span>';
        }else{
            $estado='<span class="label label-success">Aceptado</span>';
        }
    ?>
  <tr>
    <td><?php echo $dato['id_movimiento']; ?></td>
    <td><?php echo $producto; ?></td>
    <td><?php echo $dato['cantidad']; ?></td>
    <td><?php echo $sucursal_salida; ?></td>
    <td><?php echo $sucursal_entrada; ?></td>
    <td><?php echo $dato['usu_salida']; ?></td>
    <td><?php echo $dato['usu_entrada']; ?></td>
    <td><?php echo $dato['fecha']; ?></td>
    <td><?php echo $dato['fecha2']; ?></td>
    <?php if ($id_sucursal_s == $id_sucursal) { ?>
        <td><?php echo $estado; ?></td>
    <?php }else { ?>
        <td><a href="php_estado_movimiento.php?id=<?php echo $dato['id_movimiento']; ?>"><?php echo $estado; ?></a></td>
    <?php } ?>
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>